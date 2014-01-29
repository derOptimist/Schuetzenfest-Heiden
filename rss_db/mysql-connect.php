<?php
$host = "rdbms.strato.de";  // meist ist das localhost
$user = "U1065632";
$pw = "321rezepte123";
$db = "DB1065632";
$connection = mysql_connect($host, $user, $pw) or die ("Datenbankfehler.\n\n");
$db_selected = mysql_select_db($db, $connection);
if (!$db_selected) {
    echo 'Datenbankfehler';
}
?>
