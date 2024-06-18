<?php
//  // ตรวจสอบว่ามีการเรียกใช้ session_start() ก่อนหน้านี้หรือไม่
// if (session_status() == PHP_SESSION_NONE) {
//     session_start();    
// }
// include('../conn/ss.php');
include($_SERVER['DOCUMENT_ROOT'] . '/conn/ss.php'); 
?>

<?php
// ตรวจสอบว่าผู้ใช้ล็อคอินผ่าน SSO หรือไม่
if (isset($_GET['code'])) {
    // Include Configuration File
    // include('../conn/config.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/conn/config.php'); 

    // แลกเปลี่ยน code เป็น Access Token
    try {
        $google_client->authenticate($_GET['code']);
        $token = $google_client->getAccessToken();  
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
    // var_dump($token);

    // เก็บ Access Token ในเซสชัน
    $_SESSION['access_token'] = $token;
  
    // สร้าง Google Service OAuth2 เพื่อรับข้อมูลผู้ใช้
    $auth = new Google_Service_Oauth2($google_client);

    // ดึงข้อมูลผู้ใช้
    $user = $auth->userinfo->get();
    // var_dump($user);

    // เก็บข้อมูลผู้ใช้ในเซสชัน
    // $_SESSION['user_id'] = $user->id;
    $_SESSION['user_email_address'] = $user->email;
    $_SESSION['user_profilename'] = $user->name;
    $_SESSION['user_image'] = $user->picture;

    # นำค่าไปใช้ต่อ 
    // ตรวจสอบสิทธิ์ผู้ใช้ >> ตรวจสอบ email ว่าเป็น P (รายใหม่-skip ถ่ายภาพ) หรือ V (รายเก่า)
    $data_arr = array(  //ตัวแปรอาเรย์ที่ส่งเข้าไป in
        "email" => $user->email,        
    );

    // var_dump($data_arr);
    include('api/verifiedUser.php');
    $arr_json = isAuthorizedUser($data_arr);
    $out_api = json_decode($arr_json, true);

    // ถ้าผู้ใช้ได้รับการยืนยัน
    $_SESSION['idUser'] = $out_api['idUser'];
    $_SESSION['idCard'] = $out_api['idCard'];

    if ($out_api['success'] == 'N') {
        $_SESSION['success'] = 'N';
        header('Location: ../index.php?page=person');  //ไม่มีชื่อในระบบ >> เริ่มกรอกใหม่
        exit();

    } elseif ($out_api['success'] == 'P') {
        $_SESSION['success'] = 'P';
        header('Location: ../index.php?page=person');   //มีชื่อในระบบแล้ว แต่ยัง incompleted >> ให้กรอกบางส่วนต่อ เช่น รหัสนิสิต 
        exit();

    } elseif ($out_api['success'] == 'V') {
        $_SESSION['success'] = 'V';
        header('Location: ../index.php?page=mooc');     //มีชื่อในระบบแล้ว และ completed >> ไปต่อ
        exit();

    } else {
        echo json_encode(array('status' => 'error', 'message' => 'User is not authorized'));
        exit;
    }

} 
?>
