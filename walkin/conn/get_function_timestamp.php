<?php
  ini_set('display_errors', 1); 

  // change format 2023-03-31 => 31-มีนาคม-2566
    function format_date($dueDate) { 
      // Create DateTime object
      $date = new DateTime($dueDate);
      
      // Format date as DD-MM-YYYY
      $dateString = $date->format('d-m-Y');

      // Convert date string to Unix timestamp
      $timestamp = strtotime($dateString);

      // Format timestamp in the desired format
      $newDateString = date('d-m-Y', $timestamp);

      // Convert year to Thai Buddhist calendar
      $year = date('Y', $timestamp) + 543;

      // Replace year in formatted date string
      $newDateString = str_replace(date('Y', $timestamp), $year, $newDateString);

      // Define an array of Thai month names
      $arr_month = array(
        "01" => "มกราคม",
        "02" => "กุมภาพันธ์",
        "03" => "มีนาคม",
        "04" => "เมษายน",
        "05" => "พฤษภาคม",
        "06" => "มิถุนายน",
        "07" => "กรกฏาคม",
        "08" => "สิงหาคม",
        "09" => "กันยายน",
        "10" => "ตุลาคม",
        "11" => "พฤศจิกายน",
        "12" => "ธันวาคม"
      );
      
      // Extract month number from date string
      $month = substr($newDateString, 3, 2);
      
      // Get corresponding Thai month name from array
      $thaiMonth = $arr_month[$month];
      
      // Replace month number with Thai month name in date string
      $newDateString = substr_replace($newDateString, $thaiMonth, 3,2);

      return str_replace('-', ' ',$newDateString);
    }

  // แปลง 'H:i:s' คือ '08:30:00' เป็น 08:30 น.
    function format_time($dueTime) { 
      //แปลง 08:30:00
      $time = strtotime($dueTime);
      $converted_time = date('H:i', $time); // 08:30

      //เป็น 08:30 น.
      $newTimeString = $converted_time." น.";
      
      return $newTimeString;
    }  

  // แปลง 'Y-m-d H:i:s' คือ '2023-03-17 08:30:00' เป็น 31-มีนาคม-2566 เวลา 08:30 น.
    function format_timestamp($timestamp) { 
      //แปลง 2023-03-17 08:30:00
      $time = strtotime($timestamp);
      $converted_time = date('H:i', $time); // 08:30
      $converted_date = date('Y-m-d', $time); // 2023-03-17
      format_date($converted_date);

      //เป็น 31-มีนาคม-2566 เวลา 08:30 น.
      $newTimestamp = format_date($converted_date)." เวลา ".$converted_time." น.";
      
      return $newTimestamp;
    }  

?>