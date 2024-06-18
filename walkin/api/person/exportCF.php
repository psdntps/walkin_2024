<?php
// ตรวจสอบว่ามีการเรียกใช้ session_start() ก่อนหน้านี้หรือไม่
if (session_status() == PHP_SESSION_NONE) {
	session_start();    
}

if($_SESSION['role'] == 'admin') {
  // นำค่าไปใช้ต่อ
  $msg = "ต้องการ export ข้อมูลทั้งหมด?";
  
  #url
  $url2 = "/walkin/api/person/export";  //NSK

  echo "<br><br><h1 class='text-info'> ... </h1>";

  // ทำการ redirect และปิดหน้าต่าง
  echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>"; // เพิ่ม SweetAlert script

  echo "<script>
          var msg = '$msg'; // นำค่า message ไปเก็บในตัวแปร msg
          if (msg.trim() !== '') { // เช็คว่า msg ไม่ใช่ค่าว่างก่อนแสดง SweetAlert
            Swal.fire({
              icon: 'warning',
              title: 'ข้อมูลการจองสอบ<br>ของผู้มีสิทธิ์สอบ',
              text: msg,
              showCancelButton: true, // แสดงปุ่ม 'ยกเลิก'
              confirmButtonText: 'ยืนยัน',
              cancelButtonText: 'ยกเลิก', // เพิ่มข้อความปุ่ม 'ยกเลิก'
              reverseButtons: true, // กำหนดให้ปุ่ม 'ยืนยัน' อยู่ทางด้านขวา
              allowOutsideClick: false, // ไม่ให้ปิดได้ด้านนอก
              allowEscapeKey: false // ไม่ให้ปิดด้วยการกด ESC
            }).then((result) => {
              if (result.isConfirmed) {
                // ทำการ redirect เมื่อผู้ใช้กด OK
                window.location.href = '/walkin/api/person/export.php';
                window.close(); // ปิดหน้าต่าง
                setTimeout(function() {
                  history.back();
                }, 1000); // รอเวลา 1 วินาที (1000 มิลลิวินาที) ก่อนที่จะทำการ history.back();

              } else if (result.dismiss === Swal.DismissReason.cancel) {
                // หากผู้ใช้กดปุ่ม 'ยกเลิก' ให้กลับไปที่หน้ารายงาน
                // history.back();
                window.location.href = '/walkin/admin/index.php?page=subject';  
                window.close(); // ปิดหน้าต่าง
              }
            });
          } else {
            window.location.href = '$url2'; // ทำการ redirect ถ้าไม่มีข้อความ
            window.close(); // ปิดหน้าต่าง
          }
        </script>";
  }
?>