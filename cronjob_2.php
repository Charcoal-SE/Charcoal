<?php
  //magic goes here
  include "base.php";
  echo "<span class='small'>Started cronjob</span>";
  $sites = mysql_query("SELECT * FROM sites");
  while ($site = mysql_fetch_array($sites))
  {
    //$query = mysql_query("SELECT Count(*) AS number, FROM flags WHERE handled=0 AND site='" . $site["siteTableName"] . "' ORDER BY LENGTH(`Text`)");
    //$row = mysql_fetch_assoc($query);
    //$number = $row["number"];
    //print_r($number);
    //$done = 0;
    //while ($number - $done > 0)
    //{
      $result = array();
     //$done = 100 + $done;
      $getflags = mysql_query("SELECT `Id` FROM flags WHERE handled=0 AND site='" . $site["siteTableName"] . "' ORDER BY LENGTH(`Text`) Limit 100");
      echo "<span class='small'>MySQL part</span>";
      while ($flagid = mysql_fetch_assoc($getflags){
        array_push($result, $flagid["Id"]);
      }
      $result1 = implode(";",$result);
      $url = 'https://api.stackexchange.com/2.1/posts/' . $result1 . '/comments';
      $data = array("site" => $site["siteTableName"], "filter" => "!SrhZo6aE2O(w*j4-4i", "order" => "asc", key => "mmpZxopkL*psP5WoBK6BuA((");
      $response = (new Curl)->exec($url . '?' . http_build_query($data), [CURLOPT_ENCODING => 'gzip']);
 
      $obj1 = json_decode($response, true);
      print_r($obj1);
      //$items = $obj1->{'items'};
      $comments = array_filter($obj1['items'], function ($a) {
        return in_array($a['comment_id']);
      });
      print_r($comments);
      $deleted = array_diff($result, $comments);
      foreach ($deleted as $valid){
        $timestamp = date("Y:m:d H:i:s");
        mysql_query("UPDATE flags SET handled=1, handleDate='$timestamp', wasValid=1, wasObsolete=1, handledBy= 0 WHERE `Id`=" . $valid. " AND  `site`='" . $site["siteTableName"] . "'");
      }
  //}
  }
