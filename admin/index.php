<!DOCTYPE html>
<html>
<head>
<title>Schützenfest Heiden</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width; initial-scale=1">
<link rel="stylesheet" href="../themes/test.css" />
<link rel="stylesheet" href="../themes/jquery.mobile.structure1.3.2.min.css" /> 
<script src="../js/libs/jquery1.11.0.min.js"></script> 
<script src="../js/libs/jquery.mobile1.3.2.min.js"></script> 
</head>
<body>


<!-- Start of first page -->
<div data-role="page" id="RSS">

    <div data-role="header">
        <h1>RSS Feed erstellen</h1>
    </div><!-- /header -->

    <div data-role="content">
       <form action="../rss_db/generate-feed.php" method="POST" data-ajax="false" >
       <div data-role="fieldcontain">
         <label for="text-basic">Titel:</label><br>
         <input name="title" id="text" value="Titel" type="text"><br><br>
           <label for="text-basic">Aktuelles:</label><br>
         <textarea cols="40" rows="8" name="article" id="textarea-1">Administration</textarea>
       </div>
           <button  type="submit" name="submit" value="submit"  data-theme="b">Speichern</button> 
       </form>

    </div><!-- /content -->

    <div data-role="footer" style="overflow:hidden;" data-position="fixed">
        <h4 style="text-align:center;">Sch&uuml;tzenfest Heiden</h4>
        <div data-role="navbar">
            <ul>
                <li><a href="#RSS">RSS</a></li>
                <li><a href="#bildfreigabe">Bildfreigabe</a></li>
            </ul>
        </div><!-- /navbar -->
    </div><!-- /footer -->
</div><!-- /page -->





<!-- Start of first page -->
<div data-role="page" id="bildfreigabe">

    <div data-role="header">
        <h1>Bildfreigabe</h1>
    </div><!-- /header -->

    <div data-role="content">
       <div data-role="fieldcontain">
 
 <?php
       $pictures = "";
        // Mit den folgenden Zeilen lassen sich
        // alle Dateien in einem Verzeichnis auslesen
        $i = 0;
        $handle=opendir ("../upload/images");
        while ($datei = readdir ($handle)) {
        if (strlen($datei) > 5)
        {
           if(($datei <> "released"))
           {
              $i = $i + 1;
              echo '<form name="form1" action="release_image.php"  method="POST" data-ajax="false">';
              echo '<table>';
              echo '<td>';  
                 echo '<tr><img src="../upload/images/'.$datei.'" width="300px" />';
                 echo '<input type="submit" value="Freigeben"></tr>';
                 echo '<input type="hidden" id="image" name="imagepath" value="../upload/images/"></tr>';
                 echo '<input type="hidden" id="image" name="imagefilename" value="'.$datei.'"></tr>';
              echo '</td>';
              echo '</table>';
              echo '</form>';
           }
         }
        }
        closedir($handle);
        
        if($i == 0)
        {
           $pictures = $pictures.'<img src="http://www.schwitte.de/heiden/images/startseite.jpg" width="300px" />';
        }
 ?>

 
 
 
 
 
       </div>
           <button  type="submit" name="submit" value="submit"  data-theme="b">Speichern</button> 
       </form>

    </div><!-- /content -->

    <div data-role="footer" style="overflow:hidden;" data-position="fixed">
        <h4 style="text-align:center;">Sch&uuml;tzenfest Heiden</h4>
        <div data-role="navbar">
            <ul>
                <li><a href="#RSS">RSS</a></li>
                <li><a href="#bildfreigabe">Bildfreigabe</a></li>
            </ul>
        </div><!-- /navbar -->
    </div><!-- /footer -->
</div><!-- /page -->






</body>
