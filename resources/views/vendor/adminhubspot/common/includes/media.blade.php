@php
	if(empty($field->label_text)) {
		$field->label_text = ucwords(str_replace('_', ' ', $field->column_name));
	}
	
@endphp

<div id = "{{$field->column_name}}-field-group">
	<input type='hidden' name="{{$field->column_name}}" id="{{$field->column_name}}" value="{{isset($params['result'][$field->column_name]) ? $params['result'][$field->column_name] : 0 }}" >
	<div class="inside">
		<ul id="sortable-{{$field->column_name}}" class="sortable-list">
			@if( empty($params['result'][$field->column_name]) ) 
				<li class="ui-state-default"><div style="overflow: auto;"><p class="hide-if-no-js"><a href="javascript:void(0);" id="set-post-thumbnail-feature_image" class="thickbox" onclick="prepare_media_frame('{{$field->column_name}}','{{$field->multiple}}','{{!empty($field->extra->media_type) ? $field->extra->media_type : 'image'}}'); return false;">{{$field->placeholder}}</a></p><p style="font-weight: bold;font-style: italic;">{{$field->help_text}} </p></div></li>
			@endif
		</ul>
	</div>
	<script>
	@if( !empty($params['result'][$field->column_name]) )
		prepare_media('{{$field->column_name}}','{{$field->multiple}}');
	@endif
	@if(!empty($field->extra->sortable))
	$( function() {
		$( "#sortable-{{$field->column_name}}" ).sortable({
			update: function( event, ui ) {
				var items = [];
				$("#sortable-{{$field->column_name}} li").each(function() {
					var data = $(this).data();
					if (typeof data.id !== "undefined") {
						items.push(data.id);
					}
					
				});
				$('#{{$field->column_name}}').val(items);
			}
		});
		
		$( "#sortable-{{$field->column_name}}" ).disableSelection();
	});
	@endif
 
	</script>
</div>