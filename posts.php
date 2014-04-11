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
    <script type="text/javascript">var currentPage="posts"</script>
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
          $query = PDODatabaseObject()->prepare("SELECT `Score`, `Body`, `OwnerUserId`, `Id`, `CreationDate`, `reason`, `Title` FROM postflags WHERE site=? AND handled=0 ORDER BY LENGTH(`Body`) LIMIT 0,25");
          $query->execute(array($_SESSION["Site"]));
          $posts = $query->fetchAll();
          foreach($posts as $row) {
            echo "<tr class='post-row' id='" . $row['Id'] . "' style='border-bottom:none'><td>";
            echo "<h4><a href='http://" . $_SESSION['RootURL'] . "/a/" . $row['Id'] . "'>" . $row['Title'] . "</a></h4><hr>";
            echo "<div class='post'>";
            echo "<div class='postscore col-md-1'><h2 class='text-muted'>" . $row["Score"] . "</h2></div>";
            echo "<div class='postbody col-md-4'><div class='text-muted lead'><p>" . $row["Body"] . "</p></div>";
            echo "<p><span style='background-color:#f6f6d6'>" . $row["reason"] . "</span></p></div>";
            echo "</div>";
            echo "<div class='actions col-md-offset-5 ". $row['Id'] . "' style='border-top:none'>";
            echo "<span class='text-muted'>" . TimeElapsed($row['CreationDate']) . "</span>";
            echo "<br>";
            echo "<a href='http://" . $_SESSION['RootURL'] . "/users/" . $row['OwnerUserId'] . "/'><img style='border:1px solid lightgrey' src='http://" . $_SESSION['RootURL'] . "/users/flair/" . $row['OwnerUserId'] . ".png?theme=clean' width='208' height='58'></a>";
            echo "<br><br>";
            echo "<div class='btn btn-success valid-button' id='" . $row["Id"] . "' data-postid='".$row["Id"]."'  ><strong>valid</strong></div>";
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
else {
  header("Location: "  . baseURL() . "/index.php"); 
}  
?> 
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
