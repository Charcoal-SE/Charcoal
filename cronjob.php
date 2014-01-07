<?php
    
    include "config.php";
    include "context.php"; //for the curl method

	$dbhost = MySQLHost();
	$dbname = MySQLDB();
	$dbuser = MySQLUsername();
	$dbpass = MySQLPassword();
  
	mysql_connect($dbhost, $dbuser, $dbpass) or die("MySQL Error: " . mysql_error());  
	mysql_select_db($dbname) or die("MySQL Error: " . mysql_error()); 

	$siteArr = mysql_fetch_assoc(mysql_query("select siteRootURL, siteTableName from sites order by lastCronCheck asc limit 1"));
	$siteAPIKey = $siteArr['siteRootURL'];
	$siteTableName = $siteArr["siteTableName"];

	$query = mysql_query("SELECT `Id` FROM flags WHERE site='" . $siteTableName . "' AND handled=0 ORDER BY LENGTH(`Text`) limit 100");
	$commentsToInspect = array();

	while ($row = mysql_fetch_array($query))
	{
		$commentsToInspect[] = $row["Id"];
	}

	$url = 'https://api.stackexchange.com/2.1/comments/' . implode(";", $commentsToInspect);
	$data = array("site" => $siteAPIKey, "filter" => "!9im-EfY_i", "order" => "asc", 'key' => "mmpZxopkL*psP5WoBK6BuA((");
 
	$response = (new Curl)->exec($url . '?' . http_build_query($data), [CURLOPT_ENCODING => 'gzip']);
 
	$obj1 = json_decode($response);
	// $obj = $obj1['items'];

	print($obj1);

 
  public function getInfo()
  {
    return $this->info;
  }
}
