<?php

    #default
    $data_arr = array();

    #input
    $data_arr = array(      //ตัวแปรอาเรย์ที่ส่งเข้าไป in
        "idStudent" => $idStudent,
        // "option" => $option, //ไม่ได้ใช้
    );

    #url
    include('api/api_mooc.php');
    $arr_json = getCourse($data_arr);
    $out_api = json_decode($arr_json, true);  
 
    // $out_api สามารถมีรายวิชามากกว่า 1 รายการที่ลงทะเบียน mooc_id
?>
