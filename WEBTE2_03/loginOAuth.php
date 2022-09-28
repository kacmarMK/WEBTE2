<?php

session_start();
date_default_timezone_set('Europe/Bratislava');
define('MYDIR','google-api-php-client--PHP8.0/');
require_once(MYDIR."vendor/autoload.php");

$redirect_uri = 'https://wt69.fei.stuba.sk/z3AutentifKcmr/loginOAuth.php';

$client = new Google_Client();
$client->setAuthConfig('credentials.json');
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");

$service = new Google_Service_Oauth2($client);
			
if(isset($_GET['code'])){
  $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
  $client->setAccessToken($token);
  $_SESSION['upload_token'] = $token;

  // redirect back to the example
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

// set the access token as part of the client
if (!empty($_SESSION['upload_token'])) {
  $client->setAccessToken($_SESSION['upload_token']);
  if ($client->isAccessTokenExpired()) {
    unset($_SESSION['upload_token']);
  }
} else {
  $authUrl = $client->createAuthUrl();
}

if ($client->getAccessToken()) {
    //Get user profile data from google
    $UserProfile = $service->userinfo->get();
    if(!empty($UserProfile)){
        $_SESSION['username'] = $UserProfile['email'];
        $_SESSION['logout'] = "oAuth";
        $_SESSION['date'] = date("Y-m-d H:i:s");
        $_SESSION['type'] = "oAuth";
        header("location: index.php");
    }else{
        $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
    }   
  } else {
      $authUrl = $client->createAuthUrl();
      header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
  }
?>
<div><?php echo $output; ?>
</div>
