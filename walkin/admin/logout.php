<!-- admin -->
<?php
    // ตรวจสอบว่ามีการเรียกใช้ session_start() ก่อนหน้านี้หรือไม่
    if (session_status() == PHP_SESSION_NONE) {
        session_start();    
    }
?>

<center>    
    <br><br>
    <div class="card" style="width: 25rem;">
        <h5 class="card-header">
            <?php echo $_SESSION['user_profilename']; ?>
        </h5>

        <div class="card-body d-flex justify-content-between">
            <div class='col'>
                <?php echo "<img src='".$_SESSION['user_image']."' style='float: left;'>"; ?>
            </div>
            <div class='col'>
                <?php echo $_SESSION['user_email_address']."<br><br>"; ?>
                <a href="../glogin/logout.php" class="btn btn-info" style='float: right;'>ออกจากระบบ</a>     
                <iframe src="https://accounts.google.com/logout" style="display: none"></iframe>  
            </div>  
        </div>
    </div>
</center>