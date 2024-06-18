<?php
    // ตรวจสอบว่ามีการเรียกใช้ session_start() ก่อนหน้านี้หรือไม่
    if (session_status() == PHP_SESSION_NONE) {
        session_start();    
    }
?>

<?php
#default
$data_arr = array();
$out_rdo = array();
$option = isset($_POST['option']) ? $_POST['option'] : "R";

// กำหนดค่าโซนเวลาเป็นกรุงเทพฯ
date_default_timezone_set('Asia/Bangkok');
$current_timestamp = time();  // รับ timestamp ปัจจุบัน

if($option == 'R') {

  # C ส่งข้อมูล request ไปให้ M ประมวลผล
    $data_arr = array(      // input ตัวแปรอาเรย์ที่ส่งเข้าไป in
        "mooc_id" => $mooc_id, 
        "gapHour" => $gapHour,
        "email" => $_SESSION['user_email_address'],
        "evn_id" => $evn_id
    );
  
  // ดึงตาราง schedule ที่เป็นไปได้ทั้งหมด (ทั้งที่ถูกเลือก และยังไม่เลือก) ที่ระบุอีเมล/mooc_id จาก view_transation
    require_once 'api/schedule.php'; // ใช้ require_once แทน require หรือ include
    $arr_json = getSchedule($data_arr);
    $out_rdo = json_decode($arr_json, true);  // output
    $cnt = count((array)$out_rdo); 
    // print_r($out_rdo); //NSK
  
  # C รับข้อมูล response ส่งไปที่ V แยกแสดงผลตามครั้งที่ env_id
    $isBlockBtn = 0;  // รีเซต สำหรับ evn_id ถัดไป
    $isDisabled_arr = array();
                
    foreach ($out_rdo as $item) {
        $evn_id = $item["evn_id"];
        $evn_date = $item["evn_date"];
        $rangeTime = $item["rangeTime"];
        $isBlock = $item["isBlock"];
        $schedule_id = $item["schedule_id"];
        $bucket = $item["bucket"];
        $limited = $item["limited"];
        $tran_id = $item["tran_id"];
        $seat_avai = $item["seat_avai"];
        $timeStart = $item["timeStart"];

        $dis_rdo = "";   
        $chk_rdo = "";
        $icon = "";
        $highlight = "";
        $dis_rdo_full = "";
        $dis_rdo_exp = "";
        $isDisabled = "";

      // ถ้ามีตารางที่เลือกแล้ว ให้ disabled และจัดรูปแบบ 
        if($isBlock == 1){
          $dis_rdo = "disabled";
          $chk_rdo = "checked";
          $icon = "✔️";
          $highlight = 'highlight';
          $isFull = "";

      // ถ้ามีตารางที่ยังไม่เลือก 
        } elseif($isBlock == 0) {

        // และแสดงจำนวนที่ว่าง  
          $isFull = "(".$seat_avai.")"; // (ที่นั่งว่าง)
        // ปิดตัวเลือก ถ้าเกินกำหนด ให้ disabled   
          $expire_timestamp = strtotime($item["evn_date"] . ' ' . $item["timeStart"]);   // แปลงวันที่และเวลาของตารางที่เปิดจองเป็น timestamp
        
          // ถ้ามีตารางเต็มแล้ว ให้ disabled และแสดงข้อความ / ถ้า expire
          if($seat_avai <= 0) {
            $dis_rdo_full = "disabled";
            $isFull = "(เต็ม)";  // (เต็ม)
          } elseif ($current_timestamp > $expire_timestamp) {  // เปรียบเทียบ timestamp ปัจจุบันกับ timestamp ของการตาราง
            $dis_rdo_exp = "disabled";
          }     

        }

        if($dis_rdo == 'disabled' || $dis_rdo_full == 'disabled' || $dis_rdo_exp == 'disabled') {
          $isDisabled = 'disabled'; // นับ radio
        }
        array_push($isDisabled_arr, $isDisabled);

      // display radio
        echo "<div style='text-align: left;'>";
        echo    "<input type='radio' name='schedule_rdo' value=$schedule_id  required ". $chk_rdo ." ". $isDisabled ." > ";     
        echo    "<span class='$highlight'>" .$evn_date . " เวลา " . $rangeTime . "</span> ".$isFull." ". $icon."<br>";   
        echo "</div>";

      // นำ isBlocked 0,1 แต่ละตัวเลือกมาพิจารณารวมกันในขั้นตอนสุดท้ายของ evn_id นั้น, ถ้าเลือกแล้ว -> ปุ่ม $btn ซ่อน ขึ้นปุ่มแก้ไขแทน
        $isBlockBtn = $isBlockBtn + $isBlock;
    } 

    // ถ้า radio ถูกปิดทั้งหมด -> ปุ่ม $btn ก็ปิดใช้งานเลย  
    $count = isset(array_count_values($isDisabled_arr)['']) ? array_count_values($isDisabled_arr)[''] : 0;
    $btn_dis = ($count == 0) ? 'disabled' : "";

}



?>  