<?php
  // ตรวจสอบว่ามีการเรียกใช้ session_start() ก่อนหน้านี้หรือไม่
  if (session_status() == PHP_SESSION_NONE) {
    session_start();    
  }
  ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Peronal Information</title>
</head>
<body>

<?php 

  #default
  $success = isset($_SESSION['success']) ? $_SESSION['success'] : "";  
  $email = isset($_SESSION['user_email_address']) ? $_SESSION['user_email_address'] : "";
  $profileName = isset($_SESSION['user_profilename']) ? $_SESSION['user_profilename'] : "";
  $idUser = isset($_SESSION['idUser']) ? $_SESSION['idUser'] : ""; 
  $idCard = isset($_SESSION['idCard']) ? $_SESSION['idCard'] : ""; 

  # เช็คว่าเป็นอีเมล @ku.th เท่านั้น 
  if (preg_match('/@ku\.th$/', $email)) {
    // อีเมลถูกต้อง ลงท้ายด้วย @ku.th

    if ($success == "N" &&  $idUser == "") { 
?>
      <br><h2>ลงทะเบียนนิสิต</h2>
      <div class="container container-form">
          <form action="person/person.php" method="post">
            <div class="form-heading">ข้อมูลนิสิต</div>
            <input type="text" class="form-input" name="idStudent" id="idStudent" placeholder="รหัสนิสิต" maxlength="10" pattern="\d{10}" autofocus required>
            <input type="text" class="form-input" name="profileName" value="<?php echo $profileName; ?>" disabled>
            <input type="text" class="form-input" name="email" value=<?php echo $email; ?> disabled>  
            <!-- <input type="tel" class="form-input" name="mobile" id="mobile" placeholder="เบอร์โทรศัพท์" maxlength="10" pattern="\d{10}" autofocus required> --> 
            <br><br>
            <button type="submit" id="submit" name="submit" class="btnSubmit">บันทึก (Save)</button>
          </form>  
      </div>
<?php 
    } 

    if ($success == 'P' &&  $idUser <> "") {  // จะมีรหัส id เกิดขึ้นให้เอาไปตรวจสอบเงื่อนไขที่ต้องการ
      include('person.php');
      $check_P = isset($_SESSION['check_P']) ? $_SESSION['check_P'] : ""; 

      // แปลผล
      if($check_P == 0 && $check_P <> "") {
        echo "<br><br><h1>ไม่ใช่กลุ่มเป้าหมาย/ไม่พบข้อมูลการทดสอบภาษาอังกฤษ<br>";
        echo "โปรดศึกษารายละเอียดที่<a href='https://registrar.ku.ac.th/engprep67'>เว็บไซต์ประชาสัมพันธ์</a></h1>";
        exit();
      } 
      if($check_P == 1) {
        
        #นำค่าไปใช้ต่อ
        $success = $out_api['success'];
        $_SESSION['success'] = $success;
      }
    }
      
    if ($success == 'V') {
      header("Location: index.php?page=mooc");
      // header("Location: ".$uri."/index.php?page=mooc");
      exit();
    }

  } else {
    // อีเมลไม่ถูกต้อง
    echo "<pre>";
    print_r(array('status' => 'error', 'message' => 'กรุณาเข้าระบบด้วย email@ku.th เท่านั้น'));
    echo "</pre>";
    exit;
  }
?>

</body>
</html>