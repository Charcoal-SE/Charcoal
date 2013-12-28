var commentCollector={};
commentCollector.enabled=true;
commentCollector.postIds=[];
commentCollector.commentIds=[];
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
		var checkboxen=$(this).parents('tr.comment-row').find('.comment-context input[type=checkbox]')
		if(checkboxen.length==checkboxen.filter(':checked').length){
			commentCollector.postIds.push('Postid: '+$(this).attr("id"));
			console.log("Collected post ids: "+commentCollector.postIds)
		}else{
			var ret=checkboxen.filter(':checked').map(function(){return $(this).data("commentid")});
			commentCollector.commentIds.concat([].slice.call(ret));
			console.log("Collected comment ids: "+commentCollector.commentIds)
		}
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
			url: "/charcoal/submitInvalid.php",
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
			url: "/charcoal/switchsite.php",
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
			url: "/charcoal/context.php",
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
		
				table="<div class='btn-group commentcollector-buttons commentcollector-showhide'><button type='button' class='btn btn-default context-selectall'>All</button><button type='button' class='btn btn-default context-selectnone'>None</button></div><br>"
					+table;
				for (var i=0; i<obj.items.length; i++)
				{
					astring = astring + obj.items[i].owner.display_name;

					var contextClass = "";

					if (obj.items[i].comment_id == commentId)
					{
						contextClass = "warning";
					}
					
					table = table.concat("<tr class='" + contextClass + "'><td class='commentcollector-check commentcollector-showhide'><input type=checkbox data-commentid='"+obj.items[i].comment_id+"'></td><td data-commentid='"+obj.items[i].comment_id+"'>", obj.items[i].body, "<span class='text-muted'> - <a href='" + obj.items[i].owner.link + "'>", obj.items[i].owner.display_name, "</a></td></tr>"); //"<tr>" + obj.items[i].body + "<span class='text-muted'>" + obj.items[i].owner.display_name + "</tr>";
				}
				table = table + "</table>";
				contextLink.before(table);
				contextLink.remove();
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
});
