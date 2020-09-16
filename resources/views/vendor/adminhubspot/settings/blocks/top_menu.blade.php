<?php 
$jsonInputData = !empty($result) ? json_encode($result) : '[{"id":1,"title":"Top Level","url":"https://example.org/","__domenu_params":[],"children":[{"id":2,"title":"Sub Menu","url":"https://sub.example.org/","__domenu_params":[]}]}]' ?>
<link href="{{ asset('/plugins/domenu/jquery.domenu-0.100.77.css') }}" rel="stylesheet">
<script src="{{ asset('/plugins/domenu/jquery.domenu-0.100.77.js') }}"></script>
<script>
$(document).ready(function() {
  var $domenu            = $('#domenu-0'),
  domenu             = $('#domenu-0').domenu(),
  $outputContainer   = $('#domenu-0-output'),
  $jsonOutput        = $outputContainer.find('.jsonOutput');
  $domenu.domenu({
    data: '{!! $jsonInputData !!}'
  })
  .onCreateItem(function(blueprint) {
        // We look with jQuery for our custom button we denoted with class "custom-button-example"
        // Note 1: blueprint holds a reference of the element which is about to be added the list
        var customButton = $(blueprint).find('.custom-button-example');

        // Here we define our custom functionality for the button,
        // we will forward the click to .dd3-content span and let
        // doMenu handle the rest
        customButton.click(function() {
          blueprint.find('.dd3-content span').first().click();
        });
      })
  .parseJson()
  .on(['onItemCollapsed', 'onItemExpanded', 'onItemAdded', 'onSaveEditBoxInput', 'onItemDrop', 'onItemDrag', 'onItemRemoved', 'onItemEndEdit'], function(a, b, c) {
        $jsonOutput.val(domenu.toJson());
      })
  
  
});


$(".add_form, .apply_form").on('click', function(){
	var menu_data  = $("#menu_data").val();
	alert(menu_data);
	return false;
	if(menu_data==''){
		alert("Menu Data need to enter");
		return false;
	}
});

    </script>
        
<div class="dd" id="domenu-0">
  <button class="dd-new-item">+</button>
  <li class="dd-item-blueprint">
	<button class="collapse" data-action="collapse" type="button" style="display: none;">–</button>
	<button class="expand" data-action="expand" type="button" style="display: none;">+</button>
	<div class="dd-handle dd3-handle">Drag</div>
	<div class="dd3-content">
	  <span class="item-name">[item_name]</span>
	  <div class="dd-button-container">
		<button class="custom-button-example">&#x270E;</button>
		<button class="item-add">+</button>
		<button class="item-remove" data-confirm-class="item-remove-confirm">&times;</button>
	  </div>
	  <div class="dd-edit-box" style="display: none;">
		<input type="text" name="title" autocomplete="off" placeholder="Item"
			   data-placeholder="Any nice idea for the title?"
			   data-default-value="doMenu List Item. {?numeric.increment}">
		<input type="text" name="url" autocomplete="off" placeholder="Url"
			   data-placeholder="http://example.com/"
			   data-default-value="http://example.com/">
		<i class="end-edit">save</i>
	  </div>
	</div>
  </li>
  <ol class="dd-list"></ol>
</div>

{!! Form::open(['method'=>'POST','id' =>'settings_save', 'url'=>route('settings.store',['option_key'=>$option_key]),'files'=>true]) !!} 
	@include($theme . '.common.includes.submitbutton')
	
	{!! Form::hidden('option_key',$option_key) !!}

	@if(!empty($option_id))
		{!! Form::hidden('id',$option_id) !!}
	@endif

	{!! Form::label('JSON Output Preview (User menu)', 'JSON Output Preview (User menu)', ['class'=>'form-control-label'])!!}
	<div id="domenu-0-output" class="output-preview-container">
		<textarea style="width: 100%; min-height: 300px;" name="top_menu" id="menu_data" class="jsonOutput">{{$jsonInputData}}</textarea>
	</div>
	{!! Form::hidden('option_key','top_menu') !!}
@include($theme . '.common.includes.submitbutton')
{!! Form::close() !!}
