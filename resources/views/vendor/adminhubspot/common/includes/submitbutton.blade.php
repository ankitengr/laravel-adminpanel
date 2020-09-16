
@php
//This code is only for the apply button as per requested by the QC team
$url_filter =  request()->route()->getAction();
$url_filter = explode('.', $url_filter['as']);
$get_action_apply_button 	= end($url_filter);

@endphp


<div class="col-md-12 text-right">
	{!! Form::hidden('apply_type',null,['type'=>'hidden','class'=>'apply_type']) !!}
	<div class="" style="margin: 5px 0px;">
	{!! Form::submit('Save',['class'=>'btn btn-primary apply_form']) !!}
	{!! Form::submit('Close',['class'=>'btn btn-warning close_form']) !!}   
	</div>
</div>


<script type="text/javascript">
  $(document).on('click','.apply_form',function(){
	$(".apply_type").val('apply');	  
  });
  
  $(document).on('click','.close_form',function(){
	 $(".apply_type").val('close');
	 window.location = "{{route($url_filter[0].'.index')}}";
  });
</script>