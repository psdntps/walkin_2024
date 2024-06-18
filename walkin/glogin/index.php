<center>
<br><br>
<?php
    date_default_timezone_set('Asia/Bangkok');
    $today = time();
    $targetDate = strtotime('2024-11-09 23:59:59');     //กำหนดวัน-เวลา ต้องการ action กับระบบอย่างไร

    if ($today > $targetDate) {     //เงื่อนไข เกินกำหนดให้ปิดระบบ
        echo "<h1><font color='red'>เว็บไซต์นี้งดให้บริการ<br>The service is no longer available</font></h1>";
        exit();
    } 
?>

<?php
    // Include Configuration File
    include($_SERVER['DOCUMENT_ROOT'] . '/conn/config.php');
    

    $login_url = $google_client->createAuthUrl();
    echo "<a href='$login_url'><img src='../glogin/assets/web_light_rd_SI@2x.png' width='200px' height='auto'/></a>";

    echo "<br><br><img src = '../qrcode_esd.psd.ku.ac.th.png' width='250px' height='auto'><br>";
    echo "<a href='../manual (summer).pdf'>คู่มือการเข้าระบบจองสอบ</a>";

?>
</center>
