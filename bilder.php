<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
$sql_details = array(
	"user" => "U1065632",
	"pass" => "321rezepte123",
	"host" => "rdbms.strato.de",
	"db" => "DB1065632"
);
// PDO connection
$db = new PDO(
	"mysql:host={$sql_details['host']};dbname={$sql_details['db']}",
	$sql_details['user'],
	$sql_details['pass'],
	array(
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	)
);


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
      $datum_anzeige = str_replace("Tuesday", "Dienstag", $datum_anzeige);
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
        $tmp_date = str_replace("Feb", ".02.", $tmp_date);
        $tmp_date = str_replace("Jul", ".07.", $tmp_date);
        $tmp_date = str_replace(" .", ".", $tmp_date);
        $tmp_date = str_replace(". ", ".", $tmp_date);
        //$tmp_date = substr($tmp_date, 0, 19);
        $news = $news.'<div data-role="collapsible">
              <h3>'.$row[0].'</h3>
              '.$row[1].'
               </div>';
      }
      $news = $news;
      //echo $news;
      $sth = null;

      
      $pictures = "";
        // Mit den folgenden Zeilen lassen sich
        // alle Dateien in einem Verzeichnis auslesen
        $i = 0;
        $handle=opendir ("upload/images/released");
        while ($datei = readdir ($handle)) {
        if (strlen($datei) > 5)
        {
           $i = $i + 1;
           $pictures = $pictures.'<img src="http://www.schwitte.de/heiden/upload/images/released/'.$datei.'" width="300px" /><br>';
         }
        }
        closedir($handle);
        
if($pictures != "")
{
   $pictures = '<h1>Sch&uuml;tzenfest 2014</h1>'.$pictures.'<hr>';
}
      
if(file_exists('chatbox_block.dat') == 1)
{
   $string = "----------------------------\r\n".date("d.m.Y H:i:s")." - Admin";
   $string .= "\r\nChat wurde durch den Administrator gesperrt.";
   $chat_content = $string;
}
else
{
   $chatfile = fopen("chatbox.txt","r");
   $chatcontent = "";
   while(!feof($chatfile))
   {
      $chatcontent = $chatcontent.fgets($chatfile,1024);
   }
   fclose($chatfile);

   $chat_content = file_get_contents("chatbox.txt");
}

$theName->datum_technisch = $datum_technisch;
$theName->datum_anzeige = $datum_anzeige;
$theName->mytext = utf8_encode($mytext);
$theName->news = utf8_encode($news);
$theName->pictures = $pictures;
$chat_content = $chat_content;
$theName->chat_content = $chat_content;



echo $_GET['callback'] .'('. json_encode($theName) . ')';
       
?>