<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ตรวจสอบว่ามีค่า 'event_date' และไม่ว่างเปล่า
    if (isset($_POST['schedule_rdo']) && !empty($_POST['schedule_rdo'])) {
        
        header("Content-Type:application/json");	//json ไม่รับค่า session รับ get/post หรือ content เท่านั้น
        include($_SERVER['DOCUMENT_ROOT'] . '/walkin/conn/conndb.php');  

        $out = array();  

        $mooc_id = $_POST['mooc_id'];
        $round = $_POST['round'];
        $schedule_id = $_POST['schedule_rdo'];  // มาจาก include ** schedule_dll.php **
        $email = $_POST['email'];
        $option = $_POST['option'];

        // ก่อนเริ่ม insert/update ให้ตรวจสอบก่อนว่า ตารางที่เลือก มี bucket เทียบกับ limited เต็มหรือยัง
        $sql = "SELECT a.id, b.cnt, (a.limited - IFNULL(b.cnt,0) ) as seat_avai
                FROM walkin_a_schedule a 
                LEFT JOIN walkin_view_time_bucket_update b ON b.schedule_id=a.id
                WHERE a.id = $schedule_id;";
        $result = mysqli_query($conn,$sql) or die("Fail : " .mysqli_error($conn));  
        $cnt = mysqli_num_rows($result);
        
        if($cnt>0) { 
            while($cols=mysqli_fetch_array($result)) {
        
                if($cols['seat_avai'] >= 0) { //ว่าง เพิ่มได้

                    //เพิ่มใหม่
                    if($option == 'C') {    // CREATE            
                        $sql = "INSERT INTO `walkin_transaction`( `mooc_id`, `schedule_id`, `round`, `updatedDate`, `updatedBy`) 
                                VALUES ($mooc_id, $schedule_id, $round, now(), '$email')";
                        $result = mysqli_query($conn,$sql) or die("Fail : " .mysqli_error($conn));  

                        // ดึง ID ของรายการใหม่ที่ถูกเพิ่ม (หากต้องการ)
                        $new_record_id = mysqli_insert_id($conn);

                        // ตัวเก่ารอบเดียวกันยกเลิก, ป้องกันการเบิ้ลเกิน 1 ค่า
                        $sql = "UPDATE `walkin_transaction` 
                                SET active = 'N', revisedDate = now(), revisedBy = '$email'
                                WHERE mooc_id = $mooc_id and round = $round AND id != $new_record_id and active = 'A'";
                        $result = mysqli_query($conn,$sql) or die("Fail : " .mysqli_error($conn));  
                    }
    
                    if($option == 'U') {    // CREATE new T & UPDATE active N   
                        $tran_old = $_POST['tran_old'];
                        $remark = $_POST['remark'];   

                        //เพิ่มใหม่ และ remark ว่าแทน 'replace T'. $tran_old;
                        $sql = "INSERT INTO `walkin_transaction`( `mooc_id`, `schedule_id`, `round`, `updatedDate`, `updatedBy`,remark) 
                                VALUES ($mooc_id, $schedule_id, $round, now(), '$email', CONCAT('replace T', '$tran_old'))";
                        $result = mysqli_query($conn,$sql) or die("Fail : " .mysqli_error($conn));  

                        // ดึง ID ของรายการใหม่ที่ถูกเพิ่ม (หากต้องการ)
                        $new_record_id = mysqli_insert_id($conn);

                        // อัพเดพ ตัวที่แก้ไข id=$tran_old หรือ ยกเลิกตัวเก่ารอบเดียวกัน mooc_id,round,id, A 
                        // remark ป.ควรต่อท้ายอันเดิม ห้ามทับ 
                        $sql = "UPDATE `walkin_transaction` 
                                SET active = 'N', revisedDate = now(), revisedBy = '$email',
                                    remark = CONCAT(ifnull(remark,''), ' | ', '$remark')
                                WHERE mooc_id = $mooc_id and round = $round AND id != $new_record_id and active = 'A'";
                        $result = mysqli_query($conn,$sql) or die("Fail : " .mysqli_error($conn));  
                    }

                    mysqli_close($conn);

                  # OUTPUT
                    echo json_encode(array('status' => 'done', 'message' => 'Transaction Completed'));
                    // exit(); // ออกจาก script เพื่อหยุดการประมวลผลเพิ่มเติม 

                } else {    //เต็ม ออก
                    echo json_encode(array('status' => 'error', 'message' => 'Full Schedule'));
                    // exit();
                }

                // เปลี่ยนเส้นทางไปยังหน้าที่ต้องการ
                header("Location: /walkin/index.php?page=mooc");
                exit();
            }
        }

        mysqli_close($conn);

    } else {
        // ไม่มีรีไดเร็ค ต้องการให้แสดง error
        echo json_encode(array('status' => 'error', 'message' => 'No Change Schedule'));
        exit;    
    }


}
?>