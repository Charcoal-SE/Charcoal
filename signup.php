<?php include "base.php"; ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Phys.SE Obsolete Comments</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript" src="homescript.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <h2 class="col-md-offset-1" style="margin-top:30px;">Charcoal <small class="text-info">alpha</small></h2>
  <p class="col-md-offset-1 text-muted">Efficient obsolete comment flagging for <a href="http://stackexchange.com" target='_newtab'>Stack Exchange</a>.</p>
  <form class="form-signin" action="signupsubmit.php" method="post" style="margin:auto; max-width:800px">
    <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
  </div>
  <div class="form-group">
    <label for="exampleInputUsername">Username</label>
    <input type="text" class="form-control" id="exampleInputUsername" placeholder="Your SE username">
  </div>
  <div class="form-group">
    <label for="exampleInputAccount">SE Account</label>
    <input type="text" class="form-control" id="exampleInputAccount" placeholder="Link to your account on an SE site">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Password</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
    <input type="password" class="form-control" id="exampleInputPasswordConfirm" placeholder="Confirm" style="margin-top:5px;">
  </div>
  <button type="submit" class="btn btn-success">Sign up!</button>
  </form>


      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
