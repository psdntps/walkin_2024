<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="../style.css" type="text/css" rel="stylesheet" />   

    <!-- google font -->
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@400&display=swap" rel="stylesheet">

    <title>Walkin Exam</title>
</head>
<body>
<?php

    include("nav.php");
    $page = isset($_GET['page']) ? $_GET['page'] : 'home';

    if ($page === 'home') {
        include 'home.php';
    } elseif ($page === 'subject') {
        include 'report_subject.php';            
    } elseif ($page === 'logout') {    
        include 'logout.php';       
    } else {
        echo '<h2>Page Not Found</h2>';
        echo '<p>The requested page was not found.</p>';
    }    

    include("../nav-bottom.php");  
       
?>
   
</body>
</html>