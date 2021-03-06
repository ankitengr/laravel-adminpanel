
@php
//This code is only for the apply button as per requested by the QC team
$url_filter =  request()->route()->getAction();
$url_filter = explode('.', $url_filter['as']);
$get_action_apply_button 	= end($url_filter);

@endphp


<div class="col-md-12 text-right">
	{!! Form::hidden('apply_type',null,['type'=>'hidden','class'=>'apply_type']) !!}
	<div class="" style="margin: 5px 0px;">
		{!! Form::submit('Save',['class'=>'btn btn-primary add_form']) !!}   
		@if($get_action_apply_button !='create')		
			{!! Form::submit('Apply',['class'=>'btn btn-warning apply_form']) !!}   
		@endif
	</div>
</div>

<script type="text/javascript">
  $(document).on('click','.apply_form',apply_form);
  $(document).on('click','.add_form',add_form);
  function apply_form(){
    $(".apply_type").val('apply');  
  }
  function add_form(){
    $(".apply_type").val('add_form');  
  }
</script>