<?php
    include "base.php"; //for the curl method
    
    echo "started \n";
    $siteArr = PDODatabaseObject()->query("SELECT siteRootURL, siteTableName FROM sites ORDER BY lastCronCheck ASC LIMIT 1")->fetch();
    $siteAPIKey = $siteArr['siteRootURL'];
    $siteTableName = $siteArr["siteTableName"];
    echo $siteTableName . "\n";

    $query = PDODatabaseObject()->prepare("SELECT `Id` FROM flags WHERE site=? AND handled=0 AND (MONTH(CURRENT_TIMESTAMP())!=MONTH(lastCronCheck)) OR lastCronCheck IS NULL ORDER BY LENGTH(`Text`) LIMIT 100");
    $query->execute(array($siteTableName));
    //$query = mysql_query("SELECT `Id` FROM flags WHERE site=stackoverflow AND handled=0 ORDER BY LENGTH(`Text`) limit 100");
    $commentsToInspect = array();
    echo "SELECT `Id` FROM flags WHERE site='" . $siteTableName . "' AND handled=0 AND (MONTH(CURRENT_TIMESTAMP())!=MONTH(lastCronCheck)) OR lastCronCheck IS NULL ORDER BY LENGTH(`Text`) limit 100 \n";

    foreach ($query->fetchAll() as $row) {
        $commentsToInspect[] = $row["Id"];
    }
    
    print_r(count($commentsToInspect));
    
    $url = 'https://api.stackexchange.com/2.1/comments/' . implode(";", $commentsToInspect);
    $data = array("site" => $siteAPIKey, "filter" => "!9im-EfY_i", "order" => "asc", 'key' => "mmpZxopkL*psP5WoBK6BuA((");
 
    $response = (new Curl)->exec($url . '?' . http_build_query($data), [CURLOPT_ENCODING => 'gzip']);
    
    echo "got response \n";
    
    $obj1 = json_decode($response);
    $items = $obj1->{'items'};
    $there = array();
    
    echo "starting array_push \n";
    foreach ($items as $commentthere) {
            array_push($there, $commentthere->{'comment_id'});
    }
    echo "ended array_push \n";
    print_r($there);

    echo "\n started unsetting \n";
    foreach ($items as $comment) {
        unset($commentsToInspect[array_search($comment->{'comment_id'}, $commentsToInspect)]);
    }
    echo "ended unsetting \n";
    
    echo "started lastCronCheck setting \n";
    $time = date("Y:m:d H:i:s");
    $stillThereQuery = PDODatabaseObject()->prepare("UPDATE flags SET lastCronCheck=? WHERE `Id`=? AND `site`=?");
    foreach ($there as $stillthere){
        $stillThereQuery->execute(array($time, $stillthere, $siteTableName));
    }
    echo "ended lastCronCheck setting \n";
    
    print_r(count($commentsToInspect));
    
    $timestamp = date("Y-m-d H:i:s");
    $validQuery = PDODatabaseObject()->prepare("UPDATE flags SET handled=1, handleDate=?, wasValid=1, wasObsolete=1, handledBy=0 WHERE `Id`=? AND `site`=?");
    foreach ($commentsToInspect as $valid){
        echo $valid . "\n";
        echo "UPDATE flags SET handled=1, handleDate='$timestamp', wasValid=1, wasObsolete=1, handledBy=0 WHERE `Id`=" . $valid . " AND  `site`='" . $siteTableName . "' \n";
              
        $validQuery->execute(array($timestamp, $valid, $siteTableName));
    }
