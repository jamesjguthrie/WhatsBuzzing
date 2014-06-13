<?php

require 'vendor/autoload.php';
 
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
 
// start session
session_start();

// init app with app id and secret
FacebookSession::setDefaultApplication('746787215356096','4a660b9fa8686836cbf9933b943f6ad9');

$helper = new FacebookRedirectLoginHelper('http://heyjimmy.net/whatsbuzzing/index.php');

$loginUrl = $helper->getLoginUrl(array("scope"=>"read_stream"));
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WhatsBuzzing - Login</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/cover.css" rel="stylesheet">
    <link href="css/bootstrap-social.css" rel="stylesheet">
    <link href="css/font-awesome.css" rel="stylesheet">

     <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.
      <script src="https://oss.maxcdn.com/libs/respond.js/1>
    <![endif]-->
  </head>
  <body>
<div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand"></h3>
              <ul class="nav masthead-nav">
                <li><a href="http://heyjimmy.net">HeyJimmy Homepage</a></li>
                <li><a href="http://twitter.com/HeyJimmyUK">Twitter</a></li>
                <li><a href="mailto:james@heyjimmy.net">E-mail</a></li>
              </ul>
            </div>
          </div>

          <div class="inner cover">
            <h1 class="cover-heading"><img height="72px" src="images/WhatsBuzzingWhiteTextLogo.png"</img></h1>
            <p class="lead"><i>Your</i> trending list. Click below to see what's buzzing today.</p>
            <p class="lead">
              <?php echo '<a href="'.$loginUrl.'" class="btn btn-social btn-facebook"><i class="fa fa-facebook"></i>Login with Facebook</a>'; ?>
            </p>
          </div>

          <div class="mastfoot">
            <div class="inner">
              <p><img height="30px" src="images/WhatsBuzzingWhiteTextLogo.png"></img></p>
		<p>&copy 2014, Hey Jimmy Ltd.</p>
            </div>
          </div>

        </div>

      </div>

    </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
