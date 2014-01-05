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
      <?php
        $userid = $_REQUEST['id'];
        $query = mysql_query("select * from users where id=" . $userid);
        $user = mysql_fetch_array($query);
        echo '<h2>' . $user["username"] . '</h2>';
      ?>
    </div>
<?php
}  
else echo '<p>You\'re not logged in!';
?>  
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    

  </body>
</html>
