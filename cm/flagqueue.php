<?php include "../base.php"; ?>
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
        <?php
          $query = mysql_query("SELECT `Text`, `UserID`, `Id`, `PostId`, `CreationDate`, `reason` FROM " . $_SESSION["Site"] . " WHERE handled=0 ORDER BY LENGTH(`Text`) LIMIT 0,25");
          if ($_SESSION["IsDev"] == 1)
          {
            $query = mysql_query("SELECT `Text`, `UserID`, `Id`, `PostId`, `CreationDate`, `reason` FROM " . $_SESSION["Site"] . " WHERE handled=0 AND reason='please-accept' AND UserId=2554605 ORDER BY LENGTH(`Text`) LIMIT 0,25");
          }
          while ($row = mysql_fetch_array($query))
          {
            echo "<tr class='comment-row' id='" . $row['Id'] . "'><td>";

            echo "<div class='comment'>";
            echo "<a href='http://" . $_SESSION['RootURL'] . "/posts/comments/" . $row["Id"] . "' target='_newtab'><h4 class='comment-text " . $row["Id"] . "'>" . $row["Text"] . " </a><span class='small'> - <strong>user" . $row["UserID"] ."</strong> " . TimeElapsed($row["CreationDate"]) . " <span class='text-danger'>(" . $row["reason"] . ")</span></span></h4>";
            echo "</div>";
            echo "</br>";
            echo "<p class='showcontextlink text-info' href='#' id='" . $row["Id"] . "' postid='" . $row["PostId"] . "'> show context</p></br>";
            echo "<div class='actions " . $row["Id"] . "'>";
            echo "<div class='btn btn-success flaggable-button' id='" . $row["Id"] . "' data-postid='".$row["PostId"]."'  ><strong>Flaggable</strong></div>";
            echo "<div class='btn btn-danger invalid-button' id='" . $row["Id"] . "' data-postid='".$row["PostId"]."' style='margin-left:10px'><strong>invalid</strong></div>";
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
