$(function(){
	$("#addOne").click(function(){
	//	var index = $(".blogTr").size();
	$("#blogTable").append('<tr class="blogTr"><td><input name="blogTitle[]"></td><td><input name="blogUrl[]" style="width:200px" ></td><td><input name="user[]"></td><td><input name="pass[]"></td><td><input type="button" value="delete" class="btnDel"></td></tr>');
	});
	
	$("#btnGetTag").live("click",function(){
		alert(1);
		var json = ['测试','wordpress','sae'];
		var txt = '<select>';
		for(var i=0;i<json.length;i++){
			txt+='<option value="'+json[i]+'">'+json[i]+'</option>'
		}
		txt+='</select>';
		$(this).parent().html(txt);
	});
	
	$(".btnDel").click(function(){
		$(this).parents("tr").remove();
	});
})