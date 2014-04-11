<?php
    include "base.php";
    if ($_SESSION['ischarcoalmod']==0) return;

    $timestamp = date("Y:m:d H:i:s");
    $stmt = PDODatabaseObject()->prepare("UPDATE flags SET handled=1, handleDate=?, wasValid=1, wasObsolete=1, toFlag=1, handledBy=? WHERE `Id`=? AND  `site`=?");  
    $stmt->execute(array($timestamp, $_SESSION["UserID"], $_POST["id"], $_SESSION["Site"]));

    echo "success";
?>
