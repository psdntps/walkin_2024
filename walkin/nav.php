<!-- user -->
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

    #sidebar {
        background-color: #111;
        color: white;
        height: 100vh;
        width: 0;
        position: fixed;
        overflow-x: hidden;
        transition: 0.5s;
    }

    #sidebar ul {
        padding: 0;
        list-style: none;
    }

    #sidebar li {
        padding: 15px;
    }

    #sidebar a {
        text-decoration: none;
        color: white;
    }
</style>

<header>
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <div class="navbar-toggler collapsed border-0 ml-auto" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
            <?php
                if (isset($_SESSION['user_image'])) {
                    echo "<a class='nav-link' href='index.php?page=logout'><span class='navbar-toggler-icon'></span></a>";
                }
            ?>
        </div>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav">
                <!-- เมนูซ้าย -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php">🏠 หน้าหลัก</a>
                </li>

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