@php 
	$field = (object) $field;
	$readonly = (!empty($field->readonly) && $field->readonly) ? 'readonly' : '';
	$required = (!empty($field->validation) && strpos($field->validation,"required")!=="false") ? 'required' : '';
	
	$class_added_required =  $required ;
	
	$input_attr['id'] = $field->column_name . '-text' ;
	
	$input_attr['class'] = 'form-control' . ' ' . $field->column_name;
	
	if(!empty($field->placeholder)) {
		$input_attr['placeholder'] = ucfirst($field->placeholder);
	}
	else {
		$input_attr['placeholder'] = ucfirst(str_replace('_', ' ',$field->column_name));
	}
	
	if(!empty($required)) {
		$input_attr['required'] = true;
	}
	
	if(!empty($field->multiple)) {
		$input_attr['multiple'] = 'true';
	}
	
	if(!empty($field->min)) {
		$input_attr['min'] = $field->min;
	}
	
	$default_value = null;
	if(!empty($field->default_value)) {
		$default_value = $field->default_value;
	}
	
	
@endphp
						
@if($field->label_text !='')
	{!! Form::label($field->column_name,$field->label_text,['class'=>' col-sm-6 col-form-label '.$class_added_required]) !!}
@endif

@if($field->input_type =='text')
{!! 
	Form::text(
	$field->column_name, (isset($params['result']) && isset($params['result'][$field->column_name]))?$params['result'][$field->column_name]:null, $input_attr )
!!}

@elseif($field->input_type =='hidden')
{!! 
	Form::hidden(
	$field->column_name, (isset($params['result']) && isset($params['result'][$field->column_name]))?$params['result'][$field->column_name]:null, ['class'=>'form-control' . ' ' . $field->column_name] )
!!}

@elseif($field->input_type =='datetime-local')
{!! 
	Form::input('dateTime-local',
	$field->column_name, (isset($params['result']) && isset($params['result'][$field->column_name]))? date('Y-m-d\TH:i', strtotime($params['result'][$field->column_name])):null, $input_attr)
!!}

@elseif($field->input_type =='textarea' || $field->input_type =='editor')
{!! 
	Form::textarea($field->column_name, (isset($params['result']) && isset($params['result'][$field->column_name]))?$params['result'][$field->column_name]:null, $input_attr )
!!}
	@if($field->input_type =='editor')
	<script type="text/javascript">
		$(document).ready(function () {CKEDITOR.replace('{{ $field->column_name  }}' ,{enterMode : Number(2), disableNativeSpellChecker:false, filebrowserImageUploadUrl : "", filebrowserUploadMethod: 'form' }); });
	</script>
	@endif

@elseif($field->input_type =='checkbox')
	{!! Form::checkbox($field->column_name, 1 ,(isset($params['result']) && isset($params['result'][$field->column_name]) && $params['result'][$field->column_name]==1)?'checked':null,['class'=>'' . ' ' . $field->column_name]) !!}

@elseif($field->input_type =='select' || $field->input_type =='select2')
	{!!Form::select( !empty($field->multiple) ? $field->column_name . '[]' : $field->column_name, $field->select_data, (isset($params['result']) && isset($params['result'][$field->column_name]))?$params['result'][$field->column_name]:$default_value, $input_attr)!!}
	
	@if($field->input_type=='select2')
		@php unset($input_attr['placeholder']); @endphp
	<script type="text/javascript">
		$(document).ready(function() { 
			$('#{{ $field->column_name . "-text" }}').select2({placeholder: '{{!empty($field->placeholder) ? $field->placeholder : "Select Option"}}'});
		});
	</script>
	@endif

@elseif($field->input_type =='file')
	{!! Form::file($field->column_name,['class'=>'' . ' ' . $field->column_name]) !!}
	{{-- for image print upload code--}} 
	@if(isset($params['result']) &&  isset($params['result'][$field->column_name]) && $params['result'][$field->column_name] !='')
	<img src="{{ $imageBasePath.$params['result'][$field->column_name] }}" width="100" height="100" title="{{ ($field->placeholder !='')?ucfirst($field->placeholder):ucfirst(str_replace("_"," ",$field->column_name)) }}" class="img-fluid">
	@endif
	

@else
	@if(\View::exists($theme.'.common.includes.'.$field->input_type))
		@include($theme.'.common.includes.'.$field->input_type)
	@endif
@endif

@error($field->column_name)
    <div class="alert alert-danger">{{ $message }}</div>
@enderror