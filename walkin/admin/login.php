<?php
 // ตรวจสอบว่ามีการเรียกใช้ session_start() ก่อนหน้านี้หรือไม่
 if (session_status() == PHP_SESSION_NONE) {
    session_start();    
}

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือยัง
if (isset($_GET['code'])) {

    include($_SERVER['DOCUMENT_ROOT'] . '/walkin/conn/config_admin.php');

    try {
        $google_client->authenticate($_GET['code']);
        $token = $google_client->getAccessToken();  
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }

    // เก็บ Access Token ในเซสชัน
    $_SESSION['access_token'] = $token;
  
    // สร้าง Google Service OAuth2 เพื่อรับข้อมูลผู้ใช้
    $auth = new Google_Service_Oauth2($google_client);

    // ดึงข้อมูลผู้ใช้
    $user = $auth->userinfo->get();
    // var_dump($user); /nsk

    // เก็บข้อมูลผู้ใช้ในเซสชัน
    // $_SESSION['user_id'] = $user->id;
    $_SESSION['user_email_address'] = $user->email;
    $_SESSION['user_profilename'] = $user->name;
    $_SESSION['user_image'] = $user->picture;

    // เป็น admin หรือไม่ ?
    $data_arr = array(  //ตัวแปรอาเรย์ที่ส่งเข้าไป in
        "email" => $user->email, 
    );
    // print_r($data_arr); //nsk
    include('api/verifiedRole.php');
    $arr_json = isAuthorizedUser($data_arr);
    $out_api = json_decode($arr_json, true);
    // var_dump($out_api); //nsk
    
    #นำค่าไปใช้ต่อ 
    if(isset($out_api)) {
        $role = $out_api[0]['role'];    //admin
        $_SESSION['role'] = $role;

        header('Location: index.php?page=subject');
        exit();

    } else {
        echo json_encode(array('status' => 'error', 'message' => 'User is not authorized'));
        exit;
    }

  #ประกาศ information
    echo "<div class='container' style='border: none; box-shadow: none; width: 650px; margin: 50px auto;'>";
    $filename = "../info.txt";
    $filepath = "";     
    
    $handle = fopen($filepath . $filename, "r");
    
    if ($handle) {
        echo "<br><div class='text-primary text-left'>";
        // echo "<hr><b> &nbsp; หมายเหตุ</b><br>";
        while (!feof($handle)) {
            $line = fgets($handle);
            
            echo $line . "<br>";
        }
        echo "<div>";

    } else {
        echo "ไฟล์ไม่พบ";
    }
    
    fclose($handle);
    echo "</div>";
  #ประกาศ informatoin

} else {   
?>
<center>
<br><br>

<?php
    date_default_timezone_set('Asia/Bangkok');
    $today = time();
    $targetDate = strtotime('2024-06-09 23:59:59');     //กำหนดวัน-เวลา ต้องการ action กับระบบอย่างไร

    if ($today > $targetDate) {     //เงื่อนไข เกินกำหนดให้ปิดระบบ
        echo "<h1><font color='red'>เว็บไซต์นี้งดให้บริการ<br>The service is no longer available</font></h1>";
        exit();
    } 
?>

<?php
    include('../conn/config_admin.php');

    $login_url = $google_client->createAuthUrl();
    echo "<h1>สำหรับผู้ประสานงานการจัดสอบ</h1>";
    echo "<a href='$login_url'><img src='../glogin/assets/web_light_rd_SI@2x.png' width='200px' height='auto'/></a><br><br>";
}

?>
</center>