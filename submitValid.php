<?php
	include "base.php";

	mysql_query("UPDATE " . $_SESSION["Site"] . " SET handled=1, wasValid=1, wasObsolete=1, handledBy=" . $_SESSION["UserID"] . " WHERE `Id`=" . $_POST['id']);

	echo "success";
?>
