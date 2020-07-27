{!! Form::open(['method'=>'POST','url'=>route('settings.store',['option_key'=>$option_key]),'files'=>true,'class'=>'form']) !!}
	@include($theme . '.partials.submitbutton') 
	{!! Form::select("version",['1'=>"Version 1","2"=>"Version 2","3"=>"Version 3"],(isset($result['version']))?$result['version']:"",['class'=>'form-control widget_type' , 'id'=>'version', 'required'=>'']) !!}
	
	{!! Form::text('site_key', !empty($result['site_key']) ? $result['site_key'] : '', [
		'class'=>'form-control site_key',
		'id'=> 'site_key',
		'placeholder'=>'Google Captcha Site Key'
		])!!}
		
	
	{!! Form::text('secret_key', !empty($result['secret_key']) ? $result['secret_key'] : '', [
		'class'=>'form-control site_key',
		'id'=> 'secret_key',
		'placeholder'=>'Google Captcha Secret Key'
		])!!}
	
	{!! Form::hidden('option_key',$option_key) !!}
	
	@if(!empty($option_id))
		{!! Form::hidden('id',$option_id) !!}
	@endif
@include($theme . '.partials.submitbutton')
{!! Form::close() !!}

<script type="text/javascript">
$(".add_form, .apply_form").on('click', function(){
	var site_key  = $("#site_key").val();

	if(site_key==''){
		alert("Enter the Googlecaptcha App Id");
		return false;
	}
	
	var secret_key  = $("#secret_key").val();

	if(secret_key==''){
		alert("Enter the Googlecaptcha Secret Key");
		return false;
	}
});
</script>