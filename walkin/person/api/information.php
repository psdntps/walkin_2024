<?php
	ini_set('display_errors', 1); 
	// header("Content-Type:application/json");	//json ไม่รับค่า session รับ get/post หรือ content เท่านั้น

    #default
    $out = array();

    function putInformation($data_arr) {
        #query
        // require_once("/var/www/html/conn/conndb.php");
        include($_SERVER['DOCUMENT_ROOT'] . '/walkin/conn/conndb.php');

        $idStudent = $data_arr['idStudent'];
        $idUser = $data_arr['idUser'];
        $profileName = $data_arr['profileName'];
        $email = $data_arr['email'];
        $success = $data_arr['success'];  // P-update, N-create

        if($success == 'P') {
            // update more info
            $sql = "update walkin_student 
                    set idStudent = '$idStudent', 
                    profileName = '$profileName',
                    email = '$email',
                    verified = 1,
                    lastDate = now() 
                    where id = $idUser";
            $result = mysqli_query($conn,$sql) or die("Fail : " .mysqli_error($conn)); 
            $msg = 'อัพเดทข้อมูลสมาชิก';
            $success_out = "V";
            
        } elseif ($success == 'N') {
            // ลงข้อมูล idStudent แล้วได้ idUser + verified=0 + success= P
            $sql = "";

            // create new user
            $sql = "INSERT INTO `walkin_student`(`idStudent`, `profileName`, `email`,  `updatedDate`, `updatedBy`, verified) 
                    VALUES ('$idStudent','$profileName','$email',now(),'$email', 0)";

            $result = mysqli_query($conn,$sql) or die("Fail : " .mysqli_error($conn)); 

            $msg = 'เพิ่มสมาชิกใหม่';
            $success_out = "P";

            // ดึง ID ของรายการใหม่ที่ถูกเพิ่ม (หากต้องการ $new_record_id)
            $idUser = mysqli_insert_id($conn);

        }

        // ส่งค่าออก  
        $out = array( 
            'status' => 200,
            'message' => $msg,
            'success' => $success_out,
            'idUser' => $idUser,
            'idStudent' => $idStudent
        );

        mysqli_close($conn);

        #output
        return json_encode($out, JSON_UNESCAPED_UNICODE); //แปลง array เป็น json, ภาษาไทย
    }

    function checkInformation($data_arr) {
        #init
        $out = array(
            "check_P" => 0,
            "description" => "", 
            "remark" => ""
        );

        #query
        include($_SERVER['DOCUMENT_ROOT'] . '/walkin/conn/conndb.php');

        $idStudent = $data_arr['idStudent'];

        // check user
        $sql = "SELECT idStudent,description, remark 
                FROM `walkin_mooc` 
                WHERE idStudent='$idStudent'";

        $result = mysqli_query($conn,$sql) or die("Fail : " .mysqli_error($conn)); 
        $cnt = mysqli_num_rows($result);
    
        if($cnt > 0) {  
            // while($row=mysqli_fetch_assoc($result)) {
            //     $out[]=$row;  //เลือกทั้งหมด -> มีได้มากกว่า 1 วิชา   
            // } 
            while($cols=mysqli_fetch_array($result)) {
                $out['idStudent']=$cols['idStudent'];  //เลือกทั้งหมด -> มีได้มากกว่า 1 วิชา   
                $out['description']=$cols['description'];
                $out['remark']=$cols['remark'];
            } 
            mysqli_free_result($result);
            $out["check_P"] = 1;
        }

        mysqli_close($conn);

        // $out = array_push($out, array('success' => 'P', 'msg' => 'ยืนยันข้อมูลจากระบบ');
        $out['success'] = "P";
        $out['msg'] = 'ยืนยันข้อมูลจากระบบ';

        #output
        return json_encode($out, JSON_UNESCAPED_UNICODE); //แปลง array เป็น json, ภาษาไทย
    }

?>