<?php
	include "base.php";

	$site = $_GET["site"];

	$_SESSION["Site"] = $site;
	
	echo "success";
	echo "<script>parent.window.location.reload();</script>";
