<?php
    include "base.php"; //for the curl method

	$siteArr = mysql_fetch_assoc(mysql_query("select siteRootURL, siteTableName from sites order by lastCronCheck asc limit 1"));
	$siteAPIKey = $siteArr['siteRootURL'];
	$siteTableName = $siteArr["siteTableName"];

	//$query = mysql_query("SELECT `Id` FROM flags WHERE site='" . $siteTableName . "' AND handled=0 ORDER BY LENGTH(`Text`) limit 100");
	$query = mysql_query("SELECT `Id` FROM flags WHERE site=stackoverflow AND handled=0 ORDER BY LENGTH(`Text`) limit 100");
	$commentsToInspect = array();

	while ($row = mysql_fetch_array($query))
	{
		$commentsToInspect[] = $row["Id"];
		print_r($row);
	}
	
	print_r(count($commentsToInspect));
	$url = 'https://api.stackexchange.com/2.1/comments/' . implode(";", $commentsToInspect);
	$data = array("site" => $siteAPIKey, "filter" => "!9im-EfY_i", "order" => "asc", 'key' => "mmpZxopkL*psP5WoBK6BuA((");
 
	$response = (new Curl)->exec($url . '?' . http_build_query($data), [CURLOPT_ENCODING => 'gzip']);
 
	$obj1 = json_decode($response);
	$items = $obj1->{'items'};

	foreach ($items as $comment) {
		unset($commentsToInspect[array_search($comment->{'comment_id'}, $commentsToInspect)]);
	}

	print_r(count($commentsToInspect));

