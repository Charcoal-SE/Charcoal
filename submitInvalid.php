<?php
	include "base.php";
	$timestamp = date("Y:m:d H:i:s");
    
    if($_POST['isPost'] == 1) {
    	$invalid = PDODatabaseObject()->prepare("UPDATE postflags SET handled=1, handleDate=?, wasValid=0, wasObsolete=0, handledBy=? WHERE `Id`=? AND  `site`=?");
    	$invalid->execute(array($timestamp, $_SESSION["UserID"], $_POST["id"], $_SESSION["Site"]));
    }
    else {
    	$invalid = PDODatabaseObject()->prepare("UPDATE flags SET handled=1, handleDate=?, wasValid=0, wasObsolete=0, handledBy=? WHERE `Id`=? AND  `site`=?");
    	$invalid->execute(array($timestamp, $_SESSION["UserID"], $_POST["id"], $_SESSION["Site"]));
    }

	echo "success";
?>
