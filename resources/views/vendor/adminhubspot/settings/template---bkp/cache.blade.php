<?php 
if(!empty($content_data)){
$datanew  = $content_data[0]['option_value'] ;
$result = json_decode($datanew,true);

//echo $result;
//die;
}
?>

{!! Form::label('Cache url', 'Cache URL', ['class'=>'form-control-label'])!!}
{!! Form::text('cache_url', !empty($result['cache_url']) ? $result['cache_url'] : '', [
	'class'=>'form-control cache_url',
	'id'=> 'cache_url',
	'placeholder'=>'Cache URL'
	])!!}

	<script type="text/javascript">
		$(".add_form, .apply_form").on('click', function(){
			var cache_url  = $("#cache_url").val();

		if(cache_url==''){
			alert("Enter the Cache url ");
			return false;
		}
	});
	</script>

	