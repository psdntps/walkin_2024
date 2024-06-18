<?php
    // ตรวจสอบว่ามีการเรียกใช้ session_start() ก่อนหน้านี้หรือไม่
    if (session_status() == PHP_SESSION_NONE) {
      session_start();    
    }
    // error_reporting(E_ALL & ~E_NOTICE);
?>
<style>
    td {
        padding-right: 5px;
    }
    th {
        padding-right: 5px;
    }
	.custom-button {
		width: 100px; /* กำหนดความกว้างให้ปุ่ม */
		display: inline-block; /* จัดเรียงปุ่มตามแนวนอน */
		background-color: #000; /* กำหนดสีพื้น */
		color: #fff; /* กำหนดสีตัวอักษร */
		border: 1px solid #ccc; /* กำหนดขอบ border */
	}
</style>
<?php
    $role = isset($_SESSION['role']) ? $_SESSION['role'] : "";
	if($role == 'admin') {

		ini_set('display_errors', 1);	  
        include('../conn/conndb.php');

		$e = isset($_POST['e']) ? $_POST['e'] : "";
		$e_txt = array(
                		"1"=>"พฤษภาคม",
						"2"=>"มิถุนายน",
						""=>"รวม"
					);

        // สร้าง array เพื่อเก็บข้อมูล pivot table
        $pivotTable = array();
        $out = array();
        $sum00 = $sum01 = $sum10 = $sum11 = $sum20 = $sum21 = 0;
        $ttl = 0;

		// echo "<form method='post' action='index.php?page=subject'>";
		// 	foreach( $e_txt as $key => $value){
		// 		if(!empty($key)) {
		// 			echo " <button type='submit' name='e' value='$key' class='custom-button'>$value</button> ";
		// 		}
		// 	}
		// echo "</form>";

		$cond = "";
		if($e !== "") {
			$cond = "and evn_id = $e";
		}

		$sql = "SELECT subjectCode,subjectNameEn, evn_id,evn_date,rangeTime,isReserved,count(*) as cnt
                FROM `walkin_view_transaction` 
                WHERE remark_student is null $cond
                group by subjectCode,subjectNameEn, evn_id,evn_date,rangeTime,isReserved
                ORDER by subjectCode, evn_id,evn_date,rangeTime,isReserved;";
		$result = mysqli_query($conn,$sql);	
		$cnt = mysqli_num_rows($result);
		$i = 1;
        //evn_id is not null and 

		if($cnt > 0) { 

			while($cols = mysqli_fetch_array($result)) {

				$evn_d = is_null($cols['evn_date']) ? $cols['evn_id'] : $cols['evn_date'];
				$evn_id = $cols['evn_id'];
				$site = ($cols['isReserved']==1) ? "ออนไซต์" : "<font color='red'>ออนไลน์</font>";
                $count = $cols['cnt'];

                // สร้าง key ของ pivot table
                $key = $cols['subjectCode'] . '|' . $evn_d;

                // เพิ่มข้อมูลลงใน pivot table
                if (!isset($pivotTable[$key])) {
                    $pivotTable[$key] = array(
                        'evn_id' => $cols['evn_id'],
                        'CourseCode' => $cols['subjectCode'],
                        'CourseName' => $cols['subjectNameEn'],
                        'Date' => $evn_d,
                        'คาบเช้า' => array('ออนไลน์' => 0, 'ออนไซต์' => 0),
                        // 'คาบบ่าย' => array('ออนไลน์' => 0, 'ออนไซต์' => 0),
                        // 'เช้าบ่าย' => array('ออนไลน์' => 0, 'ออนไซต์' => 0),
                        'รวม' => 0
                    );
                }  

                // เพิ่มจำนวนของแต่ละวิธีสอบในแต่ละช่วงเวลา
                if ($cols['rangeTime'] == '10.00-12.00') {
                    if($cols['isReserved']==0) {
                        $pivotTable[$key]['คาบเช้า']['ออนไลน์'] += $count;
                        $sum00 = $sum00 + $count;
                    } elseif ($cols['isReserved']==1) {
                        $pivotTable[$key]['คาบเช้า']['ออนไซต์'] += $count;
                        $sum01 = $sum01 + $count;
                    }              

                // } elseif ($cols['rangeTime'] == '12.30-16.30') {
                //     if($cols['isReserved']==0) {
                //         $pivotTable[$key]['คาบบ่าย']['ออนไลน์'] += $count;
                //         $sum10 = $sum10 + $count;
                //     } elseif ($cols['isReserved']==1) {
                //         $pivotTable[$key]['คาบบ่าย']['ออนไซต์'] += $count;
                //         $sum11 = $sum11 + $count;
                //     }

                // } elseif ($cols['rangeTime'] == '08.30-15.30') {
                //     if($cols['isReserved']==0) {
                //         $pivotTable[$key]['เช้าบ่าย']['ออนไลน์'] += $count;
                //         $sum20 = $sum20 + $count;
                //     } elseif ($cols['isReserved']==1) {
                //         $pivotTable[$key]['เช้าบ่าย']['ออนไซต์'] += $count;
                //         $sum21 = $sum21 + $count;
                //     } 

                }
                $pivotTable[$key]['รวม'] += $count;
                $ttl += $count;
                
			}	

			mysqli_free_result($result);	
		}
		mysqli_close($conn);     

        // แสดงผล pivot table
        // echo "<h1>ดำเนินการจองแล้ว ".$e_txt[$e].": ".($sum00+$sum01+$sum10+$sum11+$sum20+$sum21)."</h1>";
        // echo "<h1>จำนวนการจองรอบสอบในระบบ </h1>";
        ?>
        <div style="display: flex; justify-content: center; align-items: center;">
        <div><h1>จำนวนการจองรอบสอบในระบบ &nbsp; </h1></div>
        <div><a href="../api/person/exportCF"> <img src="../glogin/assets/export_icon.png" style="height: 50px;" title="คลิกเพื่อ export ข้อมูลทั้งหมด" ></a></div>
        </div>
        <br>
        <?php
        // echo "<center><table border='1'>";
        // echo "<tr><th rowspan='2'>ครั้งที่</th><th rowspan='2'>รหัสวิชา</th><th rowspan='2'>ชื่อวิชาภาษาอังกฤษ</th><th rowspan='2'>วันที่เลือก</th><th colspan='2'>10.00 - 12.00</th><th rowspan='2' style='text-align: center;'>จำนวนรวม</th></tr>";
        // echo "<tr><th style='text-align: center;'>ออนไลน์</th><th style='text-align: center;'>ออนไซต์</th></tr>";
        // foreach ($pivotTable as $pivotRow) {
        //     echo "<tr>";
        //     echo "<td>{$pivotRow['evn_id']}</td>";
        //     echo "<td>{$pivotRow['CourseCode']}</td>";
        //     echo "<td>{$pivotRow['CourseName']}</td>";
        //     echo "<td>{$pivotRow['Date']}</td>";
        //     echo "<td style='text-align: center;'>{$pivotRow['คาบเช้า']['ออนไลน์']}</td>";
        //     echo "<td style='text-align: center;'>{$pivotRow['คาบเช้า']['ออนไซต์']}</td>";
        //     echo "<td style='text-align: center;'>{$pivotRow['รวม']}</td>"; 
        //     echo "</tr>";
        // }
        // echo "<tr><th colspan='3'></th><th  style='text-align: center;'>$sum00</th><th  style='text-align: center;'>$sum01</th><th  style='text-align: center;'>$ttl</th></tr>";
        
        // echo "</table></center>";

        echo "<center><table border='1'>";
        echo "<tr bgcolor='#ACE1AF'><th rowspan='2'>ครั้งที่</th><th rowspan='2'>รหัสวิชา</th><th rowspan='2'>ชื่อวิชาภาษาอังกฤษ</th><th rowspan='2'>วันที่เลือก</th><th colspan='2' style='text-align: center; padding: 5px;'>10.00 - 12.00</th><th rowspan='2' style='text-align: center;'>จำนวนรวม</th></tr>";
        echo "<tr bgcolor='#ACE1AF'><th style='text-align: center;'>ออนไลน์</th><th style='text-align: center;'>ออนไซต์</th></tr>";
        
        $currentEvnId = null;
        $evnData = [];
        
        foreach ($pivotTable as $pivotRow) {
            $evnId = $pivotRow['evn_id'];
            $evnId = is_null($evnId) ? "" : $evnId;
        
            if ($currentEvnId !== $evnId) {
                if ($currentEvnId !== null) {
                    // Render previous group data
                    echo "<tr bgcolor='#E0FBE2'><th colspan='4'></th><th style='text-align: center;'>{$evnData['คาบเช้า']['ออนไลน์']}</th><th style='text-align: center;'>{$evnData['คาบเช้า']['ออนไซต์']}</th><th style='text-align: center;'>{$evnData['รวม']}</th></tr>";
                }
        
                // Initialize new group data
                $evnData = [
                    'คาบเช้า' => [
                        'ออนไลน์' => 0,
                        'ออนไซต์' => 0
                    ],
                    'รวม' => 0
                ];
        
                $currentEvnId = $evnId;
            }
        
            // Accumulate values for the current group
            $evnData['คาบเช้า']['ออนไลน์'] += $pivotRow['คาบเช้า']['ออนไลน์'];
            $evnData['คาบเช้า']['ออนไซต์'] += $pivotRow['คาบเช้า']['ออนไซต์'];
            $evnData['รวม'] += $pivotRow['รวม'];
        
            // Render row for the current group
            echo "<tr>";
            echo "<td style='text-align: center;'>{$pivotRow['evn_id']}</td>";
            echo "<td>{$pivotRow['CourseCode']}</td>";
            echo "<td>{$pivotRow['CourseName']}</td>";
            echo "<td>{$pivotRow['Date']}</td>";
            echo "<td style='text-align: center;'>{$pivotRow['คาบเช้า']['ออนไลน์']}</td>";
            echo "<td style='text-align: center;'>{$pivotRow['คาบเช้า']['ออนไซต์']}</td>";
            echo "<td style='text-align: center;'>{$pivotRow['รวม']}</td>";
            echo "</tr>";
        }
        
        // Render the last group data
        if ($currentEvnId !== null) {
            echo "<tr bgcolor='#E0FBE2'><th colspan='4'></th><th style='text-align: center;'>{$evnData['คาบเช้า']['ออนไลน์']}</th><th style='text-align: center;'>{$evnData['คาบเช้า']['ออนไซต์']}</th><th style='text-align: center;'>{$evnData['รวม']}</th></tr>";
        }
        
        // echo "<tr><th colspan='3'></th><th style='text-align: center;'>$sum00</th><th style='text-align: center;'>$sum01</th><th style='text-align: center;'>$ttl</th></tr>";
        
        echo "</table>";  
        
        echo "</center>"; 



        echo "<p style='color: green;'>พิมพ์เมื่อ : " . date("Y-m-d H:i:s")."</p>";

	} else {
		// ไม่พบสิทธิ์
		header('Location: login.php');
		exit();
	}
?>
</body>
</html>