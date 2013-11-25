$(document).ready(function() {
	$('div .btn-success').click(function()
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
	});
	$('div .btn-danger').click(function()
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
				var table = "<table class='table table-striped'>";
				for (var i=0; i<obj.items.length; i++)
				{
					astring = astring + obj.items[i].owner.display_name;

					var contextClass = "";

					if (obj.items[i].comment_id == commentId)
					{
						contextClass = "warning";
					}

					table = table.concat("<tr class='" + contextClass + "''><td>", obj.items[i].body, "<span class='text-muted'> - <a href='" + obj.items[i].owner.link + "'>", obj.items[i].owner.display_name, "</a></td></tr>"); //"<tr>" + obj.items[i].body + "<span class='text-muted'>" + obj.items[i].owner.display_name + "</tr>";
				}
				table = table + "</table>";
				contextLink.before(table);
				contextLink.remove();
			},
		});
	});
});