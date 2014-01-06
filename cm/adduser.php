<?php
include '../base.php';
  if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $_SESSION["ischarcoalmod"]==1)  
  {
  	$username = $_REQUEST["username"];
  	$email = $_REQUEST["email"];
  	$isnetworkmod = $_REQUEST["isnetworkmod"];

  	$password = get_random_string("",10);

  	require_once('ses.php');
	  $ses = new SimpleEmailService(SESKey(), SESSecret());
	  $m = new SimpleEmailServiceMessage();
	  $m->addTo($email);
	  $m->setFrom('charcoal@erwaysoftware.com');
	  $m->setSubject('Account created for you on Charcoal');
	  $m->setMessageFromString("You should now be able to login to http://erwaysoftware.com/charcoal with your SE username '" . $username . "' and the password '" . $password . "' Have fun!");
	  $ses->sendEmail($m);

  	$db = new PDO('mysql:host=' . MySQLHost() . ';dbname=' . MySQLDB() . ';charset=utf8', MySQLUsername(), MySQLPassword());

	$stmt = $db->prepare("INSERT INTO users(`username`,`password`,`email`,`isnetworkmod`) VALUES(:username,:password,:email,:isnetworkmod)");
	$stmt->execute(array(':username' => $username, ':password' => md5($password), ':email' => $email, ':isnetworkmod' => (($isnetworkmod=='on') ? '1' : '0')));
	$affected_rows = $stmt->rowCount();

	echo 'User added.';
  }
  else
  {
    echo 'You\'re not logged in!';
  }

  function get_random_string($valid_chars, $length)
	{
		$valid_chars = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ";

	    // start with an empty random string
    	$random_string = "";

	    // count the number of chars in the valid chars string so we know how many choices we have
    	$num_valid_chars = strlen($valid_chars);

	    // repeat the steps until we've created a string of the right length
    	for ($i = 0; $i < $length; $i++)
	    {
        	// pick a random number from 1 up to the number of valid chars
    	    $random_pick = mt_rand(1, $num_valid_chars);

	        // take the random character out of the string of valid chars
        	// subtract 1 from $random_pick because strings are indexed starting at 0, and we started picking at 1
    	    $random_char = $valid_chars[$random_pick-1];

	        // add the randomly-chosen char onto the end of our string so far
        	$random_string .= $random_char;
    	}

	    // return our finished random string
    	return $random_string;
	}
