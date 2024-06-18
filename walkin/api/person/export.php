<?php
// ตรวจสอบว่ามีการเรียกใช้ session_start() ก่อนหน้านี้หรือไม่
if (session_status() == PHP_SESSION_NONE) {
	session_start();    
}

if(isset($_SESSION['role']) == 'admin') {

	// ini_set('display_errors', 1); //แสดง error (ถ้ามี)
    include($_SERVER['DOCUMENT_ROOT'] . '/walkin/conn/conndb.php'); 

	date_default_timezone_set("Asia/Bangkok");
	$today = date('ymdhis',time());	

	$filename = "walkin_".$today.".csv";

	// เปิดไฟล์ CSV สำหรับเขียน
	$fp = fopen('php://output', 'w');

	// เพิ่ม BOM
	fwrite($fp, "\xEF\xBB\xBF");

	$header = array('pname','fname','lname',
				'subjectCode',  
				'subjectNameTh', 
				'subjectNameEn',
				'email', 
				'idStudent',
				'examDate', 
				'rangeTime', 
				'timestamp');
	header('Content-type: application/csv');
	header('Content-Disposition: attachment; filename='.$filename);
	fputcsv($fp, $header);

	$sql = "SELECT  pname,fname,lname,
					subjectCode,  
					subjectName as subjectNameTh, 
					subjectNameEn, 
					email, 
					idStudent,
					evn_date as examDate, 
					rangeTime, 
					updatedDate
					FROM `walkin_view_transaction`
					where remark_student is null 
					order by evn_date, rangeTime, idStudent"; //เริ่มต้น
	$result = mysqli_query($conn,$sql);	
	$cnt = mysqli_num_rows($result);	

	// เรียกข้อมูลจากฐานข้อมูล
	while($row = mysqli_fetch_row($result)) {
		fputcsv($fp, $row);
	}

	// ปิดไฟล์ CSV
	fclose($fp);

	// ออกจากสคริปต์
	exit;

	mysqli_free_result($result);	
	mysqli_close($conn);  

} else {	// ไม่พบสิทธิ์
	// Redirect to index.php
	// header('Location: ../../admin/login.php');
	echo json_encode(array('status' => 'error', 'message' => 'User is not authorized'));
	exit();
}
?>