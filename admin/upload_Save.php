<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title>Bild-Upload</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        
         <!-- STYLESHEET jQUERY -->
         <link rel="stylesheet" href="../themes/test.min.css" />
         <link rel="stylesheet" href="../themes/jquery.mobile.structure-1.3.1.min.css" /> 
            
                
<script src="../js/libs/jquery.min.js"></script> 
<script src="../js/libs/jquery.mobile-1.3.1.min.js"></script> 
            
    </head>
    
    <body>
        
<!-- PAGE BEGIN -->        
        <div data-role="page">                    
        
    <!-- HEAD -->
           
                <h1>Bild-upload</h1>
          
        
        
    <!-- CONTENT -->
            <div data-role="content">
            
                <form action="<?php echo htmlentities($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data" data-ajax="false">
Datei: <br />
<input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
<input type="file" name="datei" /><br />
<input type="submit" value="Hochladen" />
</form>

<?php
if (isset($_FILES["datei"]) AND ! $_FILES["datei"]["error"]  AND  ($_FILES["datei"]["size"] < 30000000 )) {
    $bildinfo = getimagesize($_FILES["datei"]["tmp_name"]);
    if ($bildinfo === false) {
      die("kein Bild");
    } else {
      $mime = $bildinfo["mime"];
      $mimetypen = array (
        "image/jpeg" => "jpg",
        "image/gif" => "gif",
        "image/png" => "png"
    );
     // if (!isset($mimetypen[$mime])) {
       // die("nicht das richtige Format");
     // } else {
       $endung = $mimetypen[$mime];
     // }
     $i = 0;
     $neuername = basename($_FILES["datei"]["name"]);
     $neuername = preg_replace("/\.(jpeg|gif|png|jpg)$/i", "", $neuername);  
     $neuername = preg_replace("/[^a-zA-Z0-9_-]/", "", $neuername);     
     $neuername = $i.$neuername.".$endung";
     $ziel = "upload/$neuername";

     while (file_exists($ziel)) {
       $i = $i + 1;
       $neuername = $i."$neuername";
       $ziel = "upload/$neuername";
     }
      if (@move_uploaded_file($_FILES["datei"]["tmp_name"], $ziel)) {
       echo "<script>alert('Dateiupload hat geklappt');</script>";
     } else {
       echo "<script>alert('Dateiupload hat nicht geklappt');</script>";
    }
  }
}
?>

            
            </div>
            
            
    <!-- FOOTER -->
    <div data-role="footer" style="overflow:hidden;" data-position="fixed">
        <h4 style="text-align:center;">Sch&uuml;tzenfest Heiden</h4>
        <div data-role="navbar">
            <ul>
                <li><a href="index.php" id="index" target="_self">RSS-Feed</a></li>
                <li><a href="upload.php" id="upload" data-icon="custom" target="_self">Bild-Upload</a></li>
            </ul>
        </div><!-- /navbar -->
    </div><!-- /footer -->
            
            
<!-- PAGE ENDE -->
        
    </body>
    
</html>
