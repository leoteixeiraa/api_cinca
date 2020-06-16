<?php
  
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: PUT, GET, POST");
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
      
    $folderPath = "upload/";
    $postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
      
    $full_img_parts = explode(";base64,", $request->fileSource);
      
    $full_img_type_aux = explode("image/", $full_img_parts[0]);
      
    $full_img_type = $full_img_type_aux[1];
      
    $full_img_base64 = base64_decode($full_img_parts[1]);
      
    $file = $folderPath . uniqid() . '.png';
      
    file_put_contents($file, $full_img_base64);
  
