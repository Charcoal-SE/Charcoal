<?php

include "base.php";
 
$url = 'https://api.stackexchange.com/2.1/posts/' . $_POST["id"] . '/comments';
$data = array("site" => $_SESSION["Site"], "filter" => "!SrhZo6aE2O(w*j4-4i", "order" => "asc", key => "mmpZxopkL*psP5WoBK6BuA((");
 
$response = (new Curl)->exec($url . '?' . http_build_query($data), [CURLOPT_ENCODING => 'gzip']);
 
echo $response;
