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
  
	//$newsstories = array();
	//$commentsarray = array();
	//$commentsmessagearray = array();
	foreach ($newsfeedrequest as $key => $newsfeedobjects) {
		foreach ($newsfeedobjects as $key => $stories) {	  
			$newsstories[] = $stories->message;
		}
		foreach ($newsfeedobjects as $key => $commentsarray) {
			foreach ($commentsarray as $key => $commentdata) {
				foreach ($commentdata as $key => $commentsmessagearray) {
					foreach ($commentsmessagearray as $key => $commentmessage) {
						$newsstories[] = $commentmessage->message;
					}
				}
			}
		}
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
	echo '<center><textarea cols="100" rows="40">'.print_r($topstories, 1).'</textarea><br />';

	/*$
	 photorequest = (new FacebookRequest($session, 'GET', '/me/picture?type=large&redirect=false'))
	  ->execute()->getGraphObject()->asArray();
	echo '<img src="'.$photorequest->url.'">';
	 */
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
