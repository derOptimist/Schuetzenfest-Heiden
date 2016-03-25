<?php

if(isset($_GET['secretkey']) == 0)
{
   echo "Ung&uumlltiger Funktionsaufruf!";
   return;
}

if(isset($_POST['nachricht']) == 0 AND isset($_GET['nachricht']) == 0)
{
   echo "Keine Nachricht angegeben!";
   return;
}

// function sendNotification( $apiKey, $registrationIdsArray, $messageData )
// {
    // $headers = array("Content-Type:" . "application/json", "Authorization:" . "key=" . $apiKey);
    // $data = array(
        // 'data' => $messageData,
        // 'registration_ids' => $registrationIdsArray
    // );
 
    // $ch = curl_init();
 
    // curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
    // curl_setopt( $ch, CURLOPT_URL, "https://android.googleapis.com/gcm/send" );
    // curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
    // curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
    // curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    // curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($data) );
 
    // $response = curl_exec($ch);
    // curl_close($ch);
 
    // return $response;
// }
// if(isset($_POST['nachricht']) == 1)
// {
   // $tmp_message = $_POST['nachricht'];
// }
// else
// {
   // $tmp_message = $_GET['nachricht'];
// }


   // $message = urldecode($tmp_message);
   // $tickerText = urldecode($tmp_message);
   // $contentTitle = urldecode($tmp_message);
   // $contentText = urldecode($tmp_message);
   // $apiKey = "AIzaSyAkdzMs-_w_FclxdRQg4oHXtbJ7LVBeHEA";
   
   // echo 'message:'.$message.'<br>';
   // echo 'tickerText:'.$tickerText.'<br>';
   // echo 'contentTitle:'.$contentTitle.'<br>';
   // echo 'contentText:'.$contentText.'<br>';
   
   // $counter = 1;
   // $registrationId = array();
   // $handle = fopen ("idlist_android.txt", "r");
   // while (!feof($handle)) {
       // $zeile = fgets($handle);
       // $zeile = rtrim($zeile, "\r\n");
       // if($zeile != "")
       // {
         // $registrationId[] = $zeile;
         
            // $counter = $counter + 1;
         

        // }
   // }
   // fclose ($handle);
// json_encode($registrationId);
   
         // // $registrationId = 'APA91bF988k3DzxzI8N9C3k29iYCEKS1CB_6izZA2LkjEPTE-f3eAFhpavrfQM_CZxv52md1JX_9riPhdyKW5hENk6AIvvSGrMZ1o6QbJPdW8FfaA3JIscorW4YMvt8jbOqBTEzhmV-Vt_-i4MFLtRi7t_12CBDjcg';
            // $response = sendNotification(
                            // $apiKey,
                            // array('registrationId' => $registrationId),
                            // array('message' => $message, 'tickerText' => $tickerText, 'contentTitle' => $contentTitle, "contentText" => $contentText) );
             

            // if (strpos($response,',"failure":1,"') !== false) {
               // file_put_contents("idlist_android_failed.txt", $registrationId, FILE_APPEND);
            // }
            // echo $counter.' - '.$response;

            // echo '<br>';
   
// 

echo "Start<br>";

if(isset($_POST['nachricht']) == 1)
{
   $tmp_message = $_POST['nachricht'];
}
else
{
   $tmp_message = $_GET['nachricht'];
}


$regId=YOUR_REGISTRATION_ID;
$message = array("message" => $tmp_message);
$apiKey = "AIzaSyAkdzMs-_w_FclxdRQg4oHXtbJ7LVBeHEA";

