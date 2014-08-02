<?php

if(isset($_GET['secretkey']) == 0)
{
   echo "Ung&uumlltiger Funktionsaufruf!";
   return;
}


function sendNotification( $apiKey, $registrationIdsArray, $messageData )
{
    $headers = array("Content-Type:" . "application/json", "Authorization:" . "key=" . $apiKey);
    $data = array(
        'data' => $messageData,
        'registration_ids' => $registrationIdsArray
    );
 
    $ch = curl_init();
 
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt( $ch, CURLOPT_URL, "https://android.googleapis.com/gcm/send" );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($data) );
 
    $response = curl_exec($ch);
    curl_close($ch);
 
    return $response;
}







if(isset($_REQUEST['message']) AND !isset($_REQUEST['auto'])) {

   if(isset($_REQUEST['message']))
   $message = urldecode($_REQUEST['message']);
   else
   $message = "the test message";

   if(isset($_REQUEST['ticket_text']))
   $tickerText = urldecode($_REQUEST['ticket_text']);
   else
   $tickerText = "ticker text message";

   if(isset($_REQUEST['content_title']))
   $contentTitle = urldecode($_REQUEST['content_title']);
   else
   $contentTitle = "content title";


   if(isset($_REQUEST['content_text']))
   $contentText = urldecode($_REQUEST['content_text']);
   else
   $contentText = "content body";


   if(isset($_REQUEST['registration_id']))
   $registrationId = urldecode($_REQUEST['registration_id']);
   $apiKey = "AIzaSyAkdzMs-_w_FclxdRQg4oHXtbJ7LVBeHEA";

   $response = sendNotification(
                   $apiKey,
                   array($registrationId),
                   array('message' => $message, 'tickerText' => $tickerText, 'contentTitle' => $contentTitle, "contentText" => $contentText) );
    
   echo $response;
   echo '<br>';

}




if(isset($_GET['message']) AND isset($_GET['ticket_text']) AND isset($_GET['content_title']) AND isset($_GET['content_text'])) 
{
   $message = urldecode($_GET['message']);
   $tickerText = urldecode($_GET['ticket_text']);
   $contentTitle = urldecode($_GET['content_title']);
   $contentText = urldecode($_GET['content_text']);
   $apiKey = "AIzaSyAkdzMs-_w_FclxdRQg4oHXtbJ7LVBeHEA";
   // $registrationId = "APA91bF988k3DzxzI8N9C3k29iYCEKS1CB_6izZA2LkjEPTE-f3eAFhpavrfQM_CZxv52md1JX_9riPhdyKW5hENk6AIvvSGrMZ1o6QbJPdW8FfaA3JIscorW4YMvt8jbOqBTEzhmV-Vt_-i4MFLtRi7t_12CBDjcg";
   
   // $zeilen = file ('idlist_android.txt');
    
   // foreach ($zeilen as $zeile) {
       // //echo $zeile;
      // $registrationId = $zeile;
      // if($registrationId != "")
      // {
         // $response = sendNotification(
                         // $apiKey,
                         // array($registrationId),
                         // array('message' => $message, 'tickerText' => $tickerText, 'contentTitle' => $contentTitle, "contentText" => $contentText) );
          
         // echo $response;
         // echo '<br>';
      // }
       
   // }
   
   
$handle = fopen ("idlist_android.txt", "r");
while (!feof($handle)) {
    $zeile = fgets($handle);
    $zeile = rtrim($zeile, "\r\n");
    if($zeile != "")
    {
      $registrationId = $zeile;
         $response = sendNotification(
                         $apiKey,
                         array($registrationId),
                         array('message' => $message, 'tickerText' => $tickerText, 'contentTitle' => $contentTitle, "contentText" => $contentText) );
          
         echo $response;
         echo '<br>';
     }
}
fclose ($handle);
   

}



?>
<h1>Sample Google GCM Testing Application</h1>
<form method='post'>
Message:
<input type="text" name="message" value="default test msg" />
<br/>
Ticker Text:
<input type="text" name="ticket_text" value="default test ticket test"/>
<br/>
Content Title:
<input type="text" name="content_title" value="default content title"/>
<br/>
Content Text
<input type="text" name="content_text" value="default content text"/>
<br/>
Registration ID:
<input type="text" name="registration_id" />
<br/>
API KEY
<input type="text" name="api_key" value="AIzaSyAkdzMs-_w_FclxdRQg4oHXtbJ7LVBeHEA" />
<br/>
<input type="submit" />
</form>


