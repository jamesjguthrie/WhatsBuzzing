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

	foreach ($newsstories as $url=>$id) {
	if (strpos(strtolower($id),$comments) !== false) { 
		$check_url_status = check_url($newsstoriesID[$url]);
			if ($check_url_status == '301') {
   				echo '<center><a href="'.$newsstoriesID[$url].'"</a>'.$id.'</center><br />';
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