// Api Keys für Tablet-Bad und Bluestacks
// $regArray[]='APA91bFMNJqCosLdc3UEtZnLJ19ioeMl-3wjhnjafbrm8plNd8tU5cESp8DkXHpbbA87jhncaug_9v1_gzCCM6lXfXHpyJD8ac5Fv42j-HoQ2EV4tfTg3otFqNxCnSONh0gL1iS4O4XSRtLQH_KmU7Dn2OAOHhPeNw';
// $regArray[]='APA91bGeWD0M1dR377Y4TUtkIIWOfY7AAeS5QYbtPswGt5jA7pYjE-5RrQR4ZjjFeZOKjKIfvBYzmECX1LOp2jfcoejKcfD9tYzqsaU3vLVIXSP1q9kHMySHJ7-KDP34Y9AdZstQugJa7VcJmf0NSuxZp85DboWTUu2dg2k8KA7OFrNJlKAgr7I';

// echo "Start Nachricht1:";
// echo $tmp_message;
// echo "<br>";

// $registrationId = array();
// $handle = fopen ("idlist_android2.txt", "r");
// // $handle = fopen ("idlist_android.txt_tablet_bluestacks", "r");
// while (!feof($handle)) {
   // $zeile = fgets($handle);
   // $zeile = rtrim($zeile, "\r\n");
   // if($zeile != "")
   // {
      // echo $zeile;
      // $regArray[] = $zeile;
   // }
// }
// fclose ($handle);


// $url = 'https://android.googleapis.com/gcm/send';

// $fields = array('registration_ids' => $regArray, 'data' => $message,);
// $headers = array( 'Authorization: key=AIzaSyAkdzMs-_w_FclxdRQg4oHXtbJ7LVBeHEA','Content-Type: application/json');

// $ch = curl_init();

// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

// $result=curl_exec($ch);
// echo $result; 
// if($result==FALSE)
// {
    // die('Curl Failed');
// }
// curl_close($ch);


// echo "<br>Ende Nachricht1<br>";


// echo "Start Nachricht2:";
// echo $tmp_message;
// echo "<br>";

// $registrationId = array();
// $handle = fopen ("idlist_android.txt", "r");
// // $handle = fopen ("idlist_android.txt_tablet_bluestacks", "r");
// while (!feof($handle)) {
   // $zeile = fgets($handle);
   // $zeile = rtrim($zeile, "\r\n");
   // if($zeile != "")
   // {
      // echo $zeile;
      // $regArray[] = $zeile;
   // }
// }
// fclose ($handle);


// $url = 'https://android.googleapis.com/gcm/send';

// $fields = array('registration_ids' => $regArray, 'data' => $message,);
// $headers = array( 'Authorization: key=AIzaSyAkdzMs-_w_FclxdRQg4oHXtbJ7LVBeHEA','Content-Type: application/json');

// $ch = curl_init();

// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_POST, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
// curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

// $result=curl_exec($ch);
// echo $result; 
// if($result==FALSE)
// {
    // die('Curl Failed');
// }
// curl_close($ch);


// echo "<br>Ende Nachricht2<br>";



echo "Start TestNachricht:";
echo $tmp_message;
echo "<br>";

$registrationId = array();
$handle = fopen ("idlist_android.txt_heute", "r");
// $handle = fopen ("idlist_android.txt_tablet_bluestacks", "r");
while (!feof($handle)) {
   $zeile = fgets($handle);
   $zeile = rtrim($zeile, "\r\n");
   if($zeile != "")
   {
      echo $zeile;
      $regArray[] = $zeile;
   }
}
fclose ($handle);


$url = 'https://android.googleapis.com/gcm/send';

$fields = array('registration_ids' => $regArray, 'data' => $message,);
$headers = array( 'Authorization: key=AIzaSyAkdzMs-_w_FclxdRQg4oHXtbJ7LVBeHEA','Content-Type: application/json');

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

$result=curl_exec($ch);
echo $result; 
if($result==FALSE)
{
    die('Curl Failed');
}
curl_close($ch);


echo "<br>Ende TestNachricht<br>";

// echo '<script>alert("Pushnachricht versendet");window.location.href = "http://schwitte.de/heiden/admin/?secretkey=21";</script> ';
?>
