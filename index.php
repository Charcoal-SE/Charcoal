<?php include "base.php"; ?>
<?php 
  $site = $_GET["site"];
  if ($_GET["site"])
  {
    $_SESSION["Site"] = $site;
    $_SESSION["RootURL"] = RootURLForSite($site);
  }
  if (strlen($_SESSION["Filter"])<1)
  {
    $_SESSION["Filter"] = 'all';
  }
  if ($_GET["filter"])
  {
    $_SESSION['Filter'] = $_GET['filter'];
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Charcoal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <script type="text/javascript">var baseURL="<?php echo baseURL();?>"</script>
    <script type="text/javascript">var currentPage="comments"</script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <?php  
  if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']))  
  {  
  	
  if ($_SESSION["ischarcoalmod"]==0){
		die("Sorry, Charcoal is locked down at the moment. Please ask in  <a href='http://chat.stackexchange.com/rooms/11540/charcoal-hq'>Charcoal HQ</a> for details.");
	}
  ?>
  <?php echo NavBar($_SESSION["Site"]); ?>

    <div class="col-md-offset-1 col-md-10">

    <div class="commentcollector-options">
<div class=btn-group>
	<button class="btn btn-default togglebtn  active" id='collecttoggle' id="commentcollector-enable">Collect comment/post IDs for flagging</button>  
	<button class="btn btn-default" id="collecthelp" data-toggle="modal" data-target="#collectmodal">?</button>
</div>	
<div id="collectmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;"><div class="modal-dialog"><div class="modal-content">
		<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
		<h3 id="myModalLabel">Comment collection system</h3>
		</div>
		<div class="modal-body">
		<p>This system lets the user keep track of comments that have been marked as valid, and gives the user easier ways to flag them in batch
		When enabled, any comments you mark as valid will be recorded. Also, if you load the context of a comment, you are given the option to record additional comments from the context.
		</p><p>
		At any point, you can decide to generate JS code for  flagging these comments. This is simply done by clicking the first "generate" button (after selecting the relevant flag type), copy pasting the javascript code that you are presented, and running it in the JS console on the relevant Stack Exchange site
		Be sure to wait for the flags to be sent (There will be regular updates in the console as flags are sent out) as the script is throttled and flags once every 5 seconds. Once done, you can clear the record of comments with the "clear" button</p>
		<p>If you select <i>all</i> comments in the context, the post id will be recorded instead, for custom flagging. The procedure is similar to that of the individual comment flags. </p>
		</div>
  </div></div></div>
<div class="commentcollector-showhide" style="display: block;">
<br><br>
<div class="row">
	<div class="col-md-3">Individual comments <span class="badge" <span class="badge" style="background-color:#5cb85c;" id="badge-comments"></span></div>
	<div class="col-md-4"><div class="input-group">
		<span class="input-group-addon">Flag as</span>
		<select class="form-control" id="flag-dropdown">
			<option value=22 selected>obsolete</option>
			<option value=21>not constructive</option>
			<option value=23>chatty</option>
			<option value=20>rude</option>
		</select>
	</div></div>
	<div class="col-md-2">
		<button class="form-control btn btn-default" id="comments-flag-gen" disabled data-toggle='modal' data-target='#flagmodal'>Generate</button>
	</div>
	<div class="col-md-1">
		<button class="form-control btn btn-default" id="comments-flag-clr" disabled>Clear</button>
	</div>
  <div id="flagmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="flagCodeLabel" aria-hidden="true" style="display: none;"><div class="modal-dialog"><div class="modal-content">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
    <h3 id="myModalLabel">Flag comments</h3>
    </div>
    <div class="modal-body">
    <p>Copy the following code into your browser's JS console on the related site.</p>
    <pre id="flagjscode" style='overflow: auto; word-wrap: normal; white-space: pre;'>test</pre>
    </div>
  </div></div></div>
	</div><br>
<div class="row">
	<div class="col-md-3">Whole posts (custom flag) <span class="badge" style="background-color:#5cb85c;" id="badge-posts"></span></div>
	<div class="col-md-4"><div class="input-group">
		<span class="input-group-addon">Flag as</span>
		<input class="form-control" type="text" placeholder="Flag text here" id="post-flag-text" value="This post has obsolete comments">
	</div></div>
	<div class="col-md-2">
		<button class="form-control btn btn-default" id="posts-flag-gen" disabled data-toggle='modal' data-target='#flagmodal'>Generate</button>
	</div>
	<div class="col-md-1">
		<button class="form-control btn btn-default" id="posts-flag-clr" disabled>Clear</button>
	</div>

</div>
	<br>
	<button type="button" class="btn btn-default btn-xs togglebtn" id="modtoggle">I am a moderator on this site</button>
	<button type="button" class="btn btn-default btn-xs togglebtn" id="flagtoggle">Collect as individual comment flags only</button>  

</div>
<br><br>

</div>
   
      <div class="dropdown">
        <a data-toggle="dropdown" href="#"><h5>filter <span class="caret"></span></h5></a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
          <?php
            echo '<li role="presentation" class="' . (($_SESSION["Filter"] == "all") ? 'active' : '') . '"><a role="menuitem" tabindex="-1" href="' . baseURL() . '/index.php?filter=all">all</a></li>';
            $query = PDODatabaseObject()->prepare("SELECT reason FROM flags WHERE site = ? AND handled=0 GROUP BY reason");
            $query->execute(array($_SESSION["Site"]));
            $reasons = $query->fetchAll();
            foreach($reasons as $row) {
              echo '<li role="presentation" class="' . (($_SESSION["Filter"] == $row["reason"]) ? 'active' : '') . '"><a role="menuitem" tabindex="-1" href="' . baseURL() . '/index.php?filter=' . $row["reason"] . '"">' . $row["reason"] . '</a></li>';
            }
          ?>
        </ul>
      </div>

      <table class="table main-table">
        <?php
          if($_SESSION["Filter"] != "all"){
            $getFlags = PDODatabaseObject()->prepare("SELECT `Text`, `UserID`, `Id`, `PostId`, `CreationDate`, `reason` FROM flags WHERE site=? AND handled=0 AND reason=? ORDER BY LENGTH(`Text`) LIMIT 0,25");
            $getFlags->execute(array($_SESSION["Site"], $_SESSION["Filter"]));
          }
          else{
            $getFlags = PDODatabaseObject()->prepare("SELECT `Text`, `UserID`, `Id`, `PostId`, `CreationDate`, `reason` FROM flags WHERE site=? AND handled=0 ORDER BY LENGTH(`Text`) LIMIT 0,25");
            $getFlags->execute(array($_SESSION["Site"]));
          }
          $flags = $getFlags->fetchAll();
          foreach($flags as $row) {
            echo "<tr class='comment-row' id='" . $row['Id'] . "'><td>";

            echo "<div class='comment'>";
            echo "<a href='http://" . $_SESSION['RootURL'] . "/posts/comments/" . $row["Id"] . "' target='_newtab'><h4 class='comment-text " . $row["Id"] . "'>" . $row["Text"] . " </a><span class='small'> - <strong>user" . $row["UserID"] ."</strong> " . TimeElapsed($row["CreationDate"]) . " <span class='text-danger'>(" . $row["reason"] . ")</span></span></h4>";
            echo "</div>";
            echo "</br>";
            echo "<p class='showcontextlink text-info' href='#' id='" . $row["Id"] . "' postid='" . $row["PostId"] . "'> show context</p></br>";
            echo "<div class='actions " . $row["Id"] . "'>";
            echo "<div class='btn btn-success valid-button' id='" . $row["Id"] . "' data-postid='".$row["PostId"]."'  ><strong>valid</strong></div>";
            echo "<div class='btn btn-danger invalid-button' id='" . $row["Id"] . "' data-postid='".$row["PostId"]."' style='margin-left:10px'><strong>invalid</strong></div>";
            echo "</div>";

            echo "</td></tr>";
          }
          ?>
         <tr class="reload-comments-button">
             <td>
             	 </br>
                 <p class="reload-flags-button text-info" style="text-alignment:center; margin:auto" href='#'>reload flags</p>
             </td>
         </tr>
      </table>
    </div>
<?php
}  
elseif(!empty($_POST['username']) && !empty($_POST['password']))  
{  
    $username = mysql_real_escape_string($_POST['username']);  
    $password = md5(mysql_real_escape_string($_POST['password']));  
        
    $checklogin = PDODatabaseObject()->prepare("SELECT COUNT(*) FROM users WHERE username = ? AND password = ?");
    $checklogin->execute(array($username, $password));
      
    $success = 1;
      
    if($checklogin->fetchColumn() == 1) { 
        $login = PDODatabaseObject()->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $login->execute(array($username, $password));
        $row = $login->fetch();   
        $userID = $row['id'];
          
        $_SESSION['Username'] = $username;  
        $_SESSION['LoggedIn'] = 1;  
        $_SESSION['IsDev'] = $row['isDev'];
        $_SESSION['UserID'] = $userID;
        $_SESSION['Site'] = "stackoverflow";
        $_SESSION["RootURL"] = RootURLForSite($_SESSION["Site"]);
        $_SESSION["ischarcoalmod"] = $row['ischarcoalmod'];
        $_SESSION["isnetworkmod"] = $row['isnetworkmod'];
          
        echo "<h1>Logged in</h1>";  
//         echo "isadmin: " . $isadmin;
        $success = 0;
    }  
    
    if ($success == 1) echo "<script>this.document.location.href = '".baseURL()."/index.php?loginsuccess=1'</script>";
    else echo '<script>this.document.location.reload(true);</script>'; 
}  
else  
{  
  ?>
  <h2 class="col-md-offset-1" style="margin-top:30px;">Charcoal <small class="text-info">alpha</small> <button id="modalShowButton" class="btn btn-default pull-right" data-toggle="modal" data-target="#myModal" style="!important; margin-right:30px;">login</button>
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Log in</h4>
                  </div>
                  <div class="modal-body">
                    <form class="form-signin" action="index.php" method="post">
                      <?php if ($_GET['loginsuccess'] == 1) echo "<div class='alert alert-error' style='max-width:310px; margin:auto; margin-bottom:10px;'><strong>Incorrect username/password</strong></div>"; ?>
                      <input name="username" id="username" type="text" class="input-block-level" placeholder="Username">
                      <input name="password" type="password" id="password" class="input-block-level" placeholder="Password" type="text">
                      <button class="btn btn-medium btn-primary" type="submit" style="width:300">Login</button>
                    </form>
                  </div>
                </div><!-- /.modal-content -->
              </div><!-- /.modal-dialog -->
            </div><!-- /.modal --></h2>
  <p class="col-md-offset-1 text-muted">Efficient obsolete comment flagging for <a href="http://stackexchange.com" target='_newtab'>Stack Exchange</a>.</p>
    <!-- <div class="logindiv" style="margin-top:100px";>  
    
    <div class="container" method="post" action="index.php" name="loginform" style="width:400px">
      <form class="form-signin" action="index.php" method="post">
        <h3 class="form-signin-heading">Login</h2>
        <?php if ($_GET['loginsuccess'] == 1) echo "<div class='alert alert-error' style='max-width:310px; margin:auto; margin-bottom:10px;'><strong>Incorrect username/password</strong></div>"; ?>
        <input name="username" id="username" type="text" class="input-block-level" placeholder="Full Name">
        <input name="password" type="password" id="password" class="input-block-level" placeholder="Password" type="text">
        <button class="btn btn-medium btn-primary" type="submit" style="width:300">Login</button>
      </form>

    </div> /container -->

    <div class="container text-center" style="margin-top:25px;">
      <div class="col-md-4">
        <div class="thumbnail">
          <div class="caption">
            <h2>
              <?php
                $count = PDODatabaseObject()->query("SELECT COUNT(*) FROM flags WHERE handled=1")->fetchColumn(); 
                echo $count;
              ?>
            </h2>
            <p class="text-muted">comments reviewed so far</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="thumbnail">
          <div class="caption">
            <h2>
              <?php
                function calculate_average($arr) {
                    $acount = count($arr); //total numbers in array
                    foreach ($arr as $value) {
                        $total = $total + $value; // total value of array numbers
                    }
                    $average = ($total/$acount); // get average value
                    return $average;
                }

                $totalvalid = PDODatabaseObject()->query("SELECT COUNT(*) AS number FROM flags WHERE handled=1 AND wasValid=1")->fetchColumn();
                $totalhandled = PDODatabaseObject()->query("SELECT COUNT(*) FROM flags WHERE handled=1")->fetchColumn();

                echo (($totalvalid / $totalhandled) * 100) . " %";
              ?>
            </h2>
            <p class="text-muted">accuracy rate</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="thumbnail">
          <div class="caption">
            <h2>thousands</h2>
            <p class="text-muted">of helpful flags generated</p>
          </div>
        </div>
      </div>
    </div>

    <?php
}  
?>  
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    

  </body>
</html>
