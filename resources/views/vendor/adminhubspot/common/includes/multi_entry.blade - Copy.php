<div id="frmMultiData" class="form-horizontal">
@php 
	$fields = $field->fields;
	$main_field = 'multi_data_title';
	foreach($fields as $field) {
		$field = (object) $field;
		$main_field = (!empty($field->main_field) && $field->main_field) ? $field->column_name : $main_field;
		
		$readonly = (!empty($field->readonly) && $field->readonly) ? 'readonly' : '';
		$required = (!empty($field->validation) && strpos($field->validation,"required")!=="false") ? 'required' : '';
		
		$class_added_required =  $required ;
		
		$input_attr['id'] = str_replace('[]', '', $field->column_name) .'-text' ;
		
		$input_attr['class'] = 'form-control item-menu' . ' ' . $field->column_name;
		
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
	
	echo '<div class="form-group">';
	if($field->label_text !='') {
		echo Form::label($field->column_name,$field->label_text,['class'=>' col-sm-6 col-form-label '.$class_added_required]) ;
	}
	
	if($field->input_type =='text') {
		echo Form::text(
		$field->column_name, (isset($params['result']) && isset($params['result'][$field->column_name]))?$params['result'][$field->column_name]:null, $input_attr ) ;

	} 
	elseif($field->input_type =='hidden') {
		echo Form::hidden(
		$field->column_name, (isset($params['result']) && isset($params['result'][$field->column_name]))?$params['result'][$field->column_name]:null, $input_attr ) ;

	}
	elseif($field->input_type =='datetime-local') {
		echo Form::input('dateTime-local',
		$field->column_name, (isset($params['result']) && isset($params['result'][$field->column_name]))? date('Y-m-d\TH:i', strtotime($params['result'][$field->column_name])):null, $input_attr) ;

	}
	elseif($field->input_type =='textarea' || $field->input_type =='editor') {
		echo Form::textarea($field->column_name, (isset($params['result']) && isset($params['result'][$field->column_name]))?$params['result'][$field->column_name]:null, $input_attr );
		
		if($field->input_type =='editor') { @endphp
		<script type="text/javascript">
			$(document).ready(function () {CKEDITOR.replace('{{ $field->column_name  }}' ,{enterMode : Number(2), disableNativeSpellChecker:false, filebrowserImageUploadUrl : "", filebrowserUploadMethod: 'form' }); });
		</script>
		@php 
		}

	}
	elseif($field->input_type =='checkbox') {
		echo Form::checkbox($field->column_name, 1 ,(isset($params['result']) && isset($params['result'][$field->column_name]) && $params['result'][$field->column_name]==1)?'checked':null,['class'=>'' . ' ' . $field->column_name]) ;

	}
	elseif($field->input_type =='select' || $field->input_type =='fselect') {
			echo Form::select($field->column_name, $field->select_data, (isset($params['result']) && isset($params['result'][$field->column_name]))?$params['result'][$field->column_name]:null, $input_attr) ;
	
	}
	elseif($field->input_type =='file') {
		echo Form::file($field->column_name,['class'=>'' . ' ' . $field->column_name]) ;
		
		if(isset($params['result']) &&  isset($params['result'][$field->column_name]) && $params['result'][$field->column_name] !='') { @endphp
			<img src="{{ $imageBasePath.$params['result'][$field->column_name] }}" width="100" height="100" title="{{ ($field->placeholder !='')? ucfirst($field->placeholder):ucfirst(str_replace('_',' ',$field->column_name)) }}" class="img-fluid">
		@php
		}
	
	}
	echo '</div>';

}
	
	
@endphp
	<div class="card-footer">
        <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i class="fas fa-sync-alt"></i> Update</button>
        <button type="button" id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
    </div>
</div>
<!--
			<div class="form-group">
				<label for="href">Description</label>
				<textarea id="highlight_desc" class="form-control description item-menu" placeholder="Description" name="highlight_desc" cols="50" rows="10"></textarea>
				<script type="text/javascript">
				$(document).ready(function () {CKEDITOR.replace('highlight_desc' ,{enterMode : Number(2), disableNativeSpellChecker:false, filebrowserImageUploadUrl : "", filebrowserUploadMethod: 'form', allowedContent: true }); });
				</script>
			</div>
			<input type="hidden" class="item-menu" name="highlight_id" id="highlight_id" value="">
        
    <div class="card-footer">
        <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i class="fas fa-sync-alt"></i> Update</button>
        <button type="button" id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
    </div>

