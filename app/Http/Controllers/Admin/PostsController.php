<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Post As CurrentModel;
use App\Model\Apps;
use App\Model\PostTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;
use App\Traits\AttributesTrait;

class PostsController extends Controller
{
	use AttributesTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	protected $CurrentController = 'Posts';
	protected $IndexTitle = 'Posts';
	protected $CreateTitle = 'Post';
	protected $EditTitle = 'Post';
	protected $EditField = 'post';
	protected $current_post_type = 'static' ;
	protected $current_post_type_id = 1 ;
	
	public function __construct(){
		parent::__construct();
		$content_type = request()->segment(3);
		$current_post_types_data = PostTypes::where('slug', '=', "{$content_type}")->first();
		$this->current_post_type = isset($current_post_types_data->slug) ? $current_post_types_data->slug : '';
		$this->current_post_type_id = isset($current_post_types_data->id) ? $current_post_types_data->id : 1;
		
		$this->CurrentController = $this->current_post_type;
		$this->EditField = $this->current_post_type;
		
		$app_data = Apps::where(['published' => 1])->get();
		$this->app_count = $app_data->count();
		//echo $this->app_count; die;
		$this->app_default_id = $this->app_count == 1 ?  $app_data[0]['id'] : 0 ;
		
		//echo $this->app_default_id; die;
	}
	
    public function index(Request $request)
    {
        //
		
		/**Just for testing
		$data = CurrentModel::query()->where('post_types_id', '=', $this->current_post_type_id);
		
		$data->each(function($row) {
			print_r($row);
		});
		die;
		***/
		
		if ($request->ajax()) {
			//dd($request);
			$data = CurrentModel::query()->where('post_types_id', '=', $this->current_post_type_id);
            return Datatables::of($data)
				->addIndexColumn()
				->editColumn('title', function ($data) {
					$allow_edit = true; // This can be used for permission
					if ($allow_edit == 1)
						return '<a href="' . route($this->CurrentController . '.edit', $data->id).'">'.$data->title.'</a>';
					else
						return $data->title;
				})
				
		
				->addColumn('published', function ($data) {
					if ( !empty($data->publish_up) ) return '<span class="fa fa-check" align="center" Title="Active" style="color:green;"></span>';
					if ( empty($data->publish_up) ) return '<span class="fa fa-close" align="center" style="color:red;" Title = "In active">x</span>';
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
		
		$data['post_types_id'] = $this->current_post_type_id ;
		
		///Left is Template Position and Details is the group
		$fields['left']['default'] = (object) [
			'group_prop' => [
				'title' => 'Details',
				'collapse'	=> 0,
			],
			'fields' => [
				['label_text' => '', 'column_name' => 'post_types_id', 'type' => 'integer', 'input_type' => 'hidden', 'validation' => '', 'pattern' => ''],
				['label_text' => '', 'column_name' => 'title', 'type' => 'varchar', 'input_type' => 'text', 'placeholder' => 'Title', 'validation' => 'required|no', 'pattern' => ''],
				['label_text' => 'Description', 'column_name' => 'description', 'type' => 'text', 'input_type' => 'editor',], //textarea or editor
			],
		];
		
		
		$fields['right']['published'] =	(object) [
			'group_prop' =>  [
				'title' => 'Published',
				'collapse'	=> 0,
			],
			'fields' =>  [
				['label_text' => 'publish At', 'column_name' => 'publish_up', 'type' => 'datetime', 'input_type' => 'datetime-local', 'min' => date('Y-m-d\TH:i')],
			],
		];
		
		//print_r($fields);
		
		$fields = $this->getAttributes($this->CurrentController, $fields, $func_type='create_func');
		
		//print_r($fields); die;
		
		$params = [
            'title' => 'Create '. $this->CreateTitle,
            'fields' => $fields,
			'controller' => $this->CurrentController,
			'id' => 0,
			'result' => $data
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
			'description' => $request->has('description') && !empty($request->get('description')) ? ($request->get('description')) : '',
		]);
		//dd($request->all());
		
		$fields = [
				['column_name' => 'post_types_id'],
				['column_name' => 'apps_id'],
				['column_name' => 'title', 'validation' => 'required|max:255'],
				['column_name' => 'slug', 'validation' => 'required|regex:/^[a-z0-9]+(?:[- ][a-z0-9]+)*$/'],
				['column_name' => 'description'],
				['column_name' => 'publish_up'],
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
     * @param  \App\Model\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
		$result1 = CurrentModel::find($id)->toArray();
        //return response()->json($result1);
		
		$result = $this->getAttributeData($this->CurrentController, $id, $result1);
		
		//print_r($result); die;
		
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
				['label_text' => '', 'column_name' => 'post_types_id', 'type' => 'integer', 'input_type' => 'hidden', 'validation' => '', 'pattern' => ''],
				['label_text' => '', 'column_name' => 'title', 'type' => 'varchar', 'input_type' => 'text', 'validation' => 'required|no', 'pattern' => ''],
				['label_text' => 'Slug', 'column_name' => 'slug', 'type' => 'varchar', 'input_type' => 'text', 'pattern' => ''],
				['label_text' => 'Description', 'column_name' => 'description', 'type' => 'text', 'input_type' => 'editor'], //textarea or editor
			],
		];
			
		if($this->app_count > 1)
			$app_field = ['label_text' => 'App', 'column_name' => 'apps_id', 'type' => 'integer', 'input_type' => 'select', 'default_value'=>1, 'select_data' => \App\Model\Apps::query()->select('id','title')->where('published', '=', 1)->pluck('title', 'id'),] ;
		else {
			$app_field = ['label_text' => '', 'column_name' => 'apps_id', 'type' => 'integer', 'input_type' => 'hidden'] ;
		}
		
		$publish_down_field = '';
		if(empty($result['publish_up'])) {
			$publish_up_field = ['label_text' => 'Publish At', 'column_name' => 'publish_up', 'type' => 'datetime', 'input_type' => 'datetime-local', 'min' => date('Y-m-d\TH:i')];
		}
		else {
			$publish_up_field = ['label_text' => 'Publish At', 'column_name' => 'publish_up', 'type' => 'datetime', 'input_type' => 'text', 'readonly' => true] ;
			
			if(empty($result['publish_down'])) {
				$publish_down_field = ['label_text' => 'Publish Down', 'column_name' => 'publish_down', 'type' => 'datetime', 'input_type' => 'datetime-local', 'min' => date('Y-m-d\TH:i', strtotime($result['publish_up']))];
			}
			else {
				$publish_down_field = ['label_text' => 'Publish Down', 'column_name' => 'publish_down', 'type' => 'datetime', 'input_type' => 'text', 'readonly' => true] ;
			}
			
			
		}
		
		$fields['right']['published'] =	(object) [
			'group_prop' =>  [
				'title' => 'Published',
				'collapse'	=> 0,
			],
			'fields' =>  [
				$app_field,
				$publish_up_field,
			],
		];
		
		
		
		
		if(!empty($publish_down_field)) {
			$fields['right']['published']->fields[]=$publish_down_field;
		}
		
		$fields = $this->getAttributes($this->CurrentController, $fields, 'edit_func');
		
		
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
     * @param  \App\Model\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = CurrentModel::find($id)->delete();
        return response()->json($result);
    }

}
