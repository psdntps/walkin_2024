<?php

  //query database
    function query_db($data, $url) {
        #curl
        $curl = curl_init($url); 
        $headers = array('Content-Type: application/json');
        $payload = json_encode($data);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        $json_response = curl_exec($curl);  
        // $status = curl_getinfo($curl, CURLINFO_HTTP_CODE); 
        // if ( $status != 201 ) { 
        //     die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl)); 
        // }
        curl_close($curl);  

        #return output
        $data_out = json_decode($json_response);  //ค่าที่ได้รับออกมา out
        return $data_out;
    }

    //query database for debug
    function query_db_debug($data, $url) {
      #curl
      $curl = curl_init($url); 
      $headers = array('Content-Type: application/json');
      $payload = json_encode($data);
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
      $json_response = curl_exec($curl);  
      $status = curl_getinfo($curl, CURLINFO_HTTP_CODE); 
      if ( $status != 201 ) { 
          die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl)); 
      }
      curl_close($curl);  

      #return output
      $data_out = json_decode($json_response);  //ค่าที่ได้รับออกมา out
      return $data_out;
  }
 
  //url
    if(!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])){
        $uri = 'https://';
    }else{
        $uri = 'http://';
    }
    $uri .= $_SERVER['HTTP_HOST'];  
    // ตัวอย่างการใช้งาน
	// header('Location: '.$uri.'/walkin');
	// exit;

?>