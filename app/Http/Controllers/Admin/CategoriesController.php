<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Categories As CurrentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;
use App\Traits\AttributesTrait;

class CategoriesController extends Controller
{
    use AttributesTrait;
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $CurrentController = 'categories';
	protected $IndexTitle = 'Categories';
	protected $CreateTitle = 'Category';
	protected $EditTitle = 'Category';
	protected $EditField = 'category';
	
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
	
		//print_r($fields); die;
		
		$parent_category_select_data = CurrentModel::query()->select('id', 'title')->where('published', '=', 1)->pluck('title', 'id') ;
		
		$fields['left']['default'] = (object) [
				'group_prop' => [
					'title' => 'Details',
					'collapse'	=> 0,
				],
				'fields' => [
						['label_text' => '', 'column_name' => 'title', 'type' => 'varchar', 'input_type' => 'text', 'validation' => 'required|no', 'pattern' => ''],
						['label_text' => 'Description', 'column_name' => 'description', 'type' => 'text', 'input_type' => 'editor',], //textarea or editor
						['label_text' => 'Parent Category', 'column_name' => 'parent', 'type' => 'integer', 'input_type' => 'select', 'select_data'=>$parent_category_select_data], 
					],
				];
					
		$fields['right']['published'] =	(object) [
			'group_prop' =>  [
				'title' => 'Published',
				'collapse'	=> 0,
			],
			'fields' =>  [
				['label_text' => 'Published', 'column_name' => 'published', 'type' => 'boolean', 'input_type' => 'checkbox'],
			],
		];
		
		
		
		$fields = $this->getAttributes($this->CurrentController, $fields);
		
		//print_r($fields); die;
		
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
		]);
		
		$fields = [
				['column_name' => 'title', 'validation' => 'required|max:255'],
				['column_name' => 'slug', 'validation' => 'required|regex:/^[a-z0-9]+(?:[- ][a-z0-9]+)*$/'],
				['column_name' => 'description'],
				['column_name' => 'published'],
				['column_name' => 'parent'],
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
		
		$this->saveAttributeData($request, $this->CurrentController, $nid);
		
   
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
     * @param  \App\Model\Authors  $authors
     * @return \Illuminate\Http\Response
     */
    public function show(Authors $authors)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Authors  $authors
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
    {
        $parent_category_select_data = CurrentModel::query()->select('id', 'title')->where('published', '=', 1)->where('id', '<>', $id)->pluck('title', 'id') ;
		//
		$result1 = CurrentModel::find($id)->toArray();
        //return response()->json($result1);
		
		$result = $this->getAttributeData($this->CurrentController, $id, $result1);
		//return response()->json($result2);
		//print_r($result1); print_r($result2); die;
		
		//$merged = $result2->merge($result1);

		//$result = $merged->all();
		
		//print_r($result); die;
		
		///Left is Template Position and Details is the group
		$fields['left']['details'] = (object) [
			'group_prop' => [
				'title' => 'Details',
				'collapse'	=> 0,
			],
			'fields' => [
				['label_text' => '', 'column_name' => 'title', 'type' => 'varchar', 'input_type' => 'text', 'validation' => 'required|no', 'pattern' => ''],
				['label_text' => 'Slug', 'column_name' => 'slug', 'type' => 'varchar', 'input_type' => 'text', 'pattern' => ''],
				['label_text' => 'Description', 'column_name' => 'description', 'type' => 'text', 'input_type' => 'editor'], //textarea or editor
				['label_text' => 'Parent Category', 'column_name' => 'parent', 'type' => 'integer', 'input_type' => 'select', 'select_data'=>$parent_category_select_data],
			],
		];
			
		$fields['right']['published'] =	(object) [
			'group_prop' =>  [
				'title' => 'Details',
				'collapse'	=> 0,
			],
			'fields' =>  [
				['label_text' => 'Published', 'column_name' => 'published', 'type' => 'boolean', 'input_type' => 'checkbox'],
			],
		];
		
		$fields = $this->getAttributes($this->CurrentController, $fields);
		
		
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
     * @param  \App\Model\Authors  $authors
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Authors $authors)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Authors  $authors
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
		$result = CurrentModel::find($id)->delete();
        return response()->json($result);
    }
}
