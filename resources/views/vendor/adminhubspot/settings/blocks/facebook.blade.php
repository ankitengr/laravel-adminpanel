{!! Form::open(['method'=>'POST','url'=>route('settings.store',['option_key'=>$option_key]),'files'=>true,'class'=>'form']) !!}
	@include($theme . '.common.includes.submitbutton') 
	{!! Form::label('Facebook App id', 'Facebook App id', ['class'=>'form-control-label'])!!}
	{!! Form::text('facebook', !empty($result['facebook']) ? $result['facebook'] : '', [
		'class'=>'form-control app_id',
		'id'=> 'app_id',
		'placeholder'=>'Facebook App ID'
		])!!}
	{!! Form::hidden('option_key',$option_key) !!}
	
	@if(!empty($option_id))
		{!! Form::hidden('id',$option_id) !!}
	@endif
	@include($theme . '.common.includes.submitbutton')
{!! Form::close() !!}

<script type="text/javascript">
$(".add_form, .apply_form").on('click', function(){
	var app_id  = $("#app_id").val();

	if(app_id==''){
		alert("Enter the Facebook App Id");
		return false;
	}
});
</script>