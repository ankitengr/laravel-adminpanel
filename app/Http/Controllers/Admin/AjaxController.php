<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Multimedia As Multimedia;
use App\Model\Multidata As Multidata;
use App\Model\RelationalValues As RelationalValues;
use Illuminate\Support\Facades\Storage;


class AjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
		$id = $request->get('ids');
		switch ($request->get('action')) {
			case 'multi-data' :
				if(stristr($id, ',')) {
					$myIds = explode(',', $id);
					return $result = Multidata::query()->whereIn('id', $myIds)->orderByRaw(\DB::raw("FIELD(id, ".$id." )"))->get()->toJson();
				}
				else {
					return $result = Multidata::query()->where('id', '=', $id)->get()->toJson();
				}
				break;
		}
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
        //return $request->all();
		//return $request->get('action');
		switch ($request->get('action')) {
			case 'multi-data' : 
				$object = Multidata::updateOrCreate(['id' => $request->id], ['content'=>$request->get('content')]);
				return $object->id;
				break;
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
		//return echo $request->all();
		$result = Multidata::find($id)->delete();
        return response()->json($result);
    }
	
	public function media_upload(Request $request){
		$arr = [];
		foreach($request->all() as $file){
			if(is_file($file)){
			  $string = date('dmyhis');
			  $ext = $file->guessExtension();
			  $file_name = $string . '.' .  $ext;
			  $file_path = 'uploads/'. $file_name;
			  Storage::disk('public_uploads')->put($file_name, file_get_contents($file->getRealPath()), 'public');
			  $mime_type_explode = explode('/', $file->getClientMimeType());
			  $object = Multimedia::updateOrCreate(['id' => $request->id], ['multimedia_type'=>$mime_type_explode[0], 'file_path' => '/' . $file_path]);        
			  $nid = $object->id;
			  array_push($arr, [$file_name, $file->getClientMimeType(), $file->getRealPath(), '/' . $file_path, $nid ]);
			}
		}  
		return $arr;
	}
	
	
	
	public function get_media_data($id){
		if(stristr($id, ',')) {
			$myIds = explode(',', $id);
			return $result = Multimedia::query()->whereIn('id', $myIds)->orderByRaw(\DB::raw("FIELD(id, ".$id." )"))->get()->toJson();
		}
		else {
			return $result = Multimedia::query()->where('id', '=', $id)->get()->toJson();
		}
	}
	
	public function get_medias(Request $request){
		if($request->get('media_type') == 'all') {
			return $result = Multimedia::query()->orderBy('id','DESC')->skip(0)->take(5)->get()->toJson();
		}
		else {
			return $result = Multimedia::query()->where('multimedia_type', '=', $request->get('media_type'))->orderBy('id','DESC')->skip(0)->take(5)->get()->toJson();
		}
	}
	
	
}
