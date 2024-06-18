<?php
  ini_set('display_errors', 1); 
  // header("Content-Type:application/json");	//json ไม่รับค่า session รับ get/post หรือ content เท่านั้น

  #default
  $out = array();

  function isAuthorizedUser($data_arr) {
    #query
    include($_SERVER['DOCUMENT_ROOT'] . '/walkin/conn/conndb.php');

    // ส่งคำสั่ง SQL 1
    $sql = "SELECT * FROM walkin_role WHERE email='".$data_arr['email']."' AND verified=1 ORDER BY id;"; //ยืนยันตัวตนจากฐานข้อมูล
    $result = mysqli_query($conn,$sql) or die("Fail : " .mysqli_error($conn)); 
    $cnt = mysqli_num_rows($result);

    if ($cnt > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $out[] = $row;
        // $out[] = array_merge($out ?? [], $row);
      }
      mysqli_free_result($result);

      //ถ้าพบสิทธิ์ ให้ update checkin ด้วย
      $sql_in = "UPDATE `walkin_role` SET lastDate=now() WHERE email='".$data_arr['email']."'";
      $result_in = mysqli_query($conn,$sql_in) or die("Fail : " .mysqli_error($conn)); 

    } else {
        $out = array( 
          'error' => 200,
          'message' => 'ไม่พบข้อมูล admin',
        );
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    mysqli_close($conn);

    #output
    return json_encode($out, JSON_UNESCAPED_UNICODE); //แปลง array เป็น json, ภาษาไทย
  }

?>