-->

<style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; background-color:#f6f6f6}
  #sortable li span {  }
  </style>

<ul id="sortable" class="multi-list">
  
</ul>

<script>
	var idSelector = 'sortable';
	$( function() {
		$( "#" + idSelector ).sortable();
		$( "#" + idSelector ).disableSelection();
	} );
	
	$formMultiData = $('#frmMultiData');
	$feedList = $('#' + idSelector);
	$feedListButtons = '<div class="btn-group float-right"><a class="btn btn-primary btn-sm btnEdit clickable" href="#"><i class="fas fa-edit clickable"></i></a><a class="btn btn-danger btn-sm btnRemove clickable" href="#"><i class="fas fa-trash-alt clickable"></i></a></div>';

	$updateButton = $('#btnUpdate');

	itemEditing = null;
	
	var mainField = '{{$main_field}}';
	var mainIdField = 'multi_data_id';
	
	//var arrayJson = [{"highlight_title" : "a", "highlight_desc" : "ad"},{"highlight_title" : "b", "highlight_desc" : "bd"}];
	var arrayJson = [];
	
	$.ajax({
			type : 'get',
			url:'{{route('attribute_multi_data_values.index')}}',
			data:$.param({attribute_id: 1, content_id:'{{$params['id']}}', entity_type: '{{$params['controller']}}'}),
			processData: false,
			contentType: false,
			success:function(response){
			  dataJson = JSON.parse(response);
			  arrayJson = [];
			  $.each(dataJson, function (index, item) {
				newItem = {};
				$.each(item, function (key, val) {
					//console.log(key);
					if(key == 'id') {
						newItem[mainIdField] = val;
					}
					
					if(key == 'content') {
						var contentJson = JSON.parse(val);
						$.each(contentJson, function (key1, val1) {
							if(key1==mainField) {
								newItem[mainField] = val1 ;
							}
							else if(key1 != mainIdField){
								newItem[key1] = val1 ;
							}
						});

					}
					
				});
				arrayJson.push(newItem);
			  });
			  console.log(arrayJson);
			  
			  prepareList(arrayJson);
			
			}
        })
	
	function prepareList(dataJson) {
		$.each(dataJson, function (index, item) {
			var textItem = '';
			$.each(item, function (key, val) {
				if(key == mainField) {
					textItem = '<span class="txt" style="margin-right: 5px;">' + val + '</span>';
				}
			});
			var div = $('<div>').css({"overflow": "auto"}).append(textItem).append($feedListButtons);
			var $li = $("<li>").data(item);
			$li.addClass('ui-state-default').append(div);
			$feedList.append($li);			
		});
	}
	

	function resetForm() {
		$formMultiData.find('.item-menu').each(function(){
			$(this).val('');
		});
		
		$('textarea.item-menu').each(function () {
		   var $textarea = $(this);
		   CKEDITOR.instances[$textarea.attr('name')].setData('');
		});
		
		$updateButton.attr('disabled', true);
		itemEditing = null;
	}
	  
	$(document).on('click', '#btnAdd', function (e) {
		e.preventDefault();
		var data = {};
		var spanText = '';
		
		$('textarea.item-menu').each(function () {
		   var $textarea = $(this);
		   $textarea.val(CKEDITOR.instances[$textarea.attr('name')].getData());
		});
		
		
		$formMultiData.find('.item-menu').each(function(i, item){
			if($(this).attr('name') == mainField) {
				spanText = $(this).val() ;
			}
			data[$(this).attr('name')] = $(this).val();
		});
		
		if(spanText == '') {
			alert(mainField + ' required');
			return;
		}
		
			
		
		var _token = "{{ csrf_token() }}" ;
		var fd = new FormData();
        //var files = $('#comment_image')[0].files[0];
        fd.append('_token', _token);
		fd.append('content_id', '{{$params['id']}}');
		fd.append('entity_type', '{{$params['controller']}}');
		fd.append('attribute_id', 1);
		fd.append(mainIdField, data[mainIdField]);
		fd.append('content', JSON.stringify(data));
		
		
		
		$.ajax({
			type : 'post',
			url:'{{route('attribute_multi_data_values.store')}}',
			data:fd,
			processData: false,
			contentType: false,
			success:function(response){
			  //console.log(response);
				data[mainIdField] = parseInt(response);
				var textItem = '<span class="txt" style="margin-right: 5px;">' + spanText + '</span>';
				var div = $('<div>').css({"overflow": "auto"}).append(textItem).append($feedListButtons);
				var $li = $("<li>").data(data);
				$li.addClass('ui-state-default pr-0').append(div);
				$feedList.prepend($li);

			}
        })
		
		resetForm();
		//console.log(data);
	});

	$(document).on('click', '#btnUpdate', function (e) {
		e.preventDefault();
		$cEl = itemEditing ;
		if($cEl == null) {
			return;
		}
		
		var data = {};
		
		$('textarea.item-menu').each(function () {
		   var $textarea = $(this);
		   $textarea.val(CKEDITOR.instances[$textarea.attr('name')].getData());
		});
		
		spanText = '';
		$formMultiData.find('.item-menu').each(function(i){
			console.log($(this).attr('name'));
			
			if($(this).attr('name') == mainField) {
				spanText = $(this).val();
			}
			
			if(spanText != '') {
				$cEl.data($(this).attr('name'), $(this).val());
			}
		
			data[$(this).attr('name')] = $(this).val();
			
		});
		
		
		if(spanText == '') {
			alert(mainField + ' Value required');
			return;
		}
		
		$cEl.find('span.txt').first().text(spanText);
		
		console.log(data);
		//return;
		
		var _token = "{{ csrf_token() }}" ;
		var fd = new FormData();
        //var files = $('#comment_image')[0].files[0];
        fd.append('_token', _token);
		fd.append('content_id', '{{$params['id']}}');
		fd.append('entity_type', '{{$params['controller']}}');
		fd.append('attribute_id', 1);
		fd.append(mainIdField, data[mainIdField]);
		fd.append('content', JSON.stringify(data));
		
		
		
		$.ajax({
			type : 'post',
			url:'{{route('attribute_multi_data_values.store')}}',
			data:fd,
			processData: false,
			contentType: false,
			success:function(data){
			  //console.log(data);
			   //add_comment_id(data);

			}
        })
		
		resetForm();
		
	});

	$(document).on('click', '.btnEdit', function (e) {
		e.preventDefault();
		itemEditing = $(this).closest('li');
		editItem(itemEditing);
	});


	$(document).on('click', '.btnRemove', function (e) {
        e.preventDefault();
        if (confirm('Are you sure to delete?')){
            var list = $(this).closest('ul');
			itemEditing = $(this).closest('li');
			var data = itemEditing.data();
			//console.log(data);
			$.each(data, function (p, v) {
				if(p == mainIdField) {
					var url = '{{ route("attribute_multi_data_values.destroy", ":id") }}';
					url = url.replace(':id', v);
					$.ajax({
						type : 'DELETE',
						url:url,
						data:{
							_token:'{{ csrf_token() }}'
						},
						processData: false,
						contentType: false,
						success:function(response){
							//console.log(response.toString());
						  if(response.toString().trim() == 'true') {
								itemEditing.remove();
								itemEditing = null;
								var isMainContainer = false;
								if (typeof list.attr('id') !== 'undefined') {
									isMainContainer = (list.attr('id').toString() === idSelector);
								}
						  }

						}
					})
				}
			});
			
			
			//console.log(list.data()); return;
			//return;
			
            
			
			$updateButton.attr('disabled', true);
            //MenuEditor.updateButtons($main);
        }
    });

	function editItem($item) {
		var data = $item.data();
		console.log('test');
		console.log(data);
		$.each(data, function (p, v) {
			if(p=='highlight_id') {
				console.log(v);
			}
			$formMultiData.find("[name=" + p + "]").val(v);
		});
		
		$('textarea.item-menu').each(function () {
		   var $textarea = $(this);
		   CKEDITOR.instances[$textarea.attr('name')].setData($(this).val());
		});
		
		$formMultiData.find(".item-menu").first().focus();
		$updateButton.removeAttr('disabled');
			
	}
</script>