<?php include "base.php"; ?>
<?php 
  $site = $_GET["site"];
  if ($_GET["site"])
  {
    $_SESSION["Site"] = $site;
    $_SESSION["RootURL"] = RootURLForSite($site);
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Charcoal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
    <script type="text/javascript">var baseURL="<?php echo baseURL();?>"</script>
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
  ?>
  <?php echo NavBar($_SESSION["Site"]); ?>
  <div class="col-md-offset-1 col-md-10">
  <h2>Posts</h2>
    
      <table class="table main-table">
        <?php
          $query = mysql_query("SELECT `Score`, `Body`, `OwnerUserId`, `Id`, `CreationDate`, `reason`, `Title` FROM postflags WHERE site='" . $_SESSION["Site"] . "' AND handled=0 ORDER BY LENGTH(`Body`) LIMIT 0,25");
          while ($row = mysql_fetch_array($query))
          {
            echo "<tr class='post-row' id='" . $row['Id'] . "' style='border-bottom:none'><td>";

            echo "<div class='post'>";
            echo "<h4><a href='" . baseURL() . "/a/" . $row['Id'] . ">" . $row['Title'] . "</a></h4>";
            echo "<div class='postscore col-md-1'><h2 class='text-muted'>" . $row["Score"] . "</h2></div>";
            echo "<div class='postbody col-md-4'><div class='text-muted lead'><p>" . $row["Body"] . "</p></div>";
            echo "<p><span style='background-color:#f6f6d6'>" . $row["reason"] . "</span></p></div>";
            echo "</div>";
            echo "<div class='actions ". $row['Id'] . "' style='border-top:none'>";
            echo "<div class='btn btn-success valid-button col-md-offset-1' id='" . $row["Id"] . "' data-postid='".$row["Id"]."'  ><strong>valid</strong></div>";
            echo "<div class='btn btn-danger invalid-button' id='" . $row["Id"] . "' data-postid='".$row["Id"]."' style='margin-left:10px'><strong>invalid</strong></div>";
            echo "</div>";
            echo "</td></tr>";
            
          }
          
          ?>
         <tr class="reload-comments-button">
             <td>
                      </br>
                 <p class="text-info reload-flags-button" style="text-alignment:center; margin:auto">reload flags</p>
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
      
    $checklogin = mysql_query("SELECT * FROM users WHERE username = '".$username."' AND password = '".$password."'");  
      
    $success = 1;
      
    if(mysql_num_rows($checklogin) == 1)  
    {  
        $row = mysql_fetch_array($checklogin);   
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
                $count = 0;
                $aQuery = mysql_query("SELECT * FROM flags WHERE handled=1");
                $count = mysql_num_rows($aQuery);
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

                  $count = array();
                  $aQuery = mysql_query("SELECT COUNT(*) AS number FROM flags WHERE handled=1 AND wasValid=1");
                  $bQuery = mysql_query("SELECT COUNT(*) AS number FROM flags WHERE handled=1");
                  // $count = $count + mysql_num_rows($aQuery);
                  $valid = mysql_fetch_assoc($aQuery);
                  $handled = mysql_fetch_assoc($bQuery);
                  $totalvalid = $valid["number"];
                  $totalhandled = $handled["number"];

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
            <h2>hundreds</h2>
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
    <script src="js/bootstrap.min.js"></script>
    

  </body>
</html>
