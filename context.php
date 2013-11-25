<?php

include "base.php";
 
$url = 'https://api.stackexchange.com/2.1/posts/' . $_POST["id"] . '/comments';
$data = array("site" => $_SESSION["Site"], "filter" => "!SrhZo6aE2O(w*j4-4i", "order" => "asc");
 
$response = (new Curl)->exec($url . '?' . http_build_query($data), [CURLOPT_ENCODING => 'gzip']);
 
echo $response;
 
class Curl
{
  protected $info = [];
  
  public function exec($url, $setopt = array(), $post = array())
  {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:15.0) Gecko/20100101 Firefox/15.0.1');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    if ( ! empty($post))
    {
      curl_setopt($curl, CURLOPT_POST, 1);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
    }
    if ( ! empty($setopt))
    {
      foreach ($setopt as $key => $value)
      {
        curl_setopt($curl, $key, $value);
      }
    }
    $data = curl_exec($curl);
    $this->info = curl_getinfo($curl);
    curl_close($curl);
    return $data;
  }
 
  public function getInfo()
  {
    return $this->info;
  }
}