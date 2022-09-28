<?php
session_start();
define('MYDIR','google-api-php-client--PHP8.0/');
require_once(MYDIR."vendor/autoload.php");

$client = new Google_Client();
$client->setAuthConfig('credentials.json');
      
//Unset token from session
unset($_SESSION['upload_token']);

// Reset OAuth access token
$client->revokeToken();

//Destroy entire session
session_destroy();

//Redirect to homepage      
header("Location: login.php");
?>