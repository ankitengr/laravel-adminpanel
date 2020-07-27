<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\General;
use Illuminate\Http\Request;
use DB;
use DataTables;
class GeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($table)
    {
		//dd($request);
		
		$title = 'Test';
		$theme = $this->theme;
		$columns_display_name = ['ID','Title','Edit','Status'];
		$columns_name = ['option_id','option_name','edit_not_allowed','status'];
		$data=[];
		
		if(!empty($table) && DB::getSchemaBuilder()->hasTable($table)) {
			
		}
		
		
		return view($theme . '.common.datatable', compact('theme','title','data', 'columns_name', 'columns_display_name'));
		
		/*
		dd($request->segment(3));
		
		//echo $table; die;
		$theme = $this->theme;
		if(!empty($table) && DB::getSchemaBuilder()->hasTable($table)) {
			//echo 'test'; die;
			$data['result'] = DB::table($table)->paginate(5);
			$title = str_replace('_',' ',strtoupper($table));
			foreach($data['result'] as &$row) {
				unset($row->password);
			}
			
			foreach($data['result'][0] as $key=>$val) {
				$columns_name[] = $key;
			}
			
			//print_r($columns_name); die;
			//print_r($data['result']); die;
			
			return view($this->theme . '.common.datatable', compact('theme','title','data', 'columns_name'));
		}
        //
		*/
    }
	
	public function listing($table){
		$title = 'Test';
		$theme = $this->theme;
		$columns_name = ['option_id','option_name','edit_not_allowed','status'];
		$data=[];
		
		if(!empty($table) && DB::getSchemaBuilder()->hasTable($table)) {
			$data['result'] = DB::table($table)->paginate(5);
			$title = str_replace('_',' ',strtoupper($table));
			foreach($data['result'] as &$row) {
				unset($row->password);
			}
		}
		
		
		return view($theme . '.common.datatable', compact('theme','title','data', 'columns_name'));
	}
	
	
	public function ajax_data(){
		$data = DB::table('setting_data')
			->select('option_id','option_name', 'edit_not_allowed','status')
			->from('setting_data')
			->get();
		
		return DataTables::of($data)->toJson();

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
     * @param  \App\Model\General  $general
     * @return \Illuminate\Http\Response
     */
    public function show(General $general)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\General  $general
     * @return \Illuminate\Http\Response
     */
    public function edit(General $general)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\General  $general
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, General $general)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\General  $general
     * @return \Illuminate\Http\Response
     */
    public function destroy(General $general)
    {
        //
    }
}
