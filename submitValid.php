<?php
	include "base.php";
	$timestamp = date("Y:m:d H:i:s");

	if($_POST['isPost'] == 1) {
		$valid = PDODatabaseObject()->prepare("UPDATE postflags SET handled=1, handleDate=?, wasValid=1, wasObsolete=1, handledBy=? WHERE `Id`=? AND  `site`=?");
		$valid->execute(array($timestamp, $_SESSION["UserID"], $_POST["id"], $_SESSION["Site"]));
	}
	else {
		$valid = PDODatabaseObject()->prepare("UPDATE flags SET handled=1, handleDate=?, wasValid=1, wasObsolete=1, handledBy=? WHERE `Id`=? AND  `site`=?");
		$valid->execute(array($timestamp, $_SESSION["UserID"], $_POST["id"], $_SESSION["Site"]));
	}

	echo "success";
?>
