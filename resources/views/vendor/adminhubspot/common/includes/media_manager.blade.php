<!--<link rel="stylesheet" href="http://devcms-thelallantop.intoday.in/wp-admin/load-styles.php?c=1&dir=ltr&load=dashicons,buttons,media-views&ver=4.3.1">-->
<style>
  .sortable-list { list-style-type: none; margin: 0; padding: 0; width: 100%; }
  .sortable-list li { margin: 0 3px 3px 3px; padding: 0.4em; background-color:#f6f6f6; float:left;}
  .sortable-list li span {  }
</style>
<link href="{{ asset('/plugins/media-ankit/css/media_manager.css') }}" rel="stylesheet">
<input type="hidden" id="column_id" value="">
<input type="hidden" id="column_multiple" value="">
<input type="hidden" id="media_type" value="all">
<div tabindex="0" id="image_manager" class="supports-drag-drop" style="position: relative; display:none;">
	<div class="media-modal wp-core-ui">
		<button type="button" class="button-link media-modal-close">
			<span class="media-modal-icon"><span class="screen-reader-text">Close media panel</span></span>
		</button>
		
		<div class="media-modal-content">
			<div class="media-frame mode-select wp-core-ui hide-menu" id="__wp-uploader-id-0">
				<div class="media-frame-menu">
					<div class="media-menu"><a href="#" class="media-menu-item active">fffff</a></div>
				</div>
				<div class="media-frame-title"><h1>SET IMAGE<span class="dashicons dashicons-arrow-down"></span></h1></div>
				<div class="media-frame-router">
					<div class="media-router">
						<a href="#" class="media-menu-item" id="media-tab-0">Upload Files</a>
						<a href="#" class="media-menu-item active" id="media-tab-1">Media Library</a>
					</div>
					<a href="#" class="acf-expand-details">
						<span class="is-closed"><span class="acf-icon acf-icon-left small grey"></span>Expand Details</span>
						<span class="is-open"><span class="acf-icon acf-icon-right small grey"></span>Collapse Details</span>
					</a>
				</div>
				<div class="media-frame-content" data-columns="9">
					<div class="attachments-browser">
						<div class="media-toolbar">
							<div class="media-toolbar-secondary">
								<label for="media-attachment-filters" class="screen-reader-text">Filter by type</label>
								<select id="media-attachment-filters" class="attachment-filters">
									<option value="all">Images</option>
									<option value="uploaded">Uploaded to this post</option>
									<option value="unattached">Unattached</option>
								</select>
								<label for="media-attachment-date-filters" class="screen-reader-text">Filter by date</label>
								<select id="media-attachment-date-filters" class="attachment-filters">
									<option value="all">All dates</option>
									<option value="0">August 2020</option>
									<option value="1">May 2020</option>
								</select>
								<span class="spinner"></span>
							</div>
							<div class="media-toolbar-primary search-form">
								<label for="media-search-input" class="screen-reader-text">Search Media</label>
								<input type="search" placeholder="Search" id="media-search-input" class="search">
							</div>
						</div>
						<div class="media-sidebar">
							<div class="media-uploader-status" style="display: none;">
								<h3>Uploading</h3>
								<button type="button" class="button-link upload-dismiss-errors"><span class="screen-reader-text">Dismiss Errors</span></button>
								<div class="media-progress-bar"><div></div></div>
								<div class="upload-details">
									<span class="upload-count">
										<span class="upload-index"></span> / <span class="upload-total"></span>
									</span>
									<span class="upload-detail-separator">–</span>
									<span class="upload-filename"></span>
								</div>
								<div class="upload-errors"></div>
							</div>
							
						</div>
						<ul tabindex="-1" class="attachments ui-sortable ui-sortable-disabled" id="attachments"></ul>
					</div>
					<div class="uploader-inline hidden">
							<div class="uploader-inline-content has-upload-message">
								<h3 class="upload-message">No items found.</h3>
								<div class="upload-ui">
									<h3 class="upload-instructions drop-instructions">Drop files anywhere to upload</h3>
									<p class="upload-instructions drop-instructions">or</p>
									<a href="#" class="browser button button-hero" style="display: inline; position: relative; z-index: 1;" id="__wp-uploader-id-1">Select Files</a>
								</div>

								<div class="upload-inline-status"></div>

								<div class="post-upload-ui">
									<p class="max-upload-size">Maximum upload file size: {{ini_get('upload_max_filesize')}}B.</p>
								</div>
							</div>
					</div>
						
				</div>
				<div class="media-frame-toolbar">
					<div class="media-toolbar">
						<div class="media-toolbar-secondary"></div>
							<div class="media-toolbar-primary search-form">
								<button type="button" class="button media-button button-primary button-large media-button-select">Set Image Button</button>
							</div>
					</div>
				</div>
				<div class="media-frame-uploader">
					<div class="uploader-window">
						<div class="uploader-window-content"><h3>Drop files to upload</h3></div>
					</div>
				</div>
				<div id="html5_1ei0uorpi181s1hehu2c16uejfs5_container" class="moxie-shim moxie-shim-html5" style="position: absolute; top: 0px; left: 0px; width: 0px; height: 0px; overflow: hidden; z-index: 0;">
					<input id="media-select-file" type="file" style="font-size: 999px; opacity: 0; position: absolute; top: 0px; left: 0px; width: 100%; height: 100%;" multiple="" accept="">
				</div>
			</div>
		</div>
	</div>
	<div class="media-modal-backdrop"></div>
</div>

@section('scripts')
<script>
function baseName(str, ext = false){
   var base = new String(str).substring(str.lastIndexOf('/') + 1); 
   if(ext) {
    if(base.lastIndexOf(".") != -1)       
        base = base.substring(0, base.lastIndexOf("."));
   }
   return base;
}
function get_media_data() {
	$.ajax({
		type: "POST",
		dataType: "json",
		url: '/admin/ajax/get_medias', // This is what I have updated
		data: { "_token": "{{ csrf_token() }}", "media_type": $('#media_type').val() }
	}).done(function( response ) {
		//console.log( response );
		$('#attachments').html('');
		var items = [];
		$.each( response, function( key, val ) {
			//console.log(val.file_path);
			var filename_div = ''
			
			val.preview_file = val.file_path ;
			if(val.multimedia_type == 'video') {
				val.preview_file = "{{ asset('/plugins/media-ankit/images/video.png') }}";
				filename_div = '<div class="filename"><div>' + baseName(val.file_path) + '</div></div>';
			}
			else if(val.multimedia_type == 'audio') {
				val.preview_file = "{{ asset('/plugins/media-ankit/images/audio.png') }}";
				filename_div = '<div class="filename"><div>' + baseName(val.file_path) + '</div></div>';
			}
			
			
			
			
			
			var div = '<div class="attachment-preview js--select-attachment type-image subtype-jpeg landscape"><div class="thumbnail"><div class="centered"><img src="' + val.preview_file +'" class="icon" draggable="false" alt=""></div></div>' + filename_div + '</div><button type="button" class="button-link check" tabindex="0"><span class="media-modal-icon"></span><span class="screen-reader-text">Deselect</span></button>';
			
			var $li = $('<li tabindex="' + key +'" role="checkbox" aria-label="Lakme Peach Milk Moisturizer Body Lotion" aria-checked="false" data-id="' + val.id +'" class="attachment save-ready">').data(val);
			//$li.addClass('ui-state-default').append(div);
			$li.append(div);
			$('#attachments').append($li);
			
			
		});
	});
}

function prepare_media_frame(column_id, multiple, media_type='image') {
	$('#column_id').val(column_id);
	$('#column_multiple').val(multiple);
	$('.media-frame-title').html('<h1>' + column_id.replace('_', ' ').toUpperCase() + '<span class="dashicons dashicons-arrow-down"></span></h1>');
	$('.media-button-select').html('Set ' + column_id.replace('_', ' '));
	console.log($('#media_type').val());
	if($('#media_type').val() != media_type){
		$('#attachments').html('');
		$('#media_type').val(media_type);
		get_media_data();
	}
	accept = '';
	if(media_type == 'image') {
		accept="image/png, image/jpeg" ;
	}
	else if(media_type == 'video') {
		accept="video/mp4" ;
	}
	else if(media_type == 'audio') {
		accept="audio/mpeg" ;
	}
	$('#media-select-file').attr('accept',accept);
}




$(function(){
	$(document).on('click', '.thickbox', function(){
		$('#image_manager').show();
	});
	
	if(!isMediaSelected()) {
		$('.media-button-select').attr("disabled",true);
	}
	
	$(document).on('click', '#attachments li', function(){
		if($(this).hasClass('selected')) {
			$(this).removeClass('selected');
			$(this).removeClass('details');
			$('.media-sidebar .attachment-details').remove();
			if(!isMediaSelected()) {
				$('.media-button-select').attr("disabled",true);
			}
		}
		else {
			if($('#column_multiple').val() == ''){
				$('#attachments li').removeClass('selected');
				$('#attachments li').removeClass('details');
			}
			$(this).addClass('selected');
			$(this).addClass('details');
			
			var data = $(this).data();
			//console.log(data);
			
			var div = '<div tabindex="0" data-id="' + data.id +'" class="attachment-details save-ready">' 
						+ '<h3>Attachment Details<span class="settings-save-status"><span class="spinner"></span><span class="saved">Saved.</span></span></h3>'
						+ '<div class="attachment-info"><div class="thumbnail thumbnail-image"><img src="' + data.preview_file +'" class="icon" draggable="false"></div><div class="details"><div class="filename">' + baseName(data.file_path) + '</div><div class="uploaded">' + data.created_at + '</div><div class="file-size">' + data.file_size + '</div><button type="button" class="button-link delete-attachment">Delete Permanently</button><div class="compat-meta"></div></div></div>'
						+ '<label class="setting" data-setting="url"><span class="name">URL</span><input type="text" value="' + data.file_path + '" readonly=""></label>'
						+ '<label class="setting" data-setting="title"><span class="name">Title</span><input type="text" value="7"></label>'
						+ '<label class="setting" data-setting="caption"><span class="name">Caption</span><textarea></textarea></label>'
						+ '<label class="setting" data-setting="alt"><span class="name">Alt Text</span><input type="text" value=""></label><label class="setting" data-setting="description"><span class="name">Description</span><textarea></textarea></label>'
					+ '</div>';
							
			$('.media-sidebar').html(div);
			$('.media-button-select').removeAttr("disabled");
		}
	});
	
	$('.media-modal-close').on('click', function(){
		$('#image_manager').hide();
	});
	
	
	function isMediaSelected() {
		var return_val = false;
		$("#attachments li").each(function(key) {
			if($(this).hasClass('selected')) {
				return_val = true;
				return false;
			}
		});
		return return_val;
	}
	
	
	$('.media-button-select').on('click', function(){
		var column_id = $('#column_id').val();
		var multiple = $('#column_multiple').val();
		if(isMediaSelected()) {
			var items = [];
			console.log(multiple);
			if(multiple != 1){
				$('#' + column_id).val('');
				$('#sortable-' + column_id).html('');
			}
			
			$("#attachments li").each(function() {
				if($(this).hasClass('selected')) {
					var data = $(this).data();
					
					items.push(data.id);
					
					var preview_div = '<p class="hide-if-no-js"><a href="javascript:void(0);" id="set-post-thumbnail-' + column_id + '"  class="thickbox" onclick="prepare_media_frame(\'' + column_id + '\', \'' + multiple + '\',\'image\'); return false;"><img width="200" height="113" src="' + data.file_path + '" class="attachment-post-thumbnail" alt=""></a></p>';
					if(data.multimedia_type == 'video') {
						preview_div = '<p class="hide-if-no-js"><a href="javascript:void(0);" id="set-post-thumbnail-' + column_id + '"  class="thickbox", onclick="prepare_media_frame(\'' + column_id + '\', \'' + multiple + '\',\'video\'); return false;"><video width="200" height="113" controls><source src="' + data.file_path + '" type="video/mp4">Your browser does not support the video tag.</video></a></p>';
					}
					else if(data.multimedia_type == 'audio') {
						preview_div = '<p class="hide-if-no-js"><a href="javascript:void(0);" id="set-post-thumbnail-' + column_id + '"  class="thickbox", onclick="prepare_media_frame(\'' + column_id + '\', \'' + multiple + '\',\'audio\'); return false;"><audio style="width:200px;height:75px" controls><source src="' + data.file_path + '" type="audio/mpeg">Your browser does not support the audio tag.</audio></a></p>';
					}
					
					var removeButton = '<p class="hide-if-no-js"><a href="javascript:void(0);" id="remove-post-thumbnail-"' + column_id + '" onclick="RemoveMediaID(' + data.id + ');return false;">Remove</a></p>';
					var div = $('<div>').css({"overflow": "auto"}).append(preview_div).append(removeButton);
					var $li = $("<li>").data(data);
					$li.addClass('ui-state-default').append(div);
					$('#sortable-' + column_id).append($li);
					
					
				}
			});
			if(multiple != 1 || $('#' + column_id).val() == ''){
				$('#' + column_id).val(items);
			} else {
				$('#' + column_id).val($('#' + column_id).val() + ',' + items);
			}
			$('#image_manager').hide();
		}
		//console.log(SelectedImages);
	});
	
	$('.media-router .media-menu-item').on('click', function(){
		$('.media-menu-item').removeClass('active');
		$(this).addClass('active');
		
		if($(this).attr('id') == 'media-tab-0') {
			$('.attachments-browser').addClass('hidden');
			$('.uploader-inline').removeClass('hidden');
		}
		else if($(this).attr('id') == 'media-tab-1') {
			$('.attachments-browser').removeClass('hidden');
			$('.uploader-inline').addClass('hidden');
		}
	});
	
	$('.browser').click(function(){ $('#media-select-file').trigger('click'); });
	
	$('#media-select-file').change(function (e) {
		console.log(e.target.files);
		var fd = new FormData();
		
		for(var i = 0; i < e.target.files.length; i++){
			fd.append(e.target.files[i].name, e.target.files[i]);
			
			
			var div = '<div class="attachment-preview js--select-attachment type-image subtype-jpeg landscape"><div class="thumbnail"><div class="media-progress-bar"><div style="width: 30%"></div></div></div></div><button type="button" class="button-link check" tabindex="0"><span class="media-modal-icon"></span><span class="screen-reader-text">Deselect</span></button>';
			
			var $li = $('<li tabindex="0" role="checkbox" aria-checked="true" class="attachment uploading save-ready selected details">');
			//$li.addClass('ui-state-default').append(div);
			$li.append(div);
			$('#attachments').prepend($li);
			
		}
		$('#media-tab-1').trigger('click');
		console.log(fd.entries());
		
		
		$.ajax({ 
				url: '/admin/ajax/media_upload',
				type: 'post', 
				data: fd, 
				contentType: false, 
				processData: false, 
				success: function(response){ 
					if(response != 0){
						get_media_data();
						$('#media-tab-1').trigger('click');
					} 
					else{
						alert('file not uploaded'); 
						get_media_data();
					} 
				}, 
			});
		
        //var fileName = $(this).val().split('\\')[$(this).val().split('\\').length - 1];
        //filePath.html("<b>Selected File: </b>" + fileName);
    });
	
	
	
	
	
	
	
});

function prepare_media(column_id, multiple) {
		//console.log(column_id);
		var values = $('#' + column_id).val();
		$.ajax({
			type: "POST",
			dataType: "json",
			url: '/admin/ajax/get_media_data/' + values, // This is what I have updated
			data: { "_token": "{{ csrf_token() }}", id: values }
		}).done(function( response ) {
				console.log(response);
				if(response[0]) {
					$('#sortable-' + column_id).html('');
					$.each( response, function( key, val ) {
						var preview_div = '<p class="hide-if-no-js"><a href="javascript:void(0);" id="set-post-thumbnail-' + column_id + '"  class="thickbox" onclick="prepare_media_frame(\'' + column_id + '\', \'' + multiple + '\',\'image\'); return false;"><img width="200" height="113" src="' + response[key].file_path + '" class="attachment-post-thumbnail" alt=""></a></p>';
						if(response[key].multimedia_type == 'video') {
							preview_div = '<p class="hide-if-no-js"><a href="javascript:void(0);" id="set-post-thumbnail-' + column_id + '"  class="thickbox", onclick="prepare_media_frame(\'' + column_id + '\', \'' + multiple + '\',\'video\'); return false;"><video width="200" height="113" controls><source src="' + response[key].file_path + '" type="video/mp4">Your browser does not support the video tag.</video></a></p>';
						}
						else if(response[key].multimedia_type == 'audio') {
							preview_div = '<p class="hide-if-no-js"><a href="javascript:void(0);" id="set-post-thumbnail-' + column_id + '"  class="thickbox", onclick="prepare_media_frame(\'' + column_id + '\', \'' + multiple + '\',\'audio\'); return false;"><audio style="width:200px;height:75px" controls><source src="' + response[key].file_path + '" type="audio/mpeg">Your browser does not support the audio tag.</audio></a></p>';
						}
						
						var removeButton = '<p class="hide-if-no-js"><a href="javascript:void(0);" id="remove-post-thumbnail-"' + column_id + '" onclick="RemoveMediaID(' + response[key].id + ');return false;">Remove</a></p>';
						var div = $('<div>').css({"overflow": "auto"}).append(preview_div).append(removeButton);
						var $li = $("<li>").data(val);
						$li.addClass('ui-state-default').append(div);
						$('#sortable-' + column_id).append($li);
						
						//$('#set-post-thumbnail-' + column_id).html(preview_div);
						//$('#remove-post-thumbnail-' + column_id).attr("onclick", "RemoveThumbnail('" + response[key].id + "');return false;");
						//$('#remove-post-thumbnail-' + column_id).show();
					});
				}
					
				//console.log(response[0]);
		});
}
</script>
@endsection