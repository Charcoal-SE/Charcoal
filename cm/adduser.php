<?php
include '../base.php';
  if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $_SESSION["ischarcoalmod"]==1)  
  {
  	$username = $_REQUEST["username"];
  	$password = $_REQUEST["password"];
  	$email = $_REQUEST["email"];
  	$isnetworkmod = $_REQUEST['isnetworkmod'];

  	$db = new PDO('mysql:host=' . MySQLHost() . ';dbname=' . MySQLDB() . ';charset=utf8', MySQLUsername(), MySQLPassword());

	$stmt = $db->prepare("INSERT INTO users(`username`,`password`,`email`,`isnetworkmod`,`isDev`) VALUES(:username,:password,:email,:isnetworkmod,0)");
	$stmt->execute(array(':username' => $username, ':password' => md5($password), ':email' => $email, ':isnetworkmod' => $isnetworkmod));
	$affected_rows = $stmt->rowCount();

	echo $affected_rows.' were affected';
  }
  else
  {
    echo 'You\'re not logged in!';
  }
