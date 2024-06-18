<?php
    // ตรวจสอบว่ามีการเรียกใช้ session_start() ก่อนหน้านี้หรือไม่
    if (session_status() == PHP_SESSION_NONE) {
        session_start(); 
    }
?>

<?php      
    #default
    $success = isset($_SESSION['success']) ? $_SESSION['success'] : "";  	
    $email = isset($_SESSION['user_email_address']) ? $_SESSION['user_email_address'] : "";	    
    $idStudent = isset($_SESSION['idStudent']) ? $_SESSION['idStudent'] : "";

    if(isset($_GET['id'])) {

        // กำหนดค่าโซนเวลาเป็นกรุงเทพฯ
        date_default_timezone_set('Asia/Bangkok');
        $current_timestamp = time();    // รับ timestamp ปัจจุบัน

        #input
        $data_arr = array(      //ตัวแปรอาเรย์ที่ส่งเข้าไป in
            "tran_id" => $_GET['id'], 
            "idStudent" => $idStudent,
            "evn_id" => $_GET['r'], //ไม่ได้ใช้ ?
        );
        
        #url
        include('api/api_mooc.php');
        $arr_json = getTransaction($data_arr);
        $out_api = json_decode($arr_json, true); 
        // print_r($data);

        echo "<br><h2>แบบฟอร์ม<br>แจ้งเปลี่ยนรอบสอบ</h2>";
        echo "<div class='container container-login'>";

        foreach ($out_api as $d) {   //มีมากกว่า 1 รายวิชาได้ แต่ summer มีแค่ 1 ??
            echo "<table width = '100%'>";
            // $rounds = $d["evn_id"];   // เวลาแก้ไขจะดึงตารางที่มีตามครั้งที่ลง ไม่ต้องใช้ series $d->rounds; 
            $evn_id = $d["evn_id"];     //ใช้อ้างอิงในการส่งต่อไฟล์อื่น
            $mooc_id = $d["moc_id"];    //ใช้อ้างอิงในการส่งต่อไฟล์อื่น
            $gapHour = $d["gapHour"];   //ใช้อ้างอิงในการส่งต่อไฟล์อื่น

            // button on/off ทั้ง even_id หากเลยกำหนดให้ปิดทั้งหมด
            $dis = "";
            
            # ถ้า วันนี้เกินวันที่จองแล้ว ให้ disabled ทุกกรณี
                // ข้อมูลการจอง      
                $reservation_timestamp = strtotime($d['evn_date'] . ' ' . $d['timeStart']);   // แปลงวันที่และเวลาของการจองเป็น timestamp

                // เปรียบเทียบ timestamp ปัจจุบันกับ timestamp ของการจอง
                if ($current_timestamp > $reservation_timestamp) {  //ข้อมูลที่จองไว้หมดอายุแล้ว
                    $dis = "disabled";
                } 

            # display ตัวเลือกทั้งหมด และ transaction
            if($d["evn_id"] !== NULL) {  //ถ้ามีค่า env_id แล้ว == ลงตารางแล้ว

                echo "<tr><td colspan='2'><div class='alert alert-info'><h2>". $idStudent."</h2></div></td>";
                echo "<tr><td width='30%'>รหัสวิชา </td><td>".$d['subjectCode']."</td></tr>";
                echo "<tr><td valign='top'>ชื่อวิชา </td><td>".$d['subjectNameEn']."</td></tr>";
    
                echo "<tr><td></td><td><br><font color='blue'>ข้อมูลการจองที่เลือก</font></td></tr>";
                echo "<tr><td>ครั้งที่ </td><td>".$d["evn_id"]. "</td></tr>";   
                echo "<tr><td>รอบจอง </td><td><mark>".$d['evn_date']. " ".$d['rangeTime']."</mark></td></tr>";              
                echo "<tr>";
                echo "<td colspan='2'>";
                echo "<hr><p class='text-success'>หากต้องการดำเนินการต่อ ให้ระบุเหตุผลเพื่อออกรหัสคำร้อง</p>";

                echo "<form method='POST' action='index.php?page=transaction' >";
                // echo '<form method="POST" action="mooc/api/transaction.php">'; // ใส่ URL ของหน้าเว็บที่ต้องการส่งข้อมูลไป

                // ขึ้นตัวเลือก rdo เฉพาะ evn_id
                include('schedule_ddl.php'); //ส่ง 
                // print_r($out_rdo); //nsk

                echo "<br>";
                echo "  <input type='text' name='remark' value='' placeholder='โปรดระบุเหตุผลในการขอเปลี่ยน' $dis required>";
                echo "  <input type='hidden' name='tran_old' value=".$d["tran_id"].">";
                // echo "  <input type='hidden' name='schedule_old' value=".$d["schedule_id"].">";
                echo "  <input type='hidden' name='mooc_id' value=".$d['moc_id'].">";
                echo "  <input type='hidden' name='round' value=".$d['evn_id'].">";
                echo "  <input type='hidden' name='email' value=$email>";
                echo "<input type='hidden' name='option' value='U'>";
                echo "  <br><input type='submit' value='บันทึกคำร้อง' class='btn btnVerify' $dis .' '. $btn_dis>";
                echo "</form>";
                echo "<br>";
                echo "<center><mark><a href='./index.php?page=home'>ยกเลิกคำร้อง</a></mark></center>";
            
                echo "</td>";
                echo "</tr>";
            }
            echo "</tr></table>";
        }
        // endforeach;
        echo "</div>";
    } 
?>

<script>
    function goBack() {
        window.history.back();
    }
</script>