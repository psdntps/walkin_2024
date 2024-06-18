<?php
  // ตรวจสอบว่ามีการเรียกใช้ session_start() ก่อนหน้านี้หรือไม่
  if (session_status() == PHP_SESSION_NONE) {
      session_start();    
  }
?>

<?php
    
  #default
  $data_arr = array();

  if (isset($_POST['submit'])) {
	
      #input
      $data_arr = array(      //ตัวแปรอาเรย์ที่ส่งเข้าไป in
        "idUser" => $_SESSION['idUser'],  //พอเซฟภาพ จะได้ idUser
        "idStudent" => $_POST['idStudent'],
        "profileName" => $_SESSION['user_profilename'],
        "email" => $_SESSION['user_email_address'],
        "success" => $_SESSION['success']
      );

      #url
      // include('/api/information.php');
      include($_SERVER['DOCUMENT_ROOT'] . '/walkin/person/api/information.php');  
      $arr_json = putInformation($data_arr);
      $out_api = json_decode($arr_json, true);
  
      #นำค่าไปใช้ต่อ
      $idUser = $out_api['idUser'];
      $idStudent = $out_api['idStudent'];
      $success = $out_api['success'];

      $_SESSION['idUser'] = $idUser;
      $_SESSION['idStudent'] = $idStudent;
      $_SESSION['success'] = $success;
      // var_dump($out_api); //nsk
      
      if($success == 'P') { //ตรวจเงื่อนไข
        #input
        $data_arr = array(      //ตัวแปรอาเรย์ที่ส่งเข้าไป in
            "idUser" => $_SESSION['idUser'],  //พอกรอก info ยืนยัน จะได้ idUser
            "idStudent" => $_SESSION['idStudent'],
            "success" => $_SESSION['success']
        );	
    
        //debug
        // echo "<pre>";
        // print_r($data_arr);
        // echo "</pre>";
        
        include('api/information.php');
        $arr_json = checkInformation($data_arr);
        $out_api = json_decode($arr_json, true);
    
        //debug
        // echo "<pre>";
        // print_r($out_api);
        // echo "</pre>";
    
    
        #นำค่าไปใช้ต่อ
        $success = $out_api['success'];
        $_SESSION['success'] = $success;
    
        // ข้อมูลสำหรับแปลผล
        $check_P = $out_api['check_P'];  // 0ไม่พบข้อมูล 1 พบข้อมูล
        $campus = $out_api['description'];
        $remark = $out_api['remark'];
        $_SESSION['check_P'] = $check_P;  //ตรึงไว่เพื่อดำเนินการต่อให้สำเร็จ
    
      }

      #redirect
      if ($success == 'V') {
        // ส่งต่อไปยังหน้าถัดไปและส่ง Access Token ด้วย
        header("Location: ../index.php?page=mooc");
        exit();
      } 
  }
?>
