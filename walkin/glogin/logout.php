<?php   
    // ตรวจสอบว่ามีการเรียกใช้ session_start() ก่อนหน้านี้หรือไม่
    if (session_status() == PHP_SESSION_NONE) {
        session_start();    
    }

    include('../conn/config.php');

    // Unset all session variables
    session_unset();

    //Reset OAuth access token
    $google_client->revokeToken();

    //Destroy entire session data.
    session_destroy();

    // Redirect to index.php using _top frame targeting
    echo '<script>window.top.location.href = "./../glogin/";</script>';
    exit();
?>
