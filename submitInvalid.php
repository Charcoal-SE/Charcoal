<?php
	include "base.php";
	$timestamp = date("Y:m:d H:i:s");

	mysql_query("UPDATE flags SET handled=1, handleDate='$timestamp', wasValid=0, wasObsolete=0, handledBy=" . $_SESSION["UserID"] . " WHERE `Id`=" . $_POST['id']. " AND  `SITE`=" . $_SESSION["Site"] . "");

	echo "success";
?>
