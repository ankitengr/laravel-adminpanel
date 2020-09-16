<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DataTables;
use DB;
use App\Http\Controllers\TraitImageUpload;
use App\Model\MasterCategoryCatalogModel;
use App\Model\SettingModel;
use App\Http\Controllers\Admin\File;
use App\Http\Controllers\Admin\CommonController;



class SettingController extends Controller
{    
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index()
    {
        $header_name = 'Settings';
        $theme = $this->theme;
		$columns_display_name = ['ID','Key','Value','Allow Edit','Status'];
		$columns_name = ['id','option_name', 'option_value', 'allow_edit','status'];
		$data['result']=[];
		$ajax_route = 'setting_ajax_data';
        return view($theme . '.common.datatable',compact('theme','header_name','columns_display_name','columns_name', 'data', 'ajax_route'));
    }

    public function export(Request $request)
    {

        return Excel::download(new PostsExport, $request->get('action').'.' . $request->get('type'));
    }

    #ajax category
    public function ajax_data() {
		$model = SettingModel::query();

        return  DataTables::of($model)
		
        ->editColumn('option_name', function ($data) {
			if ($data->allow_edit == 1)
				return '<a href="' . route('setting.edit', $data->option_name).'" onclick="return checkedit('.$data->allow_edit.');">'.$data->option_name.'</a>';
			else
				return $data->option_name;
        })
		
		->editColumn('option_value', function ($data) {
			return strlen($data->option_value) > 50 ? substr($data->option_value,0,50).' ...' : $data->option_value;
        })
        
		->editColumn('status', function ($inquiry) {
			if ($inquiry->status == 1) return '<span class="fa fa-check" align="center" Title="Active" style="color:green;"></span>';
			if ($inquiry->status == 0) return '<span class="fa fa-close" align="center" style="color:red;" Title = "In active"></span>';
        })

        ->editColumn('allow_edit', function ($inquiry) {
			if ($inquiry->allow_edit == 1) return '<span class="fa fa-check" align="center" Title="Edit Allowed" style="color:green;"></span>';
			if ($inquiry->allow_edit == 0) return '<span class="fa fa-close" align="center" style="color:red;" Title = "Edit Not Allowed">X</span>';
        })
        
		->rawColumns(['option_name','status','name','allow_edit'])   
        
		->make(true);

    }

    
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create($option_key)
    {
		$query_data_result = DB::table('setting_data')
          ->select('setting_data.*')
          ->where('option_name','=',trim($option_key))
          ->get();
			if($query_data_result->isNotEmpty()){
				return redirect('/admin/setting')
                ->with('fail','Record Alread Exists');
            }
		
		
        $bladefile = 'create_edit'; 
        $theme = $this->theme;
		//echo $theme.'.setting.template.'.$bladefile; die;
        if (view()->exists($theme.'.setting.'.$bladefile)) {
			//echo $theme.'.setting.'.$bladefile; die;
           return view($theme . '.setting.'.$bladefile ,compact('theme','option_key'));
		} else {
            return abort(404);
		}

    }
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
		
		//echo $request->id; die;
		if(empty($request->option_key)) {
			die('Invalid Option Key');
		}
		//print_r($request->all()); die;
		
        //print_r($_REQUEST); die;
        $data = array();
        $data = $request->all();
		unset($data['_token']);
		unset($data['apply_type']);
		unset($data['id']);
		unset($data['option_key']);
	
		if(count($data) == 1 && isset($data[$request->option_key])) {
			$saveData = $data[$request->option_key];
		}
		else {
			$saveData = json_encode($data);
		}

		
        $option_name= $request->option_key;
        $option_id= $request->id;
		
		//echo $option_name. '=========='. $option_id; die;
		
        $option_data= $saveData;
        
		if(!empty($option_id)){
        
        //DB::enableQueryLog();
        $matchThese = ['option_name'=>$option_name,'id'=> $option_id ];
        $response = SettingModel::where($matchThese)->update([
                      'option_value' => DB::raw("'$option_data'")
                    ]);
        //dd(DB::getQueryLog());
        //echo "update";
        //die;
        }else{
            //echo "add";
            //die;
            $response = SettingModel::updateOrCreate([
                                        'option_name'=>$option_name,
                                        'option_value'=>$option_data,

                                                        ]);
        }

         //dd(DB::getQueryLog());
         if($response){

                 return redirect('/admin/setting')
                ->with('success','Record update successfully.');
            }
			else{

                 return redirect('/admin/setting')
                ->with('fail','Record unable to update or add, try again.');
            } 

       
      
    }
    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        //
    }
    public function editnew($id){
        //echo $id;
        //die;
    }
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
     
    public function edit($option_key)
    {
        //Getting all parent node
		$bladefile = 'create_edit';
        $theme = $this->theme;
        if (view()->exists($theme.'.setting.'.$bladefile)) {
          $query_data_result = DB::table('setting_data')
          ->select('setting_data.*')
          ->where('option_name','=',trim($option_key))
          ->get();
			if($query_data_result->isEmpty()){
				return redirect('/admin/setting')
                ->with('fail','No Record Found to edit');
            }else{
                $option_id = $query_data_result[0]->id;
				
				$jsonD = json_decode($query_data_result[0]->option_value,true);
				
				if($jsonD) {
					$result = $jsonD;
				}
				else {
					$result[$option_key] =  $query_data_result[0]->option_value;
				}
				//print_r($result); die;
                return view($theme.'.setting.'.$bladefile,compact('theme', 'option_id','result','option_key'));

            }
       } else {
            return abort(404);

       }

    }

        
     
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    /*public function store(Request $request, $id){
        
    }*/
    
    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
    //
    }
    
    
}
