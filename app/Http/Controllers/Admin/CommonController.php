<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
/**
 * this class is used for comman functions 
 */
class CommonController extends Controller
{
 	/**
	 * this function is getting by line author
	 * @return json<array> of author <param> @id @name @value <value represent the name>
	 */
	function get_tag_byline(Request $request){
		$search_text 		= $request->get('term');
		$result 			= [];
		if(empty($search_text)){
			echo json_encode($result);
			die;
		}
		$result = DB::table('author')
			->where('name','LIKE','%'.(trim($search_text).'%'))
			->select('id','name',DB::raw("CONCAT(name,' (',email,')') as value") ) 
			->get();
		
		echo json_encode($result);
		die;				
	}

	function meta_tag_master(Request $request){
		$search_text	= $request->get('term');
		$result 		= [];
		if(empty($search_text)){
			echo json_encode($result);
			die;
		}
		$result = DB::table('tag_master')
				->where('tag_name','LIKE','%'.(trim($search_text).'%'))
				->select('id','tag_name as name','tag_name as value')
				->get();
		
		echo json_encode($result);
		die;
	}
	function find_video_search(Request $request) {
		/**
		* @var getting old related transcoding.   
		*/
		//DB::enableQueryLog();
		$checkbox_is_checked 		= '';
		if(isset($_REQUEST) &&  isset($_REQUEST['content_id']) && $_REQUEST['content_id'] !=0){

			$checkbox_is_checked 	= "checked";
			$sr 					= 50;
			$query 				= DB::table('jos_multimedia')
							->select('*')
							->where('content_id',$_REQUEST['content_id'])
							->where('status',1)
							->where('bitrate',512)
							->groupBy('transcoding_id')
							->get();

		}else{
			//search will work here
			$sr = 0;
			$search_text 	=  $request->get('search_video_text');
			$query 			= DB::table('jos_multimedia')
						->select('*')
						->where('content_id',DB::raw("'0'"))
						->where('status',DB::raw("'1'"))
						->where('bitrate',DB::raw("'512'"))
						//->where('ratio',DB::raw("'4:3'"))
						//->setBindings('0' ,'1', '512')
						//->where('source_file_name','not like', '%_zodiac_%')
						->where('source_file_name','like', DB::raw("'%$search_text%'"))
						->groupBy('transcoding_id')
						->offset(0)
						->limit(10)
						->get();

		}

		//checking the last query for debugging
		/*$query = DB::getQueryLog();
		print_r($query);
		die;*/
	  		
		$list = '<div class="not-bg"><div class="res-table"><table class="table table-striped t-wrapper" cellpadding="3" cellspacing="0" width="100%"> <tr><th>Select</th> <th>File name</th>  <th>Link</th> </tr>';
		if($query->count() > 0){

			foreach ($query as $key => $value) {

				$get_source_filename				=	str_replace("/","",$value->source_file_name);
				$get_output_filename_array	=	explode(".",$get_source_filename);
				if(count($get_output_filename_array)>1)
				unset($get_output_filename_array[count($get_output_filename_array)-1]);
				$get_output_filename=implode(".",$get_output_filename_array);

				$list .='<tr><td for="transcoding_videoid_'.$sr.'"><input type="checkbox" name="transcoding_videoid_'.$sr.'" class="checkclick" id="transcoding_videoid_'.$sr.'" value="'.$value->id.'" '.$checkbox_is_checked.'/>
				<input type="hidden" id="transcoding_transcoding_id_'.$sr.'" name="transcoding_transcoding_id_'.$sr.'" value="'.$value->transcoding_id.'">
				<input type="hidden" id="transcoding_file_path_'.$sr.'" class="checkurl" name="transcoding_file_path_'.$sr.'" value="'.$value->file_path.'">
				<input type="hidden" id="transcoding_s3_domain_'.$sr.'" name="transcoding_s3_domain_'.$sr.'" value="'.$value->s3_domain.'"></td>
				<input type="hidden" id="transcoding_filename_'.$sr.'" name="transcoding_filename_'.$sr.'" value="'.$get_output_filename.'"></td>';

		
				

				$list .= "<td>".$get_output_filename.'.mp4' . "</td>";

				/*$list .= "<td>".$value->creation_datetime . "</td>";*/

				$url  = "http://".$value->s3_domain.'/'.$value->file_path;

				$list .= "<td>"."<a href='".$url."' target='_blank'>Preview</a></td></tr><script>  $('input[type=checkbox]').on('change', function() {
   $('input[type=checkbox]').not(this).prop('checked', false);
   $('.okselect').show();
});</script>";

				$sr++;
			}


		}
		else
		{
			$list .= "<tr><td colspan='4'>There is no search item found</td></tr>";
		}			
				
		if(isset($_REQUEST) &&  isset($_REQUEST['content_id']) && $_REQUEST['content_id'] !=0){
			unset($_REQUEST['content_id']);
			return $list."</table></div></div>";

		}else {	
			echo $list."</table></div></div>";
		}

  }	
  //Search content
  public function find_related_search(Request $request){
  	/**
		* @var getting old content related .   
		*/
		$checkbox_is_checked 		= '';
		if(isset($_REQUEST) &&  isset($_REQUEST['content_id']) && $_REQUEST['content_id'] !=0){

			$checkbox_is_checked 	= "checked";
			$sr 	= 100;
			$query 	= DB::table('content')
			->select('content.*')
			->join('content_related','content_related.content_id','=','content.id')
			->where('content_related.content_id','<>',$_REQUEST['content_id'])
			->get();

		}else{
			//search will work here
			$sr = 0;
			$search_text 	=  $request->get('search_text');
			$content_related_type 	=  $request->get('content_related_type');
			$query 			= DB::table('content')
			->select('*')
			->where(function($q) use ($search_text) {
				$q->where('content.name','like', DB::raw("'%$search_text%'"))
				->orWhere('content.slug','like', DB::raw("'%$search_text%'"));
				//->orWhere('content.app_headline','like', DB::raw("'%$search_text%'")); // commented by ankit looking no use
			});
			if(!empty($content_related_type)) {
				$query->where('content.content_type','like', DB::raw("'%$content_related_type%'"));
			}
			
/*DC code commented by ankitj
			if($request->has('content_related_video') && $request->get('content_related_video') !=''){
				$cnType = $request->get('content_related_video');
				$cnType = config('content.content_type_data.'.$cnType);
				$query  = $query->where('content.content_type',$cnType);

			}
			*/
			$query = $query->offset(0)
							->limit($request->get('limit'))
							->orderBy('id','desc')
							->get();
			

		}

		$list = '<div class="not-bg"><div class="res-table"><table class="table table-striped t-wrapper" cellpadding="4" cellspacing="0" width="100%"> <tr><th>Select</th>  <th style="width:35%">Title</th> <th>type</th> <th>Created at</th> </tr>';
		if($query->count() > 0){

			foreach ($query as $key => $value) {

				$list .='<tr for= "related_id_'.$sr.'"><td id="related_id_'.$sr.'"><input type="checkbox" name="related_id['.$sr.']" value="'.$value->id.'" '.$checkbox_is_checked.'/>
				<input type="hidden" id="related_related_id['.$sr.']" name="related_related_id['.$sr.']" value="'.$value->id.'">
				<input type="hidden" id="related_related_name['.$sr.']" name="related_related_name['.$sr.']" value="'.$value->name.'">
				<input type="hidden" id="related_related_type['.$sr.']" name="related_related_type['.$sr.']" value="'.$value->content_type.'"></td>';
				/*$list .= '<td>'.$value->id.'</td>';*/
				$list .= '<td>'.$value->name.'</td>';
				$list .= '<td>'.$value->content_type.'</td>';
				$list .= '<td>'.$value->created_at.'</td>';
				$list .= "</tr>";
				$sr++;
			}


		}
		else
		{	
			if($checkbox_is_checked=!'checked'){
				$list .= "<tr><td>There is no search item found</td></tr>";
			}
			else{
				$list = "";
			}
		}			
				
		if(isset($_REQUEST) &&  isset($_REQUEST['content_id']) && $_REQUEST['content_id'] !=0){
			unset($_REQUEST['content_id']);
			return $list."</table>";

		}else {	
			echo $list."</table></div></div>";
		}
  }
  //chunck submit code here
  public function chunk_submit(Request $request) {

  	$check_exist = DB::table('chunk')->select('id')->where('name','=',trim($request->get('name')));

  	if($check_exist->count() > 0) {
  		$response['error'] = 1;
  		$response['message'] = "The record is already exist";
  	}else {
  		$insert = DB::table('chunk')->insertGetId(['name'=>trim($request->get('name'))]);
  		$response['error'] 		= 0;
  		$response['message'] 	= "<option value='".$insert."' selected>".$request->get('name')." </option>";
  	}
  	echo json_encode($response);
  }

  public function control_submit(Request $request){


  	$check_exist = DB::table('control_panel_page_manager')->select('id')->where('name','=',trim($request->get('name')));

  	if($check_exist->count() > 0) {
  		$response['error'] = 1;
  		$response['message'] = "The record is already exist";
  	}else {
  		$insert = DB::table('control_panel_page_manager')->insertGetId(['name'=>trim($request->get('name')),'panel_type'=>trim($request->get('panel_type'))]);
  		$response['error'] 		= 0;
  		$response['message'] 	= "<option value='".$insert."' selected>".$request->get('name')." </option>";
  	}
  	echo json_encode($response);
  }

  	public function delete(Request $request){
    	$table = $type = $request->get('type');
    	$id = $request->get('id');
    	$result['succ'] = 0;
    	$result['reload'] = 1;
    	$where = array('id' => $id);
    	$update = ['is_deleted' => "1"];
    	switch ($type) {
    		case 'roles':
    		break;
    	}

    	$res = DB::table($table)
	            ->where($where)
	            ->update($update);
	    if($res)
	    	$result['succ'] = 1;

	    die(json_encode($result));		        
    }

    public function status_change(Request $request){
    	$table = $type = $request->get('type');
    	$id = $request->get('id');
    	$result['succ'] = 0;
    	$result['update'] = 1;
    	$where = array('id' => $id);
    	$update = ['status' => "1"];
    	switch ($type) {
    		case 'roles':
    		break;
    	}
    	//die('in status');
    	$res = DB::table($table)
	            ->where($where)
	            ->update(['status'=>DB::raw('CASE 
                        WHEN status = "0" THEN "1" 
                        ELSE "0" 
                        END')]);
	    if($res)
	    	$result['succ'] = 1;

	    die(json_encode($result));		        
    }

}
