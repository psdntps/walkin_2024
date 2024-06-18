<?php
    // ตรวจสอบว่ามีการเรียกใช้ session_start() ก่อนหน้านี้หรือไม่
    if (session_status() == PHP_SESSION_NONE) {
        session_start();    
    }
?>
<style>
    .profile-image {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        object-fit: cover;
    } 
</style>

<!-- script สำหรับ nav dropdown -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <!-- เมนูซ้าย  -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php">🏠 หน้าหลัก</a>
                </li>  
                <!-- <li class="nav-item">
                    <a class="nav-link" href="../api/person/export">export</a>
                </li>  -->

                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    รายงาน
                    </a> -->
                    <!-- <div class="dropdown-menu" aria-labelledby="navbarDropdown"> -->
                    <!-- <a class="dropdown-item" href="index.php?page=report">รายชื่อผู้จองสอบ</a> -->
                    <!-- <a class="dropdown-item" href="index.php?page=subject">จำนวนจองสอบแยกตามรายวิชา</a> -->
                    <!-- <a class="dropdown-item" href="index.php?page=person">จำนวนผู้มีสิทธิ์สอบ (Unique)</a> -->
                    <!-- <a class="dropdown-item" href="../api/person/exportCF">ดาวโหลดไฟล์ (ผู้มีสิทธิ์สอบ)</a> -->
                <!-- </li>   -->

            </ul>

            <ul class="navbar-nav ml-auto">
                <!-- เมนูขวา -->
                <li class="nav-item">
                    <?php
                        if (isset($_SESSION['user_image'])) {
                            echo "<a class='nav-link' href='index.php?page=logout'><img src= '".$_SESSION['user_image']."' class='profile-image'></a>";
                        }
                    ?>
                </li>       
            </ul>

        <div>   
    </nav>
</header>
