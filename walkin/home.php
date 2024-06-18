<?php
    // ตรวจสอบว่ามีการเรียกใช้ session_start() ก่อนหน้านี้หรือไม่/
    if (session_status() == PHP_SESSION_NONE) {
        session_start();    
    }   
    // error_reporting(E_ALL);
?>

<?php

    $success = isset($_SESSION['success']) ? $_SESSION['success'] : ""; 

    if ($success == "P") { //skip take photo & OTP save profile
        include('./person/index.php'); 

    } elseif ($success == "V") { //verify otp
        include('./mooc/index.php'); 

    } else {   
        echo '<script>window.top.location.href = "./glogin/";</script>';
        exit();
    
    }

?>