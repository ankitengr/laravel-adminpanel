<style type="text/css">
.cf:after {
  visibility: hidden;
  display: block;
  font-size: 0;
  content: " ";
  clear: both;
  height: 0;
}

* html .cf { zoom: 1; }

*:first-child+html .cf { zoom: 1; }

html {
  margin: 0;
  padding: 0;
}

body {
  font-size: 100%;
  margin: 0;
  font-family: 'Helvetica Neue', Arial, sans-serif;
}

h1 {
  font-size: 1.75em;
  margin: 0 0 0.6em 0;
}

a { color: #2996cc; }

a:hover { text-decoration: none; }

p { line-height: 1.5em; }

.small {
  color: #666;
  font-size: 0.875em;
}

.large { font-size: 1.25em; }

/**
     * Nestable
     */

.dd {
  position: relative;
  display: block;
  margin: 0;
  padding: 0;
  max-width: 600px;
  list-style: none;
  font-size: 13px;
  line-height: 20px;
}

.dd-edit-box input {
  border: none;
  background: transparent;
  outline: none;
  font-size: 13px;
  color: #444;
  text-shadow: 0 1px 0 #fff;
  width: 45%;
}

.dd-edit-box { position: relative; }

.dd-edit-box i {
  right: 0;
  overflow: hidden;
  cursor: pointer;
  position: absolute;
}

.dd-item-blueprint { display: none; }

.dd-list {
  display: block;
  position: relative;
  margin: 0;
  padding: 0;
  list-style: none;
}

.dd-list .dd-list { padding-left: 30px; }

.dd-collapsed .dd-list { display: none; }

.dd-item,  .dd-empty,  .dd-placeholder {
  text-shadow: 0 1px 0 #fff;
  display: block;
  position: relative;
  margin: 0;
  padding: 0;
  min-height: 20px;
  font-size: 13px;
  line-height: 20px;
}

.dd-handle {
  cursor: move;
  display: block;
  height: 30px;
  margin: 5px 0;
  padding: 5px 10px;
  color: #333;
  text-decoration: none;
  font-weight: bold;
  border: 1px solid #AAA;
  background: #E74C3C;
  background: -webkit-linear-gradient(top, #E74C3C 0%, #C0392B 100%);
  background: -moz-linear-gradient(top, #E74C3C 0%, #C0392B 100%);
  background: linear-gradient(top, #E74C3C 0%, #C0392B 100%);
  -webkit-border-radius: 3px;
  border-radius: 3px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}

.dd-handle:hover {
  color: #2ea8e5;
  background: #fff;
}

.dd-item > button {
  display: inline-block;
  position: relative;
  cursor: pointer;
  float: left;
  width: 24px;
  height: 20px;
  margin: 5px 5px 5px 30px;
  padding: 0;
  white-space: nowrap;
  overflow: hidden;
  border: 0;
  background: transparent;
  font-size: 12px;
  line-height: 1;
  text-align: center;
  font-weight: bold;
  color: f black;
}

.dd-item .item-remove {
  position: absolute;
  right: 7px;
  height: 19px;
  padding: 0 5px;
  top: 6px;
  overflow: auto;
}

.dd3-item > button:first-child { margin-left: 30px; }

.dd-item > button:before {
  display: block;
  position: absolute;
  width: 100%;
  text-align: center;
  text-indent: 0;
}

.dd-placeholder,  .dd-empty {
  margin: 5px 0;
  padding: 0;
  min-height: 30px;
  background: #f2fbff;
  border: 1px dashed #b6bcbf;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}

.dd-empty {
  border: 1px dashed #bbb;
  min-height: 100px;
  background-color: #e5e5e5;
  background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),  -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
  background-image: -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),  -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
  background-image: linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),  linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
  background-size: 60px 60px;
  background-position: 0 0, 30px 30px;
}

.dd-dragel {
  height: 60px;
  position: absolute;
  pointer-events: none;
  z-index: 9999;
}

.dd-dragel > .dd-item .dd-handle { margin-top: 0; }

.dd-dragel .dd-handle {
  -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
  box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
}

/**
     * Nestable Draggable Handles
     */

.dd3-content {
  display: block;
  height: 30px;
  margin: 5px 0;
  padding: 5px 10px 5px 40px;
  color: #333;
  text-decoration: none;
  font-weight: bold;
  border: 1px solid #ccc;
  border: 1px solid #898989;
  background: #fafafa;
  background: -webkit-linear-gradient(top, #F4F4F4 10%, #C9C9C9 100%);
  background: -moz-linear-gradient(top, #F4F4F4 10%, #C9C9C9 100%);
  background: linear-gradient(top, #F4F4F4 10%, #C9C9C9 100%);
  -webkit-border-radius: 3px;
  border-radius: 3px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}

.dd3-content:hover {
  color: #2ea8e5;
  background: #E74C3C;
  background: -webkit-linear-gradient(top, #E5E5E5 10%, #FFFFFF 100%);
  background: -moz-linear-gradient(top, #E5E5E5 10%, #FFFFFF 100%);
  background: linear-gradient(top, #E5E5E5 10%, #FFFFFF 100%);
}

.dd-dragel > .dd3-item > .dd3-content { margin: 0; }

.dd3-handle {
  position: absolute;
  margin: 0;
  left: 0;
  top: 0;
  cursor: move;
  width: 30px;
  text-indent: 100%;
  white-space: nowrap;
  overflow: hidden;
 bold;
  border: 1px solid #807B7B;
  text-shadow: 0 1px 0 #807B7B;
  background: #E74C3C;
  background: -webkit-linear-gradient(top, #E74C3C 0%, #C0392B 100%);
  background: -moz-linear-gradient(top, #E74C3C 0%, #C0392B 100%);
  background: linear-gradient(top, #E74C3C 0%, #C0392B 100%);
  border-top-right-radius: 0;
  border-bottom-right-radius: 0;
}

.dd3-handle:before {
  content: '≡';
  display: block;
  position: absolute;
  left: 0;
  top: 3px;
  width: 100%;
  text-align: center;
  text-indent: 0;
  color: #fff;
  font-size: 20px;
  font-weight: normal;
}

.dd3-handle:hover {
  background: #E74C3C;
  background: -webkit-linear-gradient(top, #E74C3C 0%, #C0392B 100%);
  background: -moz-linear-gradient(top, #E74C3C 0%, #C0392B 100%);
  background: linear-gradient(top, #E74C3C 0%, #C0392B 100%);
}
</style>

<?php 
if(!empty($content_data)){
	$datanew  = $content_data[0]['option_value'] ;
	$result = json_decode($datanew,true);
  $array_values = array_values($result);
  //print_r($array_values);
  $len =  sizeof($array_values);

	//print_r($array_values);

  if($len%3=='0'){
          //echo "true";
          $testnew= array();



          for($i=$len-1;$i>=0;$i--){
            
            
            if($i%3=='0'){
                $testnew['type'] = $array_values[$i];
              }
              else if($i%3=='1'){
              $testnew['title'] = $array_values[$i];
              }else if($i%3=='2'){
                
                $testnew['url'] = $array_values[$i];
              }

              if($i%3=='0'){
              $testodd[] = $testnew;
              


            }

          }





          /*for($i=$len-1;$i>=0;$i--){
            
            if($i%3=='0'){
              $testodd[$array_values[$i]] = $testnew;
              


            }
            if($i%3=='1'){
              $testnew['title'] = $array_values[$i];
              }else if($i%3=='2'){
                
                $testnew['url'] = $array_values[$i];
              }

          }*/

         /* print_r($testodd);
          die;*/

          $resultrev= array_reverse($testodd);

}
	if(!empty($result)){
		$show="";
	}else{
		$show="display:none;";
	}
}else{
	$show="display:none;";
}
?>
{{--
{!! Form::label('Content Type', 'Content Type', ['class'=>'form-control-label'])!!}
{!! Form::text('', '', [
	'class'=>'form-control version_no',
	'placeholder'=>'Content Type', 
	'id' =>'content_type'
	])!!} --}}
<div class="dd" id="domenu">
  <input type="button" id="add" name="Add"  class="dd-new-item" value="Add" > <!-- <button class="dd-new-item">+</button> -->
  <!-- .dd-item-blueprint is a template for all .dd-item's -->
  <li class="dd-item-blueprint">
    <div class="dd-handle dd3-handle"></div>
    <div class="dd3-content"> <span>[item_name]</span>
      <button class="item-remove">&times;</button>
      <div class="dd-edit-box" style="display: none;">
        <input type="hidden" name="parent" class="parentclass">
        <input type="text" name="title" class="titleclass" placeholder="name">
        <input type="url" name="http"  class="httpclass" placeholder="http://">
        <i class="edit">&#x270e;</i> </div>
    </div>
  </li>
  <ol class="dd-list">
<?php
if(!empty($result)){
     //print_r($resultrev);
         // die;
  ///foreach ($resultrev as $key => $value) {
    for($i='0';$i<sizeof($resultrev);$i++){

    $res  =  explode('_', $resultrev[$i]['type']);

    if($res[0]=='parent'){
    ?><li class='dd-item'>
    <div class='dd-handle dd3-handle'></div>
    <div class='dd3-content'> <span><?php echo $resultrev[$i]['title']?></span>
      <button class='item-remove'>&times;</button>
      <div class='dd-edit-box' style='display: none;'>
        <input type='hidden' name='parent' class='parentclass'>
        <input type='text' name='title' class='titleclass' placeholder='name' value='<?php echo $resultrev[$i]['title'];?>'>
        <input type='url' name='http'  class='httpclass' placeholder='http://' value='<?php echo $resultrev[$i]['url'];?>'>
        <i class='edit'>&#x270e;</i> </div>
    </div>
    <?php
   // print_r($resultrev);
   // die;
      //foreach ($resultrev as $key1 => $value1) {

      for($j=$i+1;$j<sizeof($resultrev);$j++){
        $res1  =  explode('_', $resultrev[$j]['type']);
          //echo $resultrev[$j]['type'];
          //die;
        if($res1[0]=='child'){
          ?>
          <ol class="dd-list">
        <li class='dd-item'>
        <div class='dd-handle dd3-handle'></div>
        <div class='dd3-content'> <span><?php echo $resultrev[$j]['title'];?></span>
          <button class='item-remove'>&times;</button>
          <div class='dd-edit-box' style='display: none;'>
            <input type='hidden' name='parent' class='parentclass'>
            <input type='text' name='title' class='titleclass' placeholder='name' value='<?php echo $resultrev[$j]['title'];?>'>
            <input type='url' name='http'  class='httpclass' placeholder='http://' value='<?php echo $resultrev[$j]['url'];?>'>
            <i class='edit'>&#x270e;</i> </div>
            </div>
          </li>
        </ol>
          <?php
          }else{
            break;
          }
        }
        ?>

  </li>
  <?php
  }
}
 }
?>

  </ol>
</div>




<script type="text/javascript">

	$(".add_form").on('click', function(){
		changename();
	});
	function changename(){
		var num =  $('.titleclass').length;
		//var rowcountAfterDelete = $('td.index').length; 
		var actual =  num-1; 
		var order =  $(".titleclass");
		var http  = $(".httpclass");

		for(var i=1;i<=actual;i++){   
			var row = order[i];
			$(row).attr('name', 'title_'+i);
			var https = http[i];
			$(https).attr('name', 'http_'+i);

         }
         $('li ol.dd-list .dd-item .dd3-content .dd-edit-box .parentclass').attr('class', 'child');
        var parentcount = $(".parentclass").length;
        //var order =  $(".titleclass");
        var parentid  = $(".parentclass");

        for(var i=1;i<=parentcount;i++){   
        var row = parentid[i];
        $(row).attr('name', 'parent_'+i);
        $(row).attr('value', 'parent_'+i);
        }


        var childcount = $(".child").length;
        //var order =  $(".titleclass");
        var childid  = $(".child");

        for(var i=0;i<childcount;i++){   
        var row = childid[i];
        $(row).attr('name', 'child_'+i);
        $(row).attr('value', 'child_'+i);
        }
        $( "input[name='parent'], input[name='http'], input[name='title']" ).attr('disabled', true);
	}

</script>
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="{{ asset('adminhubspot/dist/js/jquery.domenu-0.0.1.js?v=1.4') }}"></script>

<!-- <script src="jquery.domenu-0.0.1.js"></script>  -->
<script>

    $(document).ready(function()
    {

        var updateOutput = function(e)
        {
            var list   = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
            changename();
        };

        $('#domenu').domenu({
            data: ''
        }).parseJson();
        


    });
    </script>
