<?php
	include "base.php";

	mysql_query("UPDATE " . $_SESSION["Site"] . " SET handled=1, wasValid=0, wasObsolete=0 WHERE `Id`=" . $_POST['id']);

	echo "success";
?>