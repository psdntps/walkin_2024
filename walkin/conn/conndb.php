<?php

    #localhost   
    $hostName = "db"; //localhost
    $user = "esdpsd"; //"root";
    $pass = "m74WzpNE";
    $dbName = "esdpsd"; 

    #connect 
    //@ปิดการแสดงข้อผิดพลาดที่เกิดขึ้นในการเชื่อมต่อ และใช้ or die() เพื่อออกจากโปรแกรมทันทีหากเกิดข้อผิดพลาดขึ้น 
    $conn = @mysqli_connect($hostName, $user, $pass, $dbName) or die("Fail : " . mysqli_error($conn));
    mysqli_query($conn, "SET NAMES UTF8");

    // @ปิดการแสดงข้อผิดพลาดการสั่งคำสั่ง SQL และใช้ or die() เพื่อออกจากโปรแกรมทันทีหากเกิดข้อผิดพลาดขึ้น 
    $sql = "USE " . $dbName; //เพิ่มช่องว่างหลังคำว่า use
    $result = @mysqli_query($conn, $sql) or die("Query failed: " . mysqli_error($conn)); 
    
    //url
    if(!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])){
        $uri = 'https://';
    }else{
        $uri = 'http://';
    }
    $uri .= $_SERVER['HTTP_HOST'];  
    // ตัวอย่างการใช้งาน
    // header('Location: '.$uri.'/walkin');
    // exit;

?>