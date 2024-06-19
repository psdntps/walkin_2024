<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ลงทะเบียนจองรอบ</title>
</head>
<body>
    <br><br>
    <center>
        <h1>coming soon</h1>
    </center>

    <?php
        $conf = $_SERVER['DOCUMENT_ROOT'] . '/conn/conndb.php';
        include_once($conf);    

        $sql = 'SELECT * FROM walkin_role';
        if ($result = $conn->query($sql)) {
            while ($data = $result->fetch_object()) {
                $users[] = $data;
            }
        }
        $conn->close();
    ?>

    <?php
        foreach ($users as $user) {
            echo $user->email;
            echo "<br>";
        }
    ?>

</body>
</html>
