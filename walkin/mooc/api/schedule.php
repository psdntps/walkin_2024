<?php
	ini_set('display_errors', 1); 
	// header("Content-Type:application/json");	//json ไม่รับค่า session รับ get/post หรือ content เท่านั้น

  function getSchedule($data_arr) {
    #default
      // รับเข้ามา
      $out = array();
      $mooc_id = $data_arr['mooc_id'];
      $gapHour = $data_arr['gapHour'];
      $evn_id = $data_arr['evn_id'];

      include($_SERVER['DOCUMENT_ROOT'] . '/walkin/conn/conndb.php'); 

    #query 
      // ข้อมูล schedule ทั้งหมด และมาร์คตัวที่เลือกแล้ว เพื่อนำไปสร้าง ddl
      $sql = "SELECT a.id as schedule_id, a.evn_id, a.dat_id, a.tim_id, a.limited, b.evn_date, c.rangeTime, c.timeStart, 
                     d.mooc_id,d.schedule_id as schedule_selected,d.round,d.isReserved,d.id tran_id,d.revisedBy,d.updatedDate,d.updatedBy, 
                     f.bucket, f.gapTime, f.cnt, (a.limited-IFNULL(cnt, 0)) AS seat_avai,
                     CASE 
                          WHEN  d.schedule_id = a.id THEN 1 
                          ELSE 0 
                     END as isBlock
              FROM walkin_a_schedule a 
              LEFT JOIN walkin_a_evn2date b ON b.id = a.dat_id AND b.active = 'A' 
              LEFT JOIN walkin_time c ON c.id = a.tim_id AND c.active = 'A' 
              LEFT JOIN walkin_transaction d ON a.id = d.schedule_id and d.active='A' and 
                d.mooc_id = $mooc_id 
              LEFT JOIN walkin_view_time_bucket_update f on f.schedule_id=a.id 
              WHERE a.active = 'A' and a.gap=$gapHour and a.evn_id=$evn_id
              ORDER BY a.id;";
      $result = mysqli_query($conn, $sql) or die("Fail: " . mysqli_error($conn));
      $cnt = mysqli_num_rows($result);

      if($cnt > 0) {  
        while($row=mysqli_fetch_assoc($result)) {
          $out[]=$row;  //เลือกทั้งหมด -> มีได้มากกว่า 1 วิชา
        } 
        mysqli_free_result($result);
      }

      mysqli_close($conn);

    #output
      // จะได้ข้อมูล schedule_id ของ mooc นั้นที่มีโอกาสเลือกทั้งหมด isBlock เลือกไปแล้วเป็น 1 หากยังไม่เลือกเป็น 0 
      return json_encode($out, JSON_UNESCAPED_UNICODE); //แปลง array เป็น json, ภาษาไทย 
  }
?>