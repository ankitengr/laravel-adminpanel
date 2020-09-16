<?php

namespace App\Http\Controllers\Admin;

use App\Model\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DataTables;
use DB;
class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
		if ($request->ajax()) {
			//dd($request);
			$data = Settings::query();
            return Datatables::of($data)
                    ->editColumn('option_name', function ($data) {
			if ($data->allow_edit == 1)
				return '<a href="' . route('settings.edit', $data->option_name).'" onclick="return checkedit('.$data->allow_edit.');">'.$data->option_name.'</a>';
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
      
	
		$fields = [
				['label_text' => 'ID', 'column_name' => 'id'],
				['label_text' => 'Key', 'column_name' => 'option_name'],
				['label_text' => 'Value', 'column_name' => 'option_value'],
				['label_text' => 'Allow Edit', 'column_name' => 'allow_edit'],
				['label_text' => 'Published', 'column_name' => 'status'],
			];
		
		$params = [
            'title' => 'Settings',
            'fields' => $fields,
			'controller' => 'settings',
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
    public function create($option_key)
    {
        //
		$record = Settings::where('option_name',trim($option_key))
               ->orderBy('id', 'desc')
               ->take(1)
               ->get();
		
		if($record->isNotEmpty()){
				return redirect('/admin/settings')
                ->with('fail','Record Alread Exists');
        }
		
		$bladefile = 'create_edit'; 
        $theme = $this->theme;
		//echo $theme.'.setting.template.'.$bladefile; die;
        if (view()->exists($theme.'.settings.'.$bladefile)) {
			//echo $theme.'.setting.'.$bladefile; die;
           return view($theme . '.settings.'.$bladefile ,compact('theme','option_key'));
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
        //
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
        $response = Settings::where($matchThese)->update([
                      'option_value' => DB::raw("'$option_data'"),
                    ]);
        //dd(DB::getQueryLog());
        //echo "update";
        //die;
        }else{
            //echo "add";
            //die;
            $response = Settings::updateOrCreate([
                                        'option_name'=>$option_name,
                                        'option_value'=>$option_data,
										'allow_edit'=>1,
										'status'=>1,

                                                        ]);
        }

         //dd(DB::getQueryLog());
         if($response){

                 return redirect('/admin/settings')
                ->with('success','Record update successfully.');
            }
			else{

                 return redirect('/admin/settings')
                ->with('fail','Record unable to update or add, try again.');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit($option_key)
    {
        //
		$bladefile = 'create_edit';
        $theme = $this->theme;
        if (view()->exists($theme.'.settings.'.$bladefile)) {
          $record = Settings::where('option_name',trim($option_key))
               ->orderBy('id', 'desc')
               ->take(1)
               ->get();
			   
			if($record->isEmpty()){
				return redirect('/admin/settings')
                ->with('fail','No Record Found to edit');
            }else{
                $option_id = $record[0]->id;
				
				$jsonD = json_decode($record[0]->option_value,true);
				
				if($jsonD) {
					$result = $jsonD;
				}
				else {
					$result[$option_key] =  $record[0]->option_value;
				}
				//print_r($result); die;
                return view($theme.'.settings.'.$bladefile,compact('theme', 'option_id','result','option_key'));

            }
       } else {
            return abort(404);

       }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Settings $settings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $settings)
    {
        //
    }
}
