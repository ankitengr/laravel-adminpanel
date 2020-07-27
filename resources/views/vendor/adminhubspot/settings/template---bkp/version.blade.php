<?php 
if(!empty($content_data)){
$datanew  = $content_data[0]['option_value'] ;
$result = json_decode($datanew,true);

//echo $result;
//die;
}
?>

{!! Form::label('Type Version No', 'Type Version No', ['class'=>'form-control-label'])!!}
{!! Form::text('addfield', !empty($result['addfield']) ? $result['addfield'] : '', [
	'class'=>'form-control version_no',
	'placeholder'=>'Type Version No'
	])!!}

	{{--
{!! Form::label('fact_check_rating', 'Fact check rating', ['class'=>'form-control-label'])!!}
{!! Form::select('fact_check_rating', !empty($fact_check_option) ? $fact_check_option : 1, !empty($content_data[0]['fact_check_rating']) ? $content_data[0]['fact_check_rating'] : '0', [
	'class'=>'form-control fact_check_rating'
	])!!}
	

{!! Form::label('share_the_claim_url', 'Share the claim url', ['class'=>'form-control-label'])!!}
{!! Form::text('share_the_claim_url', !empty($content_data[0]['share_the_claim_url']) ? $content_data[0]['share_the_claim_url'] : '', [
	'class'=>'form-control who_made_the_claim',
	'placeholder'=>'Share the claim url'
	])!!}

{!! Form::label('claim_published_date', 'Claim published date', ['class'=>'form-control-label'])!!}
{!! Form::text('claim_published_date', !empty($content_data[0]['claim_published_date']) ? $content_data[0]['claim_published_date'] : '', [
	'class'=>'form-control claim_published_date',
	])!!}

{!! Form::label('claim_description', 'Claim description', ['class'=>'form-control-label'])!!}
{!! Form::textarea('claim_description', !empty($content_data[0]['claim_description']) ? $content_data[0]['claim_description'] : '', [
	'class'=>'form-control claim_description',
	'placeholder'=>'claim description',
	'style'=>'height: 39px;'
	])!!}


{!! Form::label('alternate_name', 'Alternate name', ['class'=>'form-control-label'])!!}
{!! Form::text('alternate_name', !empty($content_data[0]['alternate_name']) ? $content_data[0]['alternate_name'] : '', [
	'class'=>'form-control alternate_name',
	'placeholder'=>'Alternate Name'
	])!!}

{!! Form::label('our_conclusion', 'Our Conclusion', ['class'=>'form-control-label'])!!}
{!! Form::textarea('our_conclusion', !empty($content_data[0]['our_conclusion']) ? $content_data[0]['our_conclusion'] : '', [
	'class'=>'form-control our_conclusion',
	'placeholder'=>'Our Conclusion',
	'style'=>'height: 39px;'
	])!!}
	--}}