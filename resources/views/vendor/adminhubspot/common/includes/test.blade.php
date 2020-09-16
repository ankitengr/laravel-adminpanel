<div class="card border-primary mb-3">
    <div class="card-body">
        <div id="frmMultiLiveBlog" class="form-horizontal">
			<div class="form-group">
				<label for="href">Description</label>
				<textarea id="data_desc" class="form-control description item-menu" placeholder="Description" name="data_desc" cols="50" rows="10"></textarea>
				<script type="text/javascript">
				$(document).ready(function () {var editor_data_desc = CKEDITOR.replace('data_desc' ,{enterMode : Number(2), disableNativeSpellChecker:false, filebrowserImageUploadUrl : "", filebrowserUploadMethod: 'form' }); });
				</script>
			</div>
			
			<div id="files_dropzone">Files</div>
			
			<input type="hidden" class="item-menu" name="comment_id" id="comment_id" value="">
        </div>
    </div>
    <div class="card-footer">
        <button type="button" id="btnUpdate" class="btn btn-primary" disabled><i class="fas fa-sync-alt"></i> Update</button>
        <button type="button" id="btnAdd" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
    </div>
</div>

<style>
  #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; background-color:#f6f6f6}
  #sortable li span {  }
  </style>

<ul id="sortable">
  
</ul>

<script src="{{ asset('/plugins/dropzone-master/dist/dropzone.js') }}"></script>
<link  rel="stylesheet" href="{{ asset('/plugins/dropzone-master/dist/dropzone.css') }}">

<script>
var myDropzone = new Dropzone("div#files_dropzone", { url: "/file/post"});
	var idSelector = 'sortable';
	$( function() {
		$( "#" + idSelector ).sortable();
		$( "#" + idSelector ).disableSelection();
	} );
	
	$formLiveBlog = $('#frmMultiLiveBlog');
	$feedList = $('#' + idSelector);
	$feedListButtons = '<div class="btn-group float-right"><a class="btn btn-primary btn-sm btnEdit clickable" href="#"><i class="fas fa-edit clickable"></i></a><a class="btn btn-danger btn-sm btnRemove clickable" href="#"><i class="fas fa-trash-alt clickable"></i></a></div>';

	$updateButton = $('#btnUpdate');

	itemEditing = null;
	
	var arrayJson = [{"comment_title" : "a", "comment_desc" : "", "comment_image" : "", "comment_id" : ""},{"comment_title" : "b", "comment_desc" : "", "comment_image" : "", "comment_id" : ""}];
	
	
	console.log(arrayJson);
	
	function prepareList(dataJson) {
		$.each(dataJson, function (index, item) {
			var textItem = '<span class="txt" style="margin-right: 5px;">' + item.comment_title + '</span>';
			var div = $('<div>').css({"overflow": "auto"}).append(textItem).append($feedListButtons);
			var $li = $("<li>").data(item);
			$li.addClass('ui-state-default').append(div);
			$feedList.append($li);			
		});
	}
	
	//prepareList(arrayJson);
	
	function resetForm() {
		$formLiveBlog.find('.item-menu').each(function(){
			$(this).val('');
		});
		$updateButton.attr('disabled', true);
		itemEditing = null;
	}
	  
	$(document).on('click', '#btnAdd', function (e) {
		e.preventDefault();
		var data = {};
		var spanText = '';
		$formLiveBlog.find('.item-menu').each(function(i, item){
			if(i==0) {
				spanText = CKEDITOR.instances.data_desc.getData();
			}
			data[$(this).attr('name')] = $(this).val();
		});
		
		if(spanText == '') {
			alert('First Value required');
			return;
		}
		
		var textItem = '<span class="txt" style="margin-right: 5px;">' + spanText + '</span>';
		var div = $('<div>').css({"overflow": "auto"}).append(textItem).append($feedListButtons);
		var $li = $("<li>").data(data);
		$li.addClass('ui-state-default pr-0').append(div);
		$feedList.prepend($li);	
		//resetForm();
		var _token = "{{ csrf_token() }}" ;
		
		var fd = new FormData();
        //var files = $('#comment_image')[0].files[0];
        fd.append('_token', _token);
		fd.append('content', JSON.stringify(data));
		
		
		
		$.ajax({
			type : 'post',
			url:'{{route('live-blog.store')}}',
			data:fd,
			processData: false,
			contentType: false,
			success:function(data){
			  console.log(data);
			   //add_comment_id(data);

			}
        })
		
		
		//console.log(data);
	});

	$(document).on('click', '#btnUpdate', function (e) {
		e.preventDefault();
		$cEl = itemEditing ;
		if($cEl == null) {
			return;
		}
		$formLiveBlog.find('.item-menu').each(function(i){
			if(i==0) {
				//spanText = $(this).val().trim();
				spanText = CKEDITOR.instances.data_desc.getData();
			}
			
			if(spanText != '') {
				$cEl.data($(this).attr('name'), $(this).val());
			}
		});
		if(spanText == '') {
			alert('First Value required');
			return;
		}
		
		$cEl.find('span.txt').first().text(spanText);
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
            $(this).closest('li').remove();
            var isMainContainer = false;
            if (typeof list.attr('id') !== 'undefined') {
                isMainContainer = (list.attr('id').toString() === idSelector);
            }
            $updateButton.attr('disabled', true);
			itemEditing = null;
            //MenuEditor.updateButtons($main);
        }
    });

	function editItem($item) {
		var data = $item.data();
		//console.log(data);
		$.each(data, function (p, v) {
			$formLiveBlog.find("[name=" + p + "]").val(v);
		});
		$formLiveBlog.find(".item-menu").first().focus();
		$updateButton.removeAttr('disabled');
			
	}
</script>