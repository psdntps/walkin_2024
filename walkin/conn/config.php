<?php

    require '/usr/local/bin/vendor/autoload.php';
    // require_once './../../google-api-php-client/vendor/autoload.php';

    $google_client = new Google_Client();
    $google_client->setClientId('1018419520699-6mjv8036tuarcbcaqn7cun2th36btir2.apps.googleusercontent.com');
    $google_client->setClientSecret('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');
    // $google_client->setRedirectUri('http://localhost/walkin/glogin/login.php'); 
    $google_client->setRedirectUri('http://localhost:8888/glogin/login.php'); 
    // $google_client->setRedirectUri('https://esd.psd.ku.ac.th/walkin/glogin/login.php'); 
    
    $google_client->addScope('email');
    $google_client->addScope('profile');

?>