<?php



    $img = $_POST['image'];
    $img = str_replace('data:image/jpeg;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);

    
     $i = 1000;
     $neuername = basename($_FILES["datei"]["name"]);
     $neuername = preg_replace("/\.(jpeg|gif|png|jpg)$/i", "", $neuername);  
     $neuername = preg_replace("/[^a-zA-Z0-9_-]/", "", $neuername);     
     $neuername = $i.".jpg";
     $ziel = "upload/$neuername";

     while (file_exists($ziel)) {
       $i = $i + 1;
       $neuername = $i.".jpg";
       $ziel = "upload/$neuername";
     }
      if (@move_uploaded_file($_FILES["datei"]["tmp_name"], $ziel)) {
       echo "<script>alert('Dateiupload hat geklappt');</script>";
     } else {
       echo "<script>alert('Dateiupload hat nicht geklappt');</script>";
    }    
    
    
    $success = file_put_contents($neuername, $data);
    print $success ? $neuername : 'Unable to save the file.';
