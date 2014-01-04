$('div .btn-success.flaggable-button').click(function()
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
                                //         astring = astring + item.owner.display_name;
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
