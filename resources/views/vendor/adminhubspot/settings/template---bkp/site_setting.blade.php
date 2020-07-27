<?php 
if(!empty($content_data)){
$datanew  = $content_data[0]['option_value'] ;
$result = json_decode($datanew,true);

/*print_r($result);
die;*/
//echo $result;
//die;
}
?>




{!! Form::label('Show basic settings', 'Show Basic settings:', ['class'=>'form-control-label'])!!}
{!! Form::select("basic_setting",['1'=>"Yes","0"=>"No"],(isset($result['basic_setting']))?$result['basic_setting']:"",['class'=>'form-control ' , 'id'=>'basic_setting', 'required'=>'']) !!}

<br>
{!! Form::label('Show advance settings', 'Show Advance settings:', ['class'=>'form-control-label'])!!}
{!! Form::select("advance_setting",['1'=>"Yes","0"=>"No"],(isset($result['advance_setting']))?$result['advance_setting']:"",['class'=>'form-control ' , 'id'=>'advance_setting', 'required'=>'']) !!}


<br>
{!! Form::label('Show Public settings', 'Show Public settings:', ['class'=>'form-control-label'])!!}
{!! Form::select("public_setting",['1'=>"Yes","0"=>"No"],(isset($result['public_setting']))?$result['public_setting']:"",['class'=>'form-control ' , 'id'=>'public_setting', 'required'=>'']) !!}

<br>
{!! Form::label('Show add settings', 'Show Add settings:', ['class'=>'form-control-label'])!!}
{!! Form::select("add_setting",['1'=>"Yes","0"=>"No"],(isset($result['add_setting']))?$result['add_setting']:"",['class'=>'form-control ' , 'id'=>'add_setting', 'required'=>'']) !!}

<br>
{!! Form::label('Show Limited Content', 'Show Limited Content:', ['class'=>'form-control-label'])!!}
{!! Form::select("limit_setting",['1'=>"Yes","0"=>"No"],(isset($result['limit_setting']))?$result['limit_setting']:"",['class'=>'form-control ' , 'id'=>'limit_setting', 'required'=>'']) !!}

<br>

{!! Form::label('Show basic settings new', 'Show Basic settings New:', ['class'=>'form-control-label'])!!}
{!! Form::select("basic_setting1",['1'=>"Yes","0"=>"No"],(isset($result['basic_setting1']))?$result['basic_setting1']:"",['class'=>'form-control ' , 'id'=>'basic_setting1', 'required'=>'']) !!}

<br>
{!! Form::label('Show advance settings new', 'Show Advance settings New:', ['class'=>'form-control-label'])!!}
{!! Form::select("advance_setting1",['1'=>"Yes","0"=>"No"],(isset($result['advance_setting1']))?$result['advance_setting1']:"",['class'=>'form-control ' , 'id'=>'advance_setting1', 'required'=>'']) !!}


<br>
{!! Form::label('Show Public settings new', 'Show Public settings New:', ['class'=>'form-control-label'])!!}
{!! Form::select("public_setting1",['1'=>"Yes","0"=>"No"],(isset($result['public_setting1']))?$result['public_setting1']:"",['class'=>'form-control ' , 'id'=>'public_setting1', 'required'=>'']) !!}

<br>
{!! Form::label('Show add settings New', 'Show Add settings New:', ['class'=>'form-control-label'])!!}
{!! Form::select("add_setting1",['1'=>"Yes","0"=>"No"],(isset($result['add_setting1']))?$result['add_setting1']:"",['class'=>'form-control ' , 'id'=>'add_setting1', 'required'=>'']) !!}

<br>
{!! Form::label('Show Limited Content new', 'Show Limited Content New:', ['class'=>'form-control-label'])!!}
{!! Form::select("limit_setting1",['1'=>"Yes","0"=>"No"],(isset($result['limit_setting1']))?$result['limit_setting1']:"",['class'=>'form-control ' , 'id'=>'limit_setting1', 'required'=>'']) !!}

				


	<script type="text/javascript">
		$(".add_form, .apply_form").on('click', function(){
			var app_id  = $("#app_id").val();

		if(app_id==''){
			alert("Enter the Facebook App Id");
			return false;
		}
	});
	</script>

	