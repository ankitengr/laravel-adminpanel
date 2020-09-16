@inject('AttributesTraits', 'App\Helpers\AttributesHelper')
@php
	//print_r($field);
	$my_fields_info = $AttributesTraits->getAttributes($field->column_name, $fields=[], $func_type='create_func');
	if(!empty($my_fields_info)) {
		$my_fields = ($my_fields_info['left'][$field->column_name]->fields);
	}
	
	$main_field = 'multi_title';
@endphp

<input type='hidden' name="{{$field->column_name}}" id="{{$field->column_name}}" value="{{isset($params['result'][$field->column_name]) ? json_encode($params['result'][$field->column_name]) : '[]' }}" >

<div id="frmMultiData" class="form-horizontal">
	@if(empty($my_fields))
	<div class="form-group">
		<label for="href">Title</label>
		<input type='text' id="mutli_title" name="multi_title" class="form-control multi_title item-menu" placeholder="Title" />
	</div>
	@else
		@foreach($my_fields as $my_field)
			@php 
				$my_field = (object) $my_field;
				//print_r($my_field->extra);
				if(!empty($my_field->extra->main_field)) {
					$main_field = $my_field->column_name;
				}
			@endphp
			<div class="form-group">
				@if(!empty($my_field->label_text))
				<label for="href">{{$my_field->label_text}}</label>
				@endif
				
				@if($my_field->input_type == 'textarea' || $my_field->input_type == 'editor')
					<textarea id="{{$my_field->column_name}}" name="{{$my_field->column_name}}" class="form-control {{$my_field->column_name}} item-menu"></textarea>
					@if($my_field->input_type =='editor')
					<script type="text/javascript">
						$(document).ready(function () {CKEDITOR.replace('{{ $my_field->column_name  }}' ,{enterMode : Number(2), disableNativeSpellChecker:false, filebrowserImageUploadUrl : "", filebrowserUploadMethod: 'form' }); });
					</script>
					@endif
				@elseif($my_field->input_type =='select' || $my_field->input_type =='select2')
					{!!Form::select( !empty($my_field->multiple) ? $my_field->column_name . '[]' : $my_field->column_name, $my_field->select_data, (isset($params['result']) && isset($params['result'][$my_field->column_name]))?$params['result'][$my_field->column_name]:null, ['class' => 'form-control' . ' ' . $my_field->column_name. ' item-menu'])!!}
				
				@else
				<input type='{{$my_field->input_type}}' id="{{$my_field->column_name}}" name="{{$my_field->column_name}}" class="form-control {{$my_field->column_name}} item-menu" placeholder="{{$my_field->placeholder}}" />
				@endif
			</div>
		@endforeach
	@endif
	<div class="card-footer">
        <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i class="fas fa-sync-alt"></i> Update</button>
        <button type="button" id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
    </div>
</div>

<style>
  #sortable-multi-data { list-style-type: none; margin: 0; padding: 0; width: 100%; margin-top:5px;}
  #sortable-multi-data li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; background-color:#f6f6f6}
  #sortable-multi-data li span {  }
  </style>

<ul id="sortable-multi-data" class="multi-list">
  
</ul>

<script>
	var idSelector = 'sortable-multi-data';
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
	
	var action = 'multi-data';
	
	var $ids = "{{!empty($params['result'][$field->column_name]) ? implode(',',$params['result'][$field->column_name]) : '' }}"
	
	$.ajax({
			type : 'get',
			url:"{{route('ajax.index')}}",
			data:$.param({action:action, ids: $ids}),
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
						newItem['id'] = val;
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
		fd.append('action', 'multi-data');
		fd.append('attribute', '{{$field->column_name}}');
		fd.append('relational_ids', $('#{{$field->column_name}}').val());
		//fd.append(mainIdField, data[mainIdField]);
		fd.append('content', JSON.stringify(data));
		
		
		
		$.ajax({
			type : 'post',
			url:'/admin/ajax',
			data:fd,
			processData: false,
			contentType: false,
			success:function(response){
			  //console.log(response);
				data.id = parseInt(response);
				updatefieldcolumnvalue(data.id);
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
	
	function updatefieldcolumnvalue(id) {
		var dataJson = JSON.parse($('#{{$field->column_name}}').val());
		var items = [];
		items.push(id);
		$.each(dataJson, function (index, item) {
			items.push(item);
		});
		$('#{{$field->column_name}}').val(JSON.stringify(items));
	}

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
		fd.append('action', 'multi-data');
		fd.append('attribute', '{{$field->column_name}}');
		fd.append('id', itemEditing.data('id'));
		fd.append('content', JSON.stringify(data));
		
		
		
		$.ajax({
			type : 'post',
			url:'/admin/ajax',
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
				if(p == 'id') {
					var url = '{{ route("ajax.destroy", ":id") }}';
					url = url.replace(':id', v);
					$.ajax({
						type : 'DELETE',
						url:url,
						data:{
							_token:'{{ csrf_token() }}',
							action: 'multi-data'
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