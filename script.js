var commentCollector={};
commentCollector.enabled=true;
commentCollector.postIds=[];
commentCollector.commentIds=[];


commentCollector.updateCommentCollector=function(){
	function emptyIfZero(num){
		return ((0==num)?"":num);
	}
	$('#comments-flag-gen,#comments-flag-clr').prop('disabled',0==commentCollector.commentIds.length)
	$('#posts-flag-gen,#posts-flag-clr').prop('disabled',0==commentCollector.postIds.length)
	$('#badge-posts').html(emptyIfZero(commentCollector.postIds.length));
	$('#badge-comments').html(emptyIfZero(commentCollector.commentIds.length));
	if($('#collecttoggle').hasClass('active')){
		$('.commentcollector-showhide').show();
	}else{
		$('.commentcollector-showhide').hide();
	}
}


commentCollector.commentTemplate=function(){
var taskList=[COMMENT_IDS_HERE];
var flagoption=FLAG_METHOD_HERE;
var originallength=taskList.length;
POSTFlag=function (){
if(taskList.length>0){
	console.log("Flagging comment #"+(originallength - taskList.length+1) +" of "+  originallength)
	$.post("/flags/comments/"+taskList.shift()+"/add/"+flagoption,
		{"fkey":StackExchange.options.user.fkey,"otherText":""},
		function(){console.log('(done)');setTimeout(POSTFlag,5100);}
	);
}else{
	console.log("Finished");
}
}
POSTFlag()
}

commentCollector.postTemplate=function(){
var taskList=[POST_IDS_HERE];
var flagoption="FLAG_TEXT_HERE";
var originallength=taskList.length;
POSTFlag=function (){
if(taskList.length>0){
	console.log("Flagging post #"+(originallength - taskList.length+1) +" of "+  originallength)
	$.post("/flags/posts/"+taskList.shift()+"/add/PostOther",
		{"fkey":StackExchange.options.user.fkey,"otherText":flagoption,"fromToolsQueue":"false"},
		function(){console.log('(done)');setTimeout(POSTFlag,5100);}
	);
}else{
	console.log("Finished");
}
}
POSTFlag();
}
commentCollector.postModTemplate=function(){
var taskList=[POST_IDS_HERE];
var flagoption="FLAG_TEXT_HERE";
var originallength=taskList.length;
POSTFlag=function (){
if(taskList.length>0){
	console.log("Purging post #"+(originallength - taskList.length+1) +" of "+  originallength)
	var postid=taskList.shift()
	$.post("/admin/posts/"+postid+"/delete-comments",
		{"fkey":StackExchange.options.user.fkey,"target-post-id":postid,"mod-actions":"delete-comments","duration":1},
		function(){console.log('(done)');setTimeout(POSTFlag,500);}
	);
}else{
	console.log("Finished");
}
}
POSTFlag();
}
//http://physics.stackexchange.com/posts/comments/180178/vote/10
commentCollector.commentModTemplate=function(){
var taskList=[COMMENT_IDS_HERE];
var flagoption=FLAG_METHOD_HERE;
var originallength=taskList.length;
POSTFlag=function (){
if(taskList.length>0){
	console.log("Deleting comment #"+(originallength - taskList.length+1) +" of "+  originallength)
	$.post("/posts/comments/"+taskList.shift()+"/vote/10",
		{"fkey":StackExchange.options.user.fkey,"sendCommentBackInMessage":true},
		function(){console.log('(done)');setTimeout(POSTFlag,200);}
	);
}else{
	console.log("Finished");
}
}
POSTFlag()
}


commentCollector.getFuncBody=function(func,funcmod){
if($('.togglebtn#modtoggle').hasClass("active")){
	func=funcmod;
}
var entire = func.toString(); 
return entire.slice(entire.indexOf("{") + 1, entire.lastIndexOf("}"));

}


$(document).ready(function() {
	$('div .btn-success.valid-button').click(function()
	{
		$(this).html('<strong>working...</strong');

		var commentId = $(this).attr("id");
		var tableRow = "tr#" + commentId.toString();
		// alert(tableRow);
		var argString = "id=" + commentId;

		$.ajax({
			type: "POST",
			url: "submitValid.php",
			data: argString,
			success: function(data)
			{

				// alert(data);

				if (data == "success")
				{
					$(tableRow).fadeOut();	
				}
			},
		});
		if($(this).parents('tr.comment-row').find('.comment-context').length>0){
			var checkboxen=$(this).parents('tr.comment-row').find('.comment-context input[type=checkbox]')
			if(!$('#flagtoggle').hasClass('active')&&checkboxen.length>1&&checkboxen.length==checkboxen.filter(':checked').length){
				commentCollector.postIds.push($(this).data("postid"));
				console.log("Collected post ids: "+commentCollector.postIds)
			}else{
			//	var ret=checkboxen.filter(':checked').map(function(){return $(this).data("commentid")});
				commentCollector.commentIds=commentCollector.commentIds.concat([].slice.call(checkboxen.filter(':checked').map(function(){return $(this).data("commentid")})))
				console.log("Collected comment ids: "+commentCollector.commentIds)
			}
		}else{
			commentCollector.commentIds.push(commentId);	
		}
		commentCollector.updateCommentCollector();
	});
	$('div .btn-success.flaggable-button').click(function()
	{
		$(this).html('<strong>working...</strong');

		var commentId = $(this).attr("id");
		var tableRow = "tr#" + commentId.toString();
		// alert(tableRow);
		var argString = "id=" + commentId;

		$.ajax({
			type: "POST",
			url: "../submitFlaggable.php",
			data: argString,
			success: function(data)
			{

				// alert(data);

				if (data == "success")
				{
					$(tableRow).fadeOut();	
				}
			},
		});
	});
	
	$('div .btn-danger.invalid-button').click(function()
	{
		$(this).html('<strong>working...</strong');

		var commentId = $(this).attr("id");
		var tableRow = "tr#" + commentId.toString();
		// alert(tableRow);
		var argString = "id=" + commentId;
		$.ajax({
			type: "POST",
			url: baseURL+"/submitInvalid.php",
			data: argString,
			success: function(data)
			{
				if (data == "success")
				{
					$(tableRow).fadeOut();	
				}
			},
		});
	});
	$('.switchbutton').click(function()
	{
		$(this).html('<strong>working...</strong');

		var commentId = $(this).attr("id");
		// var tableRow = "tr#" + commentId.toString();
		// alert(tableRow);
		var argString = "id=" + commentId;
		$.ajax({
			type: "POST",
			url: baseURL+"/switchsite.php",
			data: argString,
			success: function(data)
			{
				if (data == "success")
				{
					location.reload();	
				}
			},
		});
	});
	$('.showcontextlink').click(function()
	{
		// alert("Hi!");
		$(this).html('<strong>working...</strong');
		var contextLink = $(this);
		var commentId = $(this).attr("id");
		var postId = $(this).attr("postid");
		var tableRow = $("tr#" + commentId.toString());
		// alert(tableRow);
		var argString = "id=" + postId;
		$.ajax({
			type: "POST",
			url: baseURL+"/context.php",
			data: argString,
			success: function(data)
			{
				console.log(data);
				var obj = eval("(" + data + ")");
				// contextLink.before("<p>Test</p>");
				// contextLink.remove();
				// alert(obj.items[0].owner.display_name);
				// var astring = "";
				// var item;
				// for (item in obj.items)
				// {
				// 	astring = astring + item.owner.display_name;
				// }
				// alert(astring);
				// console.log(obj.items.length);
				var astring = "";
				var table = "<table class='table table-striped comment-context'>";
				if(obj.items.length>0){
					table="<div class='btn-group commentcollector-buttons commentcollector-showhide'><button type='button' class='btn btn-default context-selectall'>All</button><button type='button' class='btn btn-default context-selectnone'>None</button><br><br></div>"
						+table;
				}else{
					table="Comment thread empty";
				}
				for (var i=0; i<obj.items.length; i++)
				{
					astring = astring + obj.items[i].owner.display_name;

					var contextClass = "";var check="";

					if (obj.items[i].comment_id == commentId)
					{
						contextClass = "warning";check="checked";
					}
					
					table = table.concat("<tr class='" + contextClass + "' ><td class='commentcollector-check commentcollector-showhide'><input type=checkbox data-commentid='"+obj.items[i].comment_id+"' "+check+"></td><td data-commentid='"+obj.items[i].comment_id+"'>", obj.items[i].body, "<span class='text-muted'> - <a href='" + obj.items[i].owner.link + "'>", obj.items[i].owner.display_name, "</a></td></tr>"); //"<tr>" + obj.items[i].body + "<span class='text-muted'>" + obj.items[i].owner.display_name + "</tr>";
				}
				table = table + "</table>";
				contextLink.before(table);
				contextLink.remove();
				commentCollector.updateCommentCollector();
			},
		});
	});
	
	//Select all/none buttons for commentcollector
	$('tr.comment-row').on("click",".context-selectnone",function(){
		$(this).parents('tr.comment-row').find('.comment-context input').prop('checked',false)
	})
	$('tr.comment-row').on("click",".context-selectall",function(){
		$(this).parents('tr.comment-row').find('.comment-context input').prop('checked',true)
	})
	$('.togglebtn').on('click',function(){$(this).toggleClass('active');})
	$('.togglebtn#collecttoggle').on('click',function(){$('.commentcollector-showhide').toggle()})
	$('.togglebtn#modtoggle').on('click',function(){$("#post-flag-text,#flag-dropdown").prop('disabled',!$("#post-flag-text").prop('disabled'));})
	$('#posts-flag-clr').on('click',function(){commentCollector.postIds=[];commentCollector.updateCommentCollector();})
	$('#comments-flag-clr').on('click',function(){commentCollector.commentIds=[];commentCollector.updateCommentCollector();})
	
	$('#comments-flag-gen').on('click',function(){
		var txt=commentCollector.getFuncBody(commentCollector.commentTemplate,commentCollector.commentModTemplate);
		txt=txt.replace("COMMENT_IDS_HERE",commentCollector.commentIds + "");
		txt=txt.replace("FLAG_METHOD_HERE",$('#flag-dropdown option:selected').val());
		
		$('#flagjscode').html(txt);
		commentCollector.updateCommentCollector();
	})
	
	$('#posts-flag-gen').on('click',function(){
		var txt=commentCollector.getFuncBody(commentCollector.postTemplate,commentCollector.postModTemplate);
		txt=txt.replace("POST_IDS_HERE",commentCollector.postIds + "");
		txt=txt.replace("FLAG_TEXT_HERE",$('#post-flag-text').val());
		
		$('#flagjscode').html(txt);
		commentCollector.updateCommentCollector();
	})
	$('.reload-flag-button').click(function(){
			alert("Hi!");
		// $(this).html('<strong>working...</strong');
		// var contextLink = $(this);
		// var commentId = $(this).attr("id");
		// var postId = $(this).attr("postid");
		// var tableRow = $("tr#" + commentId.toString());
		// // alert(tableRow);
		// var argString = "id=" + postId;
		// $.ajax({
		// 	type: "POST",
		// 	url: baseURL+"/context.php",
		// 	data: argString,
		// 	success: function(data)
		// 	{
		// 		console.log(data);
		// 		var obj = eval("(" + data + ")");
		// 		// contextLink.before("<p>Test</p>");
		// 		// contextLink.remove();
		// 		// alert(obj.items[0].owner.display_name);
		// 		// var astring = "";
		// 		// var item;
		// 		// for (item in obj.items)
		// 		// {
		// 		// 	astring = astring + item.owner.display_name;
		// 		// }
		// 		// alert(astring);
		// 		// console.log(obj.items.length);
		// 		var astring = "";
		// 		var table = "<table class='table table-striped comment-context'>";
		// 		if(obj.items.length>0){
		// 			table="<div class='btn-group commentcollector-buttons commentcollector-showhide'><button type='button' class='btn btn-default context-selectall'>All</button><button type='button' class='btn btn-default context-selectnone'>None</button><br><br></div>"
		// 				+table;
		// 		}else{
		// 			table="Comment thread empty";
		// 		}
		// 		for (var i=0; i<obj.items.length; i++)
		// 		{
		// 			astring = astring + obj.items[i].owner.display_name;

		// 			var contextClass = "";var check="";

		// 			if (obj.items[i].comment_id == commentId)
		// 			{
		// 				contextClass = "warning";check="checked";
		// 			}
					
		// 			table = table.concat("<tr class='" + contextClass + "' ><td class='commentcollector-check commentcollector-showhide'><input type=checkbox data-commentid='"+obj.items[i].comment_id+"' "+check+"></td><td data-commentid='"+obj.items[i].comment_id+"'>", obj.items[i].body, "<span class='text-muted'> - <a href='" + obj.items[i].owner.link + "'>", obj.items[i].owner.display_name, "</a></td></tr>"); //"<tr>" + obj.items[i].body + "<span class='text-muted'>" + obj.items[i].owner.display_name + "</tr>";
		// 		}
		// 		table = table + "</table>";
		// 		contextLink.before(table);
		// 		contextLink.remove();
		// 		commentCollector.updateCommentCollector();
		// 	},
		// });
	})
});

