<?php

//session_start();
include_once("Google_Client.php");
include_once("contrib/Google_Oauth2Service.php");
######### edit details ##########
$clientId = get_option('qsoft_google_app_id'); //Google CLIENT ID
$clientSecret = get_option('qsoft_google_app_secret'); //Google CLIENT SECRET
$redirectUrl = admin_url('/admin-ajax.php/?action=qsoft_google_callback');  //return url (url to script)
$homeUrl = admin_url('/admin-ajax.php/?action=qsoft_google_callback');  //return to home
##################################

$q_google_client = new Google_Client();
$q_google_client->setApplicationName('Login to codexworld.com');
$q_google_client->setClientId($clientId);
$q_google_client->setClientSecret($clientSecret);
$q_google_client->setRedirectUri($redirectUrl);

$google_oauthV2 = new Google_Oauth2Service($q_google_client);
?>