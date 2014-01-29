<?php



include('mydb.php');

if(!empty($_POST['function'])){
   if($_POST['function'] == 'start')
   {
      $sql = "SELECT DATE_FORMAT(datum,'%b %d, %Y %H:%i:%S') as datum_technisch, DATE_FORMAT( datum,'am %W, den %d. %M %Y %H:%i') as datum_anzeige, mytext as mytext 
      FROM `sch_termine` 
      WHERE datum = ( 
      SELECT min( datum ) 
      FROM `sch_termine` 
      WHERE datum > now()) ";

      $sth = $db->prepare($sql);
      $sth->execute();
      $result = $sth->fetch(PDO::FETCH_OBJ);
      $datum_technisch = $result->datum_technisch;
      $datum_anzeige = $result->datum_anzeige;
      $datum_anzeige = str_replace("Monday", "Montag", $datum_anzeige);
      $datum_anzeige = str_replace("Tuesday", "Dienst", $datum_anzeige);
      $datum_anzeige = str_replace("Wednesday", "Mittwoch", $datum_anzeige);
      $datum_anzeige = str_replace("Thursday", "Donnerstag", $datum_anzeige);
      $datum_anzeige = str_replace("Friday", "Freitag", $datum_anzeige);
      $datum_anzeige = str_replace("Saturday", "Samstag", $datum_anzeige);
      $datum_anzeige = str_replace("Sunday", "Sonntag", $datum_anzeige);
      $mytext = $result->mytext;
   
      $sql = "SELECT `title`, `article`, timestamp as timestamp FROM `rss` order by `myindex` desc"; 
      $sth = $db->prepare($sql);
      $sth->execute();
      
      $news = "";
      
      while ($row = $sth->fetch(PDO::FETCH_NUM, PDO::FETCH_ORI_NEXT)) {
        $tmp_date = str_replace(" GMT", "", $row[2]);
        $tmp_date = str_replace("Mon,", "", $tmp_date);
        $tmp_date = str_replace("Tue,", "", $tmp_date);
        $tmp_date = str_replace("Wed,", "", $tmp_date);
        $tmp_date = str_replace("Thu,", "", $tmp_date);
        $tmp_date = str_replace("Fri,", "", $tmp_date);
        $tmp_date = str_replace("Sat,", "", $tmp_date);
        $tmp_date = str_replace("Sun,", "", $tmp_date);
        $tmp_date = str_replace("Aug", ".08.", $tmp_date);
        $tmp_date = str_replace("Jul", ".07.", $tmp_date);
        $tmp_date = str_replace(" .", ".", $tmp_date);
        $tmp_date = str_replace(". ", ".", $tmp_date);
        $tmp_date = substr($tmp_date, 0, 17);
        $news = $news.'<div data-role="collapsible">
              <h3>'.$tmp_date.' - '.$row[0].'</h3>
              '.$row[1].'
               </div>';
      }
      $news = $news;
      $sth = null;

      
      $pictures = "";
        // Mit den folgenden Zeilen lassen sich
        // alle Dateien in einem Verzeichnis auslesen
        $i = 0;
        $handle=opendir ("admin/upload/public");
        while ($datei = readdir ($handle)) {
        if (strlen($datei) > 5)
        {
           $i = $i + 1;
         $pictures = $pictures.'<img src="admin/upload/'.$datei.'" width="300px" /><br>';
         }
        }
        closedir($handle);
        
        if($i == 0)
        {
           $pictures = $pictures.'<img src="images/startseite.jpg" width="300px" />';
        }
      
      
      
       $ret = Array("datum_technisch" => $datum_technisch, "datum_anzeige" => $datum_anzeige, "mytext" => $mytext, "news" => $news, "pictures" => $pictures );
       echo json_encode($ret);
   }
   

} 