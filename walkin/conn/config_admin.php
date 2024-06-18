<?php

    // require '/usr/local/bin/vendor/autoload.php';
    require_once './../../google-api-php-client/vendor/autoload.php';

    $google_client = new Google_Client();
    $google_client->setClientId('1018419520699-fb3raupfhuprqo1potl4niur719unqkp.apps.googleusercontent.com');
    $google_client->setClientSecret('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');
    // $google_client->setRedirectUri('http://localhost/walkin/admin/login.php'); 
    // $google_client->setRedirectUri('http://localhost:9901/admin/login.php'); 
    $google_client->setRedirectUri('https://esd.psd.ku.ac.th/walkin/admin/login.php'); 
    
    $google_client->addScope('email');
    $google_client->addScope('profile');

?>