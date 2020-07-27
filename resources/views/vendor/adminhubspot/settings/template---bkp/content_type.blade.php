<?php 
if(!empty($content_data)){
	$datanew  = $content_data[0]['option_value'] ;
	$result = json_decode($datanew,true);
	//print_r($result);
	if(!empty($result)){
		$show="";
	}else{
		$show="display:none;";
	}
}else{
	$show="display:none;";
}
?>

{!! Form::label('Content Type', 'Content Type', ['class'=>'form-control-label'])!!}
{!! Form::text('', '', [
	'class'=>'form-control version_no',
	'placeholder'=>'Content Type', 
	'id' =>'content_type'
	])!!}

<input type="button" id="add" name="Add"  value="Add" style="<?php echo $show;?>">
<div class="tableappen" style="<?php echo $show;?>"><table class='table table-striped t-wrapper' cellpadding='3' cellspacing='0' width='100%'> <tr><th>Content name</th>  <th>Action</th> </tr><tbody id="contentlist">
<?php 
if(!empty($result)){

foreach ($result as $key => $value) {


	echo '<tr><td class="nameid">'. $key . '<input type="hidden" class="valinp" name="'.$key.'" value="'.$value.'"></td><td><a href="javascript:void(0);" title="remove"  class="remove">X</a></td></tr>';
}

      	echo "<script>$('.remove').on('click', function(){   $(this).parents('tr').remove(); var num =  $('.valinp').length;  if(num=='0'){	$('.tableappen').hide();  }renamehidden(); });</script>";
} 

?>

</tbody></script></table></div>


<script type="text/javascript">
	/*var oldval  =  $("#addfield").val();
	if(oldval!=''){
		var res = oldval.split("-");
		var len =  res.length;
		//console.log(len);
		var news='';
		for(var i=0;i<len;i++){
			var markup = "<tr><td class='nameid'>" + res[i] + "<input type='hidden' class='valinp' name='val_"+res[i]+"' value='"+res[i]+"'></td><td><a href='javascript:void(0);' title='remove'  class='remove'>X</a></td></tr>";
			var news = news+markup;
		}
		//console.log(news);
		var script =  "<script>$('.remove').on('click', function(){   $(this).parents('tr').remove(); var num =  $('.valinp').length;  if(num=='0'){	$('.tableappen').hide();  }renamehidden(); });<\/script>";
			$("#add").show();
			$('.tableappen').show();
            $("#contentlist").append(news);
            $("#contentlist").append(script);
	}*/

	$("#content_type").on('click', function(){
		//console.log("enter");
		$("#add").show();
	});
$("#add").on('click', function(){
	$("#content_data").val();
	var name  = $('#content_type').val();

	if(name!=''){
		var res = checkrepeat();
		//console.log(res);
		if(res!='1'){
		$('.tableappen').show();

      	var markup = "<tr><td class='nameid'>" + name + "<input type='hidden' class='valinp' name='"+name.toLowerCase()+"' value='"+name.toLowerCase()+"'></td><td><a href='javascript:void(0);' title='remove'  class='remove'>X</a></td></tr>";
      	var script =  "<script>$('.remove').on('click', function(){   $(this).parents('tr').remove(); var num =  $('.valinp').length;  if(num=='0'){	$('.tableappen').hide();  }renamehidden(); });<\/script>";
            $("#contentlist").append(markup);
            $("#contentlist").append(script);
            renamehidden();
        }else{
        	alert("Name list already exist");
        }


  }else{
  		alert("please enter something to add");
  }

});

function renamehidden(){
		var num =  $('.valinp').length;

		var sum='';
		var inputs = $(".valinp"); for(var i = 0; i < inputs.length; i++){
		var newval = $(inputs[i]).val(); sum = sum  + newval+"-";

		}

		$("#addfield").val(sum);
	}
function checkrepeat(){
	var num =  $('.valinp').length;
	var newname  = $('#content_type').val();
	var inputs = $(".valinp");
	for(var i = 0; i < inputs.length; i++){
		var oldval = $(inputs[i]).val();
		if(newname==oldval){
			//console.log("coppied");
			return '1';
			//return false;
		}else{
			//console.log("uncopied");
		}
	}

}


</script>