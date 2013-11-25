<?php
	include "base.php";
	$timestamp = date("Y:m:d H:i:s");

	mysql_query("UPDATE " . $_SESSION["Site"] . " SET handled=1, handleDate='$timestamp', wasValid=0, wasObsolete=0 WHERE `Id`=" . $_POST['id']);

	echo "success";
?>