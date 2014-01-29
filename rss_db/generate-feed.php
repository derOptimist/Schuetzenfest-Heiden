<?php
include('mysql-connect.php');

if(isset($_POST['title']))
{


//rss manuell
$information = $_POST['title']." - ".$_POST['article'];
$datei_handle=fopen("../aktuelles.txt",w);
fwrite($datei_handle,$information);
fclose($datei_handle);

	$timestamp = date("D, j M Y H:i:s ", time());
	$link = 'www.schwitte.de';

    if (mysqli_connect_errno()) {
    die ('Konnte keine Verbindung zur Datenbank aufbauen: '.mysqli_connect_error().'('.mysqli_connect_errno().')');
    }
    $sql = "INSERT INTO `rss` (`timestamp`, `title`, `article`, `link`) 
    VALUES (
    '".$timestamp."','".$_POST['title']."','".$_POST['article']."','".$link."'
    );";

    $result = mysql_query($sql, $connection);
}




// XML-Datei automatisch erstellen
$xml = new DOMDocument('1.0', 'utf-8');
$xml->formatOutput = true;
     
$rss = $xml->createElement('rss');
$rss->setAttribute('version', '2.0');
$xml->appendChild($rss);
     
$channel = $xml->createElement('channel');
$rss->appendChild($channel);
 
// Head des Feeds   
$head = $xml->createElement('title', 'Schuetzenfest Heiden 2013');
$channel->appendChild($head);
     
$head = $xml->createElement('description', 'Alle Neuigkeiten zum Schuetzenfest 2013');
$channel->appendChild($head);
     
$head = $xml->createElement('language', 'de');
$channel->appendChild($head);
     
$head = $xml->createElement('link', 'http://localhost/_Heiden');
$channel->appendChild($head);
    
// Aktuelle Zeit, falls time() in MESZ ist, muss 1 Stunde abgezogen werden
$head = $xml->createElement('lastBuildDate', date("D, j M Y H:i:s ", time()).' GMT');
$channel->appendChild($head);
     
// Feed Einträge

$result = mysql_query('SELECT timestamp, title, article, link FROM rss ORDER BY timestamp DESC', $connection);
while ($rssdata = mysql_fetch_array($result))
{  
    $item = $xml->createElement('item');
    $channel->appendChild($item);
         
    $data = $xml->createElement('title', utf8_encode($rssdata["title"]));
    $item->appendChild($data);
     
    $data = $xml->createElement('description', utf8_encode($rssdata["article"]));
    $item->appendChild($data);  
         
    $data = $xml->createElement('link', $rssdata["link"]);
    $item->appendChild($data);
     
    $data = $xml->createElement('pubDate', date("D, j M Y H:i:s ", strtotime($rssdata["timestamp"]).' GMT'));
    $item->appendChild($data);
     
    $data = $xml->createElement('guid', $rssdata["link"]);
    $item->appendChild($data);
}
include('mysql-close.php');
   
// Speichere XML Datei
$xml->save('rss_feed.xml');
 
// Zurück zur vorheringen Seite
echo '<script language ="JavaScript">';
echo 'alert("Daten wurden gespeichert");';
echo 'window.location.replace("http://'.$_SERVER['HTTP_HOST'].'/_Heiden/admin/index.php");';
echo '</script>';
 


?>
