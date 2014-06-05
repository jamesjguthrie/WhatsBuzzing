<?php

require '../vendor/autoload.php';
 
use Facebook\FacebookHttpable;
use Facebook\FacebookCurl;
use Facebook\FacebookCurlHttpClient;
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookOtherException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphSessionInfo;
 
// init app with app id and secret

session_start();

FacebookSession::setDefaultApplication('746787215356096','4a660b9fa8686836cbf9933b943f6ad9');

$newsstories = $_SESSION['newsstories'];
$newsstoriesID = $_SESSION['newsstoriesID'];
$comments = $_GET['comments'];

function check_url($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch ,CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		$data = curl_exec($ch);
		$headers = curl_getinfo($ch);
		//$whaturl = $headers['url'];
		curl_close($ch);
		return $headers['http_code'];
	}

echo '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WhatsBuzzing - Login</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/cover.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
<div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand">WhatsBuzzing</h3>
              <ul class="nav masthead-nav">
                <li><a href="http://heyjimmy.net">HeyJimmy Homepage</a></li>
                <li><a href="http://twitter.com/HeyJimmyUK">Twitter</a></li>
                <li><a href="mailto:james@heyjimmy.net">E-mail</a></li>
              </ul>
            </div>
          </div>

          <div class="inner cover">

<p class="lead"></p>
            
<table class="table table-responsive"><tbody><tr>';
$count = 0;

	foreach ($newsstories as $url=>$id) {
	if (strpos(strtolower($id),$comments) !== false) { 
		$check_url_status = check_url($newsstoriesID[$url]);
			if ($check_url_status == '301') {
   				echo '<tr><td><a href="'.$newsstoriesID[$url].'"</a><h2>'.$id.'</h2></td></tr>';
				//echo $check_url_status;
				//print_r($whaturl);
			}
			//else {
			//	$newsstoriesID[$url] = str_replace("_","/posts/",$newsstoriesID[$url]);
			//	echo '<center>Not 200<a href="'.$newsstoriesID[$url].'"</a>'.$id.'</center><br />';
			//	echo $check_url_status;
			//}
		}
	}

echo '</tbody></table></p>

          <div class="mastfoot">
            <div class="inner">
              <p>&copy 2014, Hey Jimmy Ltd.</p>
            </div>
          </div>

        </div>

      </div>
</div>
        <!-- jQuery (necessary for Bootstrap\'s JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>';


