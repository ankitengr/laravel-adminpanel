<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Attributes As CurrentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;

class AttributesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $CurrentController = 'attributes';
	protected $IndexTitle = 'Attributes';
	protected $CreateTitle = 'Attribute';
	protected $EditTitle = 'Attribute';
	protected $EditField = 'attribute';
	
    public function index(Request $request)
    {
        //
		if ($request->ajax()) {
			//dd($request);
			$data = CurrentModel::query();
            return Datatables::of($data)
				->addIndexColumn()
				->editColumn('title', function ($data) {
					$allow_edit = true; // This can be used for permission
					if ($allow_edit == 1)
						return '<a href="' . route($this->CurrentController . '.edit', $data->id).'">'.$data->title.'</a>';
					else
						return $data->title;
				})
				
				->editColumn('slug', function ($data) {
					return $data->slug;
				})
				
				->editColumn('description', function ($data) {
					return strlen($data->description) > 50 ? substr($data->description,0,50).' ...' : $data->description;
				})
				
				->editColumn('published', function ($data) {
					if ($data->published == 1) return '<span class="fa fa-check" align="center" Title="Active" style="color:green;"></span>';
					if ($data->published == 0) return '<span class="fa fa-close" align="center" style="color:red;" Title = "In active"></span>';
				})
				
				->addColumn('actions', function($data) {
					$allow_delete = true; // This can be used for permission
					if ($allow_delete == 1) {
						$btn = '';
						//$btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-info btn-sm">View</a>';
                        //$btn = $btn.'<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">Edit</a>';
						$btn = $btn.'<form action="'. route($this->CurrentController . '.destroy', $data->id) . '" onsubmit="return confirm(\'Are you sure?\');" method="POST"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="' . csrf_token() . '"><button class="edit btn btn-danger btn-sm" type="submit">Delete</button></form>';
						return $btn;
					}
					else {
						return '';
					}
				})

				->rawColumns(['title', 'published', 'actions'])   
        
				->make(true);
				
			
        }
		
		
		$fields = [
				['label_text' => 'ID', 'column_name' => 'id'],
				['label_text' => 'Title', 'column_name' => 'title'],
				['label_text' => 'Slug', 'column_name' => 'slug'],
				['label_text' => 'Description', 'column_name' => 'description'],
				['label_text' => 'Published', 'column_name' => 'published'],
				['label_text' => 'Action', 'column_name' => 'actions'],
			];
		
		$params = [
            'title' => $this->IndexTitle,
            'fields' => $fields,
			'controller' => $this->CurrentController,
			'id' => 0
        ];
      
        $theme = $this->theme;
		return view($theme . '.common.datatable', compact('theme', 'params'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        ///Left is Template Position and Details is the group
		$fields['left']['default'] = (object) [
			'group_prop' => [
				'title' => 'Details',
				'Collapse'	=> 'no',
			],
			'fields' => [
				['label_text' => '', 'column_name' => 'title', 'type' => 'string', 'input_type' => 'text', 'validation' => 'required|no', 'pattern' => ''],
				['label_text' => 'Slug', 'column_name' => 'slug', 'type' => 'string', 'input_type' => 'text'],
				['label_text' => 'Description', 'column_name' => 'description', 'type' => 'text', 'input_type' => 'editor',], //textarea or editor
				['label_text' => 'Group', 'column_name' => 'attributes_group_id', 'type' => 'dependent', 'input_type' => 'select', 'display_column' => 'slug', 'dependent_model' => 'App\Model\AttributesGroup',],
			],
		];
			
		$fields['right']['published'] =	(object) [
			'group_prop' =>  [
				'title' => 'Published',
				'collapse'	=> 'no',
			],
			'fields' =>  [
				['label_text' => 'Published', 'column_name' => 'published', 'type' => 'boolean', 'input_type' => 'checkbox', 'order'=>1],
			],
		];
		
		$params = [
            'title' => 'Create '. $this->CreateTitle,
            'fields' => $fields,
			'controller' => $this->CurrentController,
			'id' => 0
        ];
	
		$theme = $this->theme;
        return view($theme . '.common.create_edit',compact('theme', 'params'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
		//dd($request->all());
		$request->merge([
			'slug' => $request->has('slug') && !empty(Str::slug($request->get('slug'))) ? Str::slug($request->get('slug')) : Str::slug($request->get('title')),
			'published' => $request->has('published') ? ($request->get('published')) : 0,
			'description' => $request->has('description') && !empty($request->get('description')) ? ($request->get('description')) : '',
			'attributes_group_id' => $request->has('attributes_group_id') ? ($request->get('attributes_group_id')) : 1,
		]);
		//dd($request->all());
		
		$fields = [
				['column_name' => 'title', 'validation' => 'required|max:255'],
				['column_name' => 'slug', 'validation' => 'required|regex:/^[a-z0-9]+(?:[- ][a-z0-9]+)*$/'],
				['column_name' => 'description'],
				['column_name' => 'published'],
				['column_name' => 'attributes_group_id'],
			];
		
		foreach($fields as $field) {
			if(!empty($field['validation'])) {
				$validate_fields[$field['column_name']] = $field['validation'];
			}
			$data_for_save[$field['column_name']] = $request->{$field['column_name']};
		}
		
		//print_r($data_for_save); die;
		
		$validatedData = $request->validate($validate_fields);
		
		$object = CurrentModel::updateOrCreate(['id' => $request->id], $data_for_save);        
		$nid = $object->id;
   
		$controller = explode('.', $request->route()->getName());
		
		if($request->get('apply_type') == 'apply' && $nid) {
			return redirect()->route($controller[0].'.edit', [$this->EditField => $nid]);
		}
		else {
			return redirect()->route($controller[0].'.index');
		}
        //return response()->json(['success'=>'Data saved successfully.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Attributes  $attributes
     * @return \Illuminate\Http\Response
     */
    public function show(Attributes $attributes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Attributes  $attributes
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
		$result = CurrentModel::find($id);
        //return response()->json($result);
		
		///Left is Template Position and Details is the group
		$fields['left']['details'] = (object) [
			'group_prop' => [
				'title' => 'Details',
				'Collapse'	=> 'no',
			],
			'fields' => [
				['label_text' => '', 'column_name' => 'title', 'type' => 'string', 'input_type' => 'text', 'validation' => 'required|no', 'pattern' => ''],
				['label_text' => 'Slug', 'column_name' => 'slug', 'type' => 'string', 'input_type' => 'text', 'pattern' => ''],
				['label_text' => 'Description', 'column_name' => 'description', 'type' => 'text', 'input_type' => 'editor'], //textarea or editor
				['label_text' => 'Group', 'column_name' => 'attributes_group_id', 'type' => 'dependent', 'input_type' => 'select', 'display_column' => 'slug', 'dependent_model' => 'App\Model\AttributesGroup',],
			],
		];
			
		$fields['right']['published'] =	(object) [
			'group_prop' =>  [
				'title' => 'Details',
				'collapse'	=> 'no',
			],
			'fields' =>  [
				['label_text' => 'Published', 'column_name' => 'published', 'type' => 'boolean', 'input_type' => 'checkbox', 'order'=>1],
			],
		];
		
		$params = [
            'title' => 'Edit '. $this->EditTitle,
            'fields' => $fields,
			'controller' => $this->CurrentController,
			'result' => $result,
			'id' => $id
        ];
		
		$theme = $this->theme;
        return view($theme . '.common.create_edit',compact('theme', 'params'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Attributes  $attributes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attributes $attributes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Attributes  $attributes
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
		$result = CurrentModel::find($id)->delete();
        return response()->json($result);
    }
}
