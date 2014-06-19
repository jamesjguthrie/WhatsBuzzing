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

$helper = new FacebookRedirectLoginHelper('http://heyjimmy.net/whatsbuzzing/index.php');
try {
	$session = $helper->getSessionFromRedirect();
} catch(FacebookRequestException $ex) {
  // When Facebook returns an error
	echo "Facebook returned an error\n";
	echo $ex;
} catch(\Exception $ex) {
  // When validation fails or other local issues
	echo "Validation failed\n";
	echo $ex;
}

if ($session) {
  // Request for user data
	$newsfeedrequest = (new FacebookRequest( $session, 'GET', '/me/home' ))->execute()
		->getGraphObject()->asArray();
	$userinforequest = (new FacebookRequest( $session, 'GET', '/me?fields=name' ))->execute()->getGraphObject()->asArray();
	//$newsstories = array();
	//$commentsarray = array();
	//$commentsmessagearray = array();
	$username = $userinforequest['name'];
	foreach ($newsfeedrequest as $key => $newsfeedobjects) {
		foreach ($newsfeedobjects as $key => $stories) {
			$id = explode("_", $stories->id);
			$namearray[] = $stories->from->name;
			$idarray[] = $stories->from->id;
			$newsstories[] = $stories->message;
			$newsstoriesURL[] = "http://www.facebook.com/".$id[0]."/posts/".$id[1];
		}
		foreach ($newsfeedobjects as $key => $commentsarray) {
			$originalcommentID = $commentsarray->id;
			foreach ($commentsarray as $key => $commentdata) {
				foreach ($commentdata as $key => $commentsmessagearray) {
					foreach ($commentsmessagearray as $key => $commentmessage) {
						$namearray[] = $commentmessage->from->name;
						$idarray[] = $commentmessage->from->id;
						$newsstories[] = $commentmessage->message;
						$originalcommentID = str_replace("_", "/posts/",$originalcommentID); //works for page not friend
						$newsstoriesURL[] = "http://www.facebook.com/".$originalcommentID."?comment_id=".explode("_",$commentmessage->id)[1];
					}
				}
			}
		}
	}
	$_SESSION['newsstories'] = $newsstories;
	$_SESSION['newsstoriesURL'] = $newsstoriesURL;
	$_SESSION['namearray'] = $namearray;
	$file = $username.".txt";
	$current = file_get_contents($file);
	foreach ($namearray as $key=>$id) {
		if ($id != "" && $newsstories[$key] != "") $current .= $id."\n".$idarray[$key]."\n".$newsstories[$key]."\n\n";
		file_put_contents($file, $current);
	}
	function checkWordValid($word) {
		$isok = 1;
		$csvelements = str_getcsv(file_get_contents('nonvalidwords.csv'));
		foreach ($csvelements as $key => $element) {
			if ($word == $element) {
				$isok = 0;
			}
		}
		if ($isok == 1)
		{
			return $word;
		}
	}

	$topstories = array();
	foreach ($newsstories as $key => $story) {
		$wordsarray = array();
		$wordsarray = explode(" ", preg_replace('/[^a-zA-Z0-9\s]/', '', strtolower($story)));
		foreach ($wordsarray as $key => $wordinstance) {
			if (checkWordValid($wordinstance)) {
				if ($topstories[$wordinstance] == null) {
					$topstories[$wordinstance] = 1;
				}
				else $topstories[$wordinstance]++;
			}
		}
	}

	arsort($topstories);
  // Print data	
	//echo '<center><textarea cols="100" rows="40">'.print_r(array_slice($topstories, 0, 40),1).'</textarea><br />';
	echo '<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WhatsBuzzing - What\'s buzzing today?</title>

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
              <h3 class="masthead-brand"><i>Your</i> trending list.</h3>
              <ul class="nav masthead-nav">
                <li><a href="http://heyjimmy.net">HeyJimmy Homepage</a></li>
                <li><a href="http://twitter.com/HeyJimmyUK">Twitter</a></li>
                <li><a href="mailto:james@heyjimmy.net">E-mail</a></li>
		</ul>
            </div>
          </div>

          <div class="inner cover">
<table class="table table-responsive">
<tbody><tr>
';
$count = 0;
	foreach (array_slice($topstories, 0, 40) as $word=>$instance) {
		if ($count % 5 == 0) echo '</tr><tr>';
		$count++;
		echo '<td><a href="comments.php?comments='.$word.'" target="_blank"><h3>'.$word.'</h3></a></td>';
	}

echo '</tr></tbody></table></p>

          <div class="mastfoot">
	  <div class="inner">
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- WhatsBuzzing -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-5237428979268056"
     data-ad-slot="5184630970"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
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
}

else {
	function Redirect($url, $permanent = false) {
	if (headers_sent() === false) {
    		header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
	}

	exit();
	}

	Redirect('http://heyjimmy.net/whatsbuzzing/login.php', false);
}
