<?php
  #ตรวจสอบว่าหลังล็อคอินเข้ามาแล้ว เซสซันอีเมลนี้ผ่านการยืนยันตนมารึยัง ส่ง gmail ไปค้นว่า มีข้อมูลหรือไม่ 
  // 1) ถ้ามี > ให้ return ค่า idStudent นั้นๆ และ fix เซสซัน success=V 
  // 2) ถ้าไม่มี > ก็เริ่มต้นตั้งแต่แรกตามปกติ

  ini_set('display_errors', 1); 
	// header("Content-Type:application/json");	//json ไม่รับค่า session รับ get/post หรือ content เท่านั้น

	#default
  $out = array();

  function isAuthorizedUser($data_arr) {

    include($_SERVER['DOCUMENT_ROOT'] . '/conn/conndb.php'); 
    
    #query
    $sql = "select id,idStudent,verified 
            from walkin_student 
            where email='".$data_arr['email']."' 
            order by id;";	//ยืนยันตัวตนจากฐานข้อมูล
    $result = mysqli_query($conn,$sql) or die("Fail : " .mysqli_error($conn)); 
    $cnt = mysqli_num_rows($result);

    if($cnt>0) { //กรณี verified=1 แล้ว (มีข้อมูล + มีภาพใบหน้า) //มีชื่อในระบบแล้ว

      while($cols=mysqli_fetch_array($result)) {

        if($cols['verified'] == 1) { //1 ถ่ายภาพแล้ว
          //ยืนยันแล้ว success=V
          $out = array( 
            'error' => 200,
            'message' => 'Verified',
            'success' => 'V',
            'idUser' => $cols['id'],
            'idStudent' => $cols['idStudent'] //ถ้าไม่เป็น null แสดงว่าเอาข้อมูลลงในระบบแล้ว
          );          

        } elseif ($cols['verified'] == 0) { //0 ยังไม่ถ่ายภาพ
          //ถ่ายภาพใบหน้า + กรอกข้อมูลเพิ่ม success=I
          $out = array( 
            'error' => 200,
            'message' => 'KU Register',
            'success' => 'P',
            'idUser' => $cols['id'],
            'idStudent' => $cols['idStudent'] //ถ้าไม่เป็น null แสดงว่าเอาข้อมูลลงในระบบแล้ว
          );
        }

      } 
      mysqli_free_result($result);
      
    } else {  //กรณีเริ่มต้น (ผ่านกระบวนการดึงข้อมูลแล้ว เป็น 0) success=ว่าง ไม่มีชื่อในระบบเลย  ///อันนี้ยกเลิกเลย
        $out = array( 
          'error' => 200,
          'message' => 'ไม่พบการลงทะเบียนเรียนรายวิชา',
          'success' => '',
          'idUser' => '',
          'idStudent' => ''
        );
    }
    
    mysqli_close($conn);

    #output
    return json_encode($out, JSON_UNESCAPED_UNICODE); //แปลง array เป็น json, ภาษาไทย
  }
?>