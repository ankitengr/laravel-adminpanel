
<?php 
if(!empty($content_data)){

$datanew  = $content_data[0]['option_value'] ;
$result = json_decode($datanew,true);
}
?>



 <span class="text-bold">

 </span>
<div class="container">
	<div class="">
		<?php use App\Http\Controllers\Admin\SettingController;
		echo SettingController::content_ajax_data(); ?>
</div>
	</div>

	{!! Form::label('Number of stories', 'Number of stories', ['class'=>'form-control-label'])!!}
	{!! Form::number('noofstory', !empty($result['noofstory']) ? $result['noofstory'] : '', [
	'class'=>'form-control noofstory',
	'placeholder'=>'Number of stories'
	])!!}

</div>
<script type="text/javascript">

	$(".add_form").on('click', function(){
		var len = $('ul li :input[type="checkbox"]:checked').length;
		var noofstory = $('#noofstory').val();
		if(len=='0'){
			alert("Please select at least one option from options");
			return false;
		}else if(noofstory==''){
			alert("Please enter the number of stories.");
			return false;
		}else if( noofstory=='0'){
			alert("Please enter valid number of stories.");
			return false;
		}

	});


	$("#selectAll").click(function(){
        $("input[type=checkbox]").prop('checked', $(this).prop('checked'));

});


</script>

	