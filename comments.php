<?php

require 'vendor/autoload.php';

include_once("analyticstracking.php");
 
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
$newsstoriesURL = $_SESSION['newsstoriesURL'];
$namearray = $_SESSION['namearray'];
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
    <title>WhatsBuzzing - What\'s everyone saying?</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/cover.css" rel="stylesheet">
    <link rel="icon" href="favicon.ico" type="image/x-icon" />

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
              <h3 class="masthead-brand">'.$comments.'</h3>
              <ul class="nav masthead-nav">
                <li><a href="http://heyjimmy.net">HeyJimmy Homepage</a></li>
                <li><a href="http://twitter.com/HeyJimmyUK">Twitter</a></li>
                <li><a href="mailto:james@heyjimmy.net">E-mail</a></li>
              </ul>
            </div>
          </div>

          <div class="inner cover">

<p class="lead"></p>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- WhatsBuzzing -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-5237428979268056"
     data-ad-slot="5184630970"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>            
<table class="table table-responsive"><tbody><tr>';



function check_second_url($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch ,CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.31 (KHTML, like Gecko) Chrome/26.0.1410.64 Safari/537.31');
		$data = curl_exec($ch);
		$headers = curl_getinfo($ch);
		//$whaturl = $headers['url'];
		curl_close($ch);
		return $headers['http_code'];
	}
$count = 0;

	foreach ($newsstories as $url=>$id) {
	if (strpos(strtolower($id),$comments) !== false) {
		$check_url_status = check_second_url($newsstoriesURL[$url]);
			if ($check_url_status == '200') {
   				echo '<tr><td><h4>'.$namearray[$url].'</h4></td></tr><tr><td><a href="'.$newsstoriesURL[$url].'" target="_blank"><h2>'.$id.'</h2></a></td></tr>';
			}
			else {
				//$check_second_url_status = check_second_url($newsstoriesID[$url]);
				//if ($check_second_url_status == "404") {
				$newurl = str_replace("/posts/", "_",$newsstoriesURL[$url]);
				echo '<tr><td><h4>'.$namearray[$url].'</h4></td></tr><tr><td><a href="'.$newurl.'" target="_blank"><h2>'.$id.'</h2></a></td></tr>';
			//}
			//else echo '<tr><td>'.$check_second_url_status.'</td><td> <a href="'.$newsstoriesID[$url].'"</a><h2>'.$id.'</h2></td></tr>';
			}
		}
	}
	

echo '</tbody></table></p>

          <br /> <br /> <br /><br /><div class="mastfoot">
            <div class="inner">
              <p><img height="30px" src="images/WhatsBuzzingWhiteTextLogo.png"></img></p>
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


