<?php
  
  // This array contains the list of apis allowed to be used with this proxy
  $config = array(
    "twitter" => array(
      "domain" => "http://api.twitter.com/",
      "type" => "json", // probably don't need this
      "header" => "application/json"
    ),
    "flickr" => array(
      "domain" => "http://dev.flickr.com/",
      "type" => "xml",
      "header" => "text/xml"
    ),
    //this one is slightly different
    "cachedir" => dirname(__FILE__).'/cache'
  );

  $cache_file = "";
  $api = $_GET['api'];
  $funct = isset($_GET['funct']) ? $_GET['funct'] : '';


  if (array_key_exists($api,$config)) {
    //directory where I hide my caches
    $cache_dir = $config['cachedir'].'/'.$api.'_cache';
    //domain associated with api
    $domain = $config[$api]['domain'];
    //set the respose header
    header("Content-Type: ".$config[$api]['header']);
    check_file($cache_dir,$domain,$funct);
  }
  

  //decide if the file is there and valid, return true or false
  function check_file($cache_dir,$domain,$funct) {

    $cache_file = False;
    if (strlen($funct) == 0) {
      $cache_file = $cache_dir."/index";
    }

    if (!is_dir($cache_dir)) {
      @mkdir($cache_dir, 0770, true);
    }

    $cache_file = $cache_file ? $cache_file : $cache_dir.'/'.str_replace("/",".",$funct);
    $url = $domain.$funct;

    if(file_exists($cache_file)) {
      
      if ((filemtime($cache_file) - strtotime('now')) < -600) {
        file_put_contents($cache_file, get_data($url));
      } else {
        echo file_get_contents($cache_file);
      }
    } else {
      file_put_contents($cache_file, get_data($url));
    }
  }

  function get_data($url){
    $data = file_get_contents($url);
    echo $data;
    return $data;
  }
?>
