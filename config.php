<?php

//start session on web page
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//config.php
//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$google_client->setClientId('31341166237-gphlbdjbmhht66u3rthdo3il62gash8k.apps.googleusercontent.com');

//Set the OAuth 2.0 Client Secret key
$google_client->setClientSecret('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');

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://localhost:8081/test-login-api/index.php');

// to get the email and profile 
$google_client->addScope('email');

$google_client->addScope('profile');
