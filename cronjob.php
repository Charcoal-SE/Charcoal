<?php
    include "base.php"; //for the curl method
	echo 'started';
	$siteArr = mysql_fetch_assoc(mysql_query("select siteRootURL, siteTableName from sites order by lastCronCheck asc limit 1"));
	$siteAPIKey = $siteArr['siteRootURL'];
	$siteTableName = $siteArr["siteTableName"];
	echo $siteTableName;

	$query = mysql_query("SELECT `Id` FROM flags WHERE site='" . $siteTableName . "' AND handled=0 AND (MONTH(CURRENT_TIMESTAMP())!=MONTH(lastCronCheck)) OR lastCronCheck IS NULL ORDER BY LENGTH(`Text`) limit 100");
	//$query = mysql_query("SELECT `Id` FROM flags WHERE site=stackoverflow AND handled=0 ORDER BY LENGTH(`Text`) limit 100");
	$commentsToInspect = array();
	echo "SELECT `Id` FROM flags WHERE site='" . $siteTableName . "' AND handled=0 AND (MONTH(CURRENT_TIMESTAMP())!=MONTH(lastCronCheck)) OR lastCronCheck IS NULL ORDER BY LENGTH(`Text`) limit 100";

	while ($row = mysql_fetch_array($query))
	{
		$commentsToInspect[] = $row["Id"];
	}
	
	print_r(count($commentsToInspect));
	
	$url = 'https://api.stackexchange.com/2.1/comments/' . implode(";", $commentsToInspect);
	$data = array("site" => $siteAPIKey, "filter" => "!9im-EfY_i", "order" => "asc", 'key' => "mmpZxopkL*psP5WoBK6BuA((");
 
	$response = (new Curl)->exec($url . '?' . http_build_query($data), [CURLOPT_ENCODING => 'gzip']);
 	
 	echo 'got response';
 	
	$obj1 = json_decode($response);
	$items = $obj1->{'items'};
	$there = array();
	
	echo 'starting array_push';
	foreach ($items as $commentthere) {
	        array_push($there, $commentthere->{'comment_id'});
	}
	echo 'ended array_push';
        
        print_r($there);
        
        echo 'started unsetting';
	foreach ($items as $comment) {
                unset($commentsToInspect[array_search($comment->{'comment_id'}, $commentsToInspect)]);
	}
	echo 'ended unsetting';
	
	echo 'started lastCronCheck setting';
	foreach ($there as $stillthere){
                 $time = date("Y:m:d H:i:s");
                 mysql_query("UPDATE flags SET lastCronCheck='$time' WHERE `Id`=" . $stillthere. " AND  `site`='" . $siteTableName  . "'")  or die(mysql_error());
        }
	echo 'ended lastCronCheck setting';
	
	print_r(count($commentsToInspect));
	
	foreach ($commentsToInspect as $valid){
              $timestamp = date("Y:m:d H:i:s");
              
              print_r($valid);
              print_r("UPDATE flags SET handled=1, handleDate='" . $timestamp . "', lastCronCheck='" . $timestamp . "', wasValid=1, wasObsolete=1, handledBy=0 WHERE `Id`=" . $valid. " AND `site`='" . $siteTableName  . "'");
              
              mysql_query("UPDATE flags SET handled=1, handleDate='" . $timestamp . "', lastCronCheck='" . $timestamp . "', wasValid=1, wasObsolete=1, handledBy=0 WHERE `Id`=" . $valid. " AND `site`='" . $siteTableName  . "'") or die(mysql_error());
        }
