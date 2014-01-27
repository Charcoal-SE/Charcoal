<?php
	include "base.php";
	$timestamp = date("Y:m:d H:i:s");

	mysql_query("UPDATE " . (($_POST['isPost']==1) ? 'postflags' : 'flags') . " SET handled=1, handleDate='$timestamp', wasValid=1, wasObsolete=1, handledBy=" . $_SESSION["UserID"] . " WHERE `Id`=" . $_POST['id']. " AND  `site`='" . $_SESSION["Site"] . "'") or die(mysql_error());

	echo "success";
?>
