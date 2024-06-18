<?php
    // ตรวจสอบว่ามีการเรียกใช้ session_start() ก่อนหน้านี้หรือไม่/
    if (session_status() == PHP_SESSION_NONE) {
        session_start();    
    }  
    // error_reporting(E_ALL); 
?>

<?php
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : ""; 

    if ($role == "admin") { //skip take photo & OTP save profile
        include('../admin/report_subject.php'); 

    } else {   
        echo '<script>window.top.location.href = "login.php";</script>';
        exit();
    }
?>
