<?php include "../base.php"; ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Charcoal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <!-- <script type="text/javascript" src="script.js"></script> -->
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
  if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $_SESSION["ischarcoalmod"]==1)  
  {  
  ?>
  <?php echo NavBar($_SESSION["Site"]); ?>
  <p style="text-align:right; margin-top:5px; margin-right:15px; font-size:14px;"><strong><?php echo ($_SESSION['ischarcoalmod']==1) ? $_SESSION["Username"] . ' &diams;' : $_SESSION["Username"]; ?></strong> <!-- | <button class='btn btn-warning switchbutton btn-sm'>switch sites</button> | -->|  <a href="../logout.php">logout</a></p>
    </div>
    <div class="col-md-offset-1 col-md-10">
    
    
      <table class="table main-table">
      <tr class='warning' data-toggle="modal" data-target="#newusermodal"><td><h4 style="text-align:center"><a>Add user</a></h3></td></tr>

      <div id="newusermodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;"><div class="modal-dialog"><div class="modal-content">
          <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&#215;</button>
          <h3 id="myModalLabel">Add user</h3>
          <p class="text-danger"><strong>Note:</strong> This is UI without functionality. It doesn't work yet.</p>
          </div>
          <div class="modal-body">
            <form role="form">
            <div class="form-group">
              <label for="newUserName">Username</label>
              <input type="username" class="form-control" id="newUserName" placeholder="User's SE username">
            </div>
            <div class="form-group">
              <label for="newUserEmail">Email address</label>
              <input type="email" class="form-control" id="newUserEmail" placeholder="User's email address">
            </div>
            <div class="checkbox">
              <label>
                <input type="checkbox"> User is a moderator on one or more SE sites
              </label>
            </div>
            <button type="submit" class="btn btn-danger disabled" style="width:100%">Create user</button>
            <!-- </br></br> -->
            <!-- <p class='text-muted' style="text-align:center">The user will be assigned a random password and sent an email with their login info.</p> -->
          </form>

          </div>
      </div></div></div>

        <?php
          $query = mysql_query("SELECT * FROM users ORDER BY id asc");
          while ($row = mysql_fetch_array($query))
          {
            $totalhandled = 0;
            $sites = mysql_query("SELECT * FROM sites");
            while ($row1 = mysql_fetch_array($sites))
             {
                $aQuery = mysql_query("SELECT COUNT(*) AS number FROM " . $row1["siteTableName"] . " WHERE handled=1 
                 AND handledBy = " . $row["id"] . "");
                 $handled = mysql_fetch_assoc($aQuery);
                 $numhandled = $handled["number"];
                 $totalhandled = $numhandled + $totalhandled;
             }
            echo "<tr class='user-row' id='" . $row['id'] . "'><td>";

            echo "<div class='comment'>";
            echo "<span><h4>a class='username " . $row["Id"] . "' href='/viewuser.php?id=" . $row["Id"] . "'>" . (($row['ischarcoalmod'] == 1) ? $row["username"] . " &diams;" : (($row['isnetworkmod']==1) ? $row["username"] . " &#9826;" : $row['username'])) . " </a><span class='small'> - <strong>user" . $row["id"] ."</strong></span></br><span class='small'><strong> " . $totalhandled . " </strong> flags handled total</span></a></h4>";
            echo "</div>";

            echo "</td></tr>";
          }
          
          ?>
      </table>
    </div>
<?php
}  
else  
{
  echo '<p>Heh, nice try</p>';
}  
?>  
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
    

  </body>
</html>
