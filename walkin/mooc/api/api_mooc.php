<?php
    ini_set('display_errors', 1); 
	// header("Content-Type:application/json");	//json ไม่รับค่า session รับ get/post หรือ content เท่านั้น

    function getCourse($data_arr) {     //$option == 'R'
    	#default
        $out = array();
    
        #query
        // require_once("/var/www/html/conn/conndb.php");
        $includeCurl = $_SERVER['DOCUMENT_ROOT'] . '/walkin/conn/conndb.php';
        include($includeCurl);  
        //default
        $idStudent = $data_arr['idStudent'];  //ป.เป็นรหัสนิสิตดึงแทน

        //ดึงตารางทั้งหมดที่สามารถเลือกได้ตามรายคน
        $sql = "SELECT a.id as mooc_id, a.subjectCode, b.gapHour, b.rounds
                FROM `walkin_mooc` a 
                LEFT JOIN walkin_subject b ON a.subjectCode=b.subjectCode
                WHERE a.idStudent='$idStudent'
                ORDER BY a.subjectCode";

        $result = mysqli_query($conn,$sql) or die("Fail : " .mysqli_error($conn)); 
        $cnt = mysqli_num_rows($result);
    
        if($cnt > 0) {  
            while($row=mysqli_fetch_assoc($result)) {
                $out[]=$row;  //เลือกทั้งหมด -> มีได้มากกว่า 1 วิชา
            } 
            mysqli_free_result($result);
        }

        mysqli_close($conn);

        #output
        return json_encode($out, JSON_UNESCAPED_UNICODE); //แปลง array เป็น json, ภาษาไทย
    }

    function getTransaction($data_arr) {   //$option == 'T' 
    	#default
        $out = array();
    
        #query
        // require_once("/var/www/html/conn/conndb.php");
        $includeCurl = $_SERVER['DOCUMENT_ROOT'] . '/walkin/conn/conndb.php';
        include($includeCurl);  
        
        //input
        $idStudent = $data_arr['idStudent'];  //ป.เป็นรหัสนิสิตดึงแทน
        $tran_id = $data_arr['tran_id'];

        //ควรใช้ transaction id ควบคู่กับ idStudent เพื่อกันการส่งข้อมูลไปดูของคนอื่น
        $sql = "SELECT moc_id, schedule_id, subjectCode, subjectNameEn, tran_id, evn_id, evn_date, rangeTime,timeStart, gapHour,bucket
                FROM `walkin_view_transaction` 
                WHERE idStudent='$idStudent' and tran_id=$tran_id and active='A';";
        $result = mysqli_query($conn,$sql) or die("Fail : " .mysqli_error($conn)); 
        $cnt = mysqli_num_rows($result);
    
        if($cnt > 0) {  
            while($row=mysqli_fetch_assoc($result)) {
            $out[]=$row;  //เลือกทั้งหมด -> มีได้มากกว่า 1 วิชา
            } 
            mysqli_free_result($result);
        }
        mysqli_close($conn);

        #output
        return json_encode($out, JSON_UNESCAPED_UNICODE); //แปลง array เป็น json, ภาษาไทย       
    }

?>