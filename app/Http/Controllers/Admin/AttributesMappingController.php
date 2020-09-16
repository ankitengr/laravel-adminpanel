<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\AttributesMapping As CurrentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DataTables;

class AttributesMappingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	protected $CurrentController = 'attributesmapping';
	protected $IndexTitle = 'Attributes Mapping';
	protected $CreateTitle = 'Attributes Mapping';
	protected $EditTitle = 'Attributes Mapping';
	protected $EditField = 'attributesmapping';
	
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
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\AttributesMapping  $attributesMapping
     * @return \Illuminate\Http\Response
     */
    public function show(AttributesMapping $attributesMapping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\AttributesMapping  $attributesMapping
     * @return \Illuminate\Http\Response
     */
    public function edit(AttributesMapping $attributesMapping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\AttributesMapping  $attributesMapping
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AttributesMapping $attributesMapping)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\AttributesMapping  $attributesMapping
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttributesMapping $attributesMapping)
    {
        //
    }
}
