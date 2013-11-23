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

				// alert(data);

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

		var commentId = $(this).attr("id");
		var tableRow = "tr#" + commentId.toString();
		// alert(tableRow);
		var argString = "id=" + commentId;
		$.ajax({
			type: "POST",
			url: "/charcoal/context.php",
			data: argString,
			success: function(data)
			{

				// alert(data);

				var obj = jQuery.parseJSON(data);
			},
		});
	});
});