<?php 
if(!empty($content_data)){
$datanew  = $content_data[0]['option_value'] ;
$result = json_decode($datanew,true);

//echo $result;
//die;
}
?>

{!! Form::label('Footer data', 'Footer Data', ['class'=>'form-control-label'])!!}
{!! Form::text('footer_data', !empty($result['footer_data']) ? $result['footer_data'] : '', [
	'class'=>'form-control footer_data',
	'id'=> 'footer_data',
	'placeholder'=>'Footer Data'
	])!!}

	<script type="text/javascript">
		$(".add_form, .apply_form").on('click', function(){
			var footer_data  = $("#footer_data").val();

		if(footer_data==''){
			alert("Enter the Footer data ");
			return false;
		}
	});
	</script>

	