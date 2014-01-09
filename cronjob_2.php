<?php include "base.php"; ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Charcoal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <!-- <script type="text/javascript" src="script.js"></script> -->
    <script type="text/javascript">var baseURL="<?php echo baseURL();?>"</script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  </div>
    <div class="col-md-offset-1 col-md-10">
    <table class="table main-table">
        <?php
          //magic goes here
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
      $url = 'https://api.stackexchange.com/2.1/comments/' . $result1 . '';
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
          ?>
      </table>
    </div>
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
    

  </body>
</html>
