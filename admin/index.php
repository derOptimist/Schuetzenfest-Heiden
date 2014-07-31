 <?php
if(isset($_GET['secretkey']) == 0)
{

   echo "Ung&uumlltiger Funktionsaufruf!";
   return;

}

if(isset($_POST['delete_chat']) == 1)
{

   
   $i = 0;
   $new_file = "../chatbox_test_deleted.txt".$i;
   while (file_exists($new_file) == 1) 
   {
      $i++;
      $new_file = "../chatbox_test_deleted.txt".$i;
   }
   
   rename("../chatbox_test.txt",$new_file);
   
   $file = "../chatbox_test.txt";
   $string = "----------------------------\r\n".date("d.m.Y H:i:s")." - Admin";
   $string .= "\r\nChat wurde durch den Administrator zurückgesetzt.";
   file_put_contents($file, $string);
   
   
   echo '<script>alert("Chat '.$new_file.' gesperrt");</script> ';
}

if(isset($_POST['delete_chat_forever']) == 1)
{

   
   $i = 0;
   $new_file = "../chatbox_test_deleted.txt".$i;
   while (file_exists($new_file) == 1) 
   {
      $i++;
      $new_file = "../chatbox_test_deleted.txt".$i;
   }
   
   rename("../chatbox_test.txt",$new_file);
   
   $file = "../chatbox_test.txt";
   $string = "----------------------------\r\n".date("d.m.Y H:i:s")." - Admin";
   $string .= "\r\nChat wurde durch den Administrator zurückgesetzt.";
   file_put_contents($file, $string);
   
   file_put_contents("../chatbox_block.dat", "gesperrt");
   
   echo '<script>alert("Chat '.$new_file.' für immer gesperrt");</script> ';
}



?>


<!DOCTYPE html>
<html manifest="app.appcache">
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
                <li><a href="#chat_sperren">chat sperren</a></li>
            </ul>
        </div><!-- /navbar -->
    </div><!-- /footer -->
</div><!-- /page -->





<!-- Start of first page -->
<div data-role="page" id="chat_sperren">

    <div data-role="header">
        <h1>Delete chat</h1>
    </div><!-- /header -->

    <div data-role="content">
       <div data-role="fieldcontain">
 
 <?php
              echo '<form name="form1" action="index.php?secretkey=1"  method="POST" data-ajax="false">';
              echo '<input type="hidden" name="delete_chat" size="0" value="doit" />';
              echo '<input type="submit" id="submit" value="Sperren" />';
              echo '</form>';
 ?>

 <br><br><br><br>
 
 
 <?php
              echo '<form name="form2" action="index.php?secretkey=1"  method="POST" data-ajax="false">';
              echo '<input type="hidden" name="delete_chat_forever" size="0" value="doit" />';
              echo '<input type="submit" id="submit2" value="F&uuml;r immer sperren" />';
              echo '</form>';
 ?>
 
 
       </div>


    </div><!-- /content -->

    <div data-role="footer" style="overflow:hidden;" data-position="fixed">
        <h4 style="text-align:center;">Sch&uuml;tzenfest Heiden</h4>
        <div data-role="navbar">
            <ul>
                <li><a href="#RSS">RSS</a></li>
                <li><a href="#chat_sperren">chat sperren</a></li>
            </ul>
        </div><!-- /navbar -->
    </div><!-- /footer -->
</div><!-- /page -->






</body>
