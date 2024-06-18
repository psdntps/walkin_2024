<?php
//url
    if(!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])){
        $uri = 'https://';
    }else{
        $uri = 'http://';
    }
    $uri .= $_SERVER['HTTP_HOST'];  
    // ตัวอย่างการใช้งาน
	// header('Location: '.$uri.'/walkin');
	// exit;
?>