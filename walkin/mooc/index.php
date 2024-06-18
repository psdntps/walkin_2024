<?php
    // ตรวจสอบว่ามีการเรียกใช้ session_start() ก่อนหน้านี้หรือไม่
    if (session_status() == PHP_SESSION_NONE) {
      session_start();    
    }
    // ini_set('display_errors', 1);
	  // error_reporting(E_ALL);	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>SweetAlert2 Example</title>
    <!-- ลิงก์ไปยังไลบรารี SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
</head>
<body>
<style>
  .highlight {
    color: red; /* สีแดง */
    font-size: 20px; /* ขนาดใหญ่ขึ้น */
    font-weight: bold; /* ตัวหนา */
  }
</style>

<?php
	#default
	$success = isset($_SESSION['success']) ? $_SESSION['success'] : "";  
	$idStudent = isset($_SESSION['idStudent']) ? $_SESSION['idStudent'] : "";	
  $email = isset($_SESSION['user_email_address']) ? $_SESSION['user_email_address'] : "";	

  if ($success == "V") {  //ผ่าน Verify มาแล้ว

   // ดึงรายวิชาว่าเด็กคนนี้ลงวิชาอะไรบ้าง มีกลุ่ม 1 ชม หรือ 2 ชม
    $option = "R";  //read DB
    include 'mooc.php';
    $cnt = count((array)$out_api);

   // แล้วนำรายวิชาแต่ละตัวไปดึงวนลูปตารางสอบ@ชม. มาแสดง
    echo "<br><h1>รายวิชาพร้อมสอบ</h1>";
      
    if ($cnt == 0) {
      echo "<br><h1>ไม่มีรายวิชาพร้อมสอบ</h1><br>";

    } else {
      // วนลูปแสดงข้อมูลที่จองได้
      // print_r($out_api);  //nsk
      foreach ($out_api as $item) {   //มีมากกว่า 1 รายวิชาได้ แต่ summer มีแค่ 1 ??

        $mooc_id = $item["mooc_id"];
        $gapHour = $item["gapHour"];
        $subjectCode = $item["subjectCode"];

        // เปลี่ยน rounds "1,2" เป็น array(1,2) แล้ววนลูปสร้าง radio หาก isBlock ตรงกับ evn_id ให้ติ๊ก checked
        $rnd_arr = explode(',', $item["rounds"]); // แยกสตริงตามตัวคั่น
        // print_r($rnd_arr); // แสดงผลลัพธ์ nsk 

        echo "<center><div style='width: 400px;'>";
          
          # V นำข้อมูล ส่ง request ไปให้ C สั่ง M คิวรี่ตามต้องการ          
            // สร้าง radio button แยกตาม evn_id   
            for ( $i = 0; $i<count($rnd_arr); $i++ ) {   //มี 1 กลางภาค, 2 สอบไล่

              $evn_id = $rnd_arr[$i];

              echo "<br><h3>".$subjectCode." สอบครั้งที่ : ".($i+1)."</h3>";
              echo '<form method="POST" action="mooc/api/transaction.php">'; // ใส่ URL ของหน้าเว็บที่ต้องการส่งข้อมูลไป
      
                include('schedule_ddl.php');  //** ดึงข้อมูลจาก DB มาสาร้าง radio **        
                // print_r($out_rdo);  //nsk

                // ซ่อนปุ่ม -> ถ้ามีเลือกไปแล้ว (อย่างน้อย 1 ค่า) / แสดงปุ่ม -> ถ้ายังไม่มีการเลือกใด ๆ
                // $btn = ($isBlockBtn > 0) ? "" : "<button type='submit' $btn_dis>บันทึกการจอง</button>";
                $btn = ($isBlockBtn > 0) ? "" : "<input type='submit' class='btn btnSubmit' $btn_dis value='บันทึกการจอง'>";
                // $btn = ($isBlockBtn > 0) ? "" : "<button type='submit' $btn_dis>บันทึกการจอง</button>";
                

                echo    "<input type='hidden' name='mooc_id' value=$mooc_id>";
                echo    "<input type='hidden' name='email' value=$email>";
                echo    "<input type='hidden' name='round' value=$rnd_arr[$i]>";
                echo    "<input type='hidden' name='option' value='C'>";
                echo    "<br>".$btn;
                
                // หาค่า $tran_id ที่ถูกเลือกใน evn_id นั้น
                // ถ้าเลือกแล้ว ให้ edit ได้, ถ้ายังไม่เลือกเลย ให้ขึ้นปุ่ม save สลับกันขึ้น
                foreach ($out_rdo as $element) {
                  if (isset($element['tran_id']) && !empty($element['tran_id'])) {
                    $tran_id = $element['tran_id'];
                  }
                }

                // สลับปุ่มทำงาน [$btn บันทึก / $btnChange แก้ไข]
                $btnChange = ($btn == "") ? "<a href='index.php?page=formChange&id=$tran_id&r=$rnd_arr[$i]'>edit</a>" : "";
                echo "<div class='right'>".$btnChange."</div>";

              echo '</form>';
            
            } //for evn_id
          #
        echo "</div></center>";            
      }
    }
  } //V
?>
</body>
</html>