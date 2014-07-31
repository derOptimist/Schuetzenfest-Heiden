 <?php 
if(isset($_POST['imagepath']))
{

   // Generate filename
   $filename = '10000.jpg';// md5(mt_rand()).'.jpg';
   $counter = 10000;

   $ziel = "../upload/images/released";
   $neuername = $ziel.'/'.$counter.'.jpg';
   
   echo 'Alter Dateiname: '.$_POST['imagepath'].$_POST['imagefilename'].'<br>';
   echo 'Neuer Dateiname: '.$neuername.'<br>';
   
   while (file_exists($neuername)) {
      echo 'Datei existiert bereits: '.$neuername.'<br>';
      $counter = $counter + 1;
      $neuername = $ziel.'/'.$counter.'.jpg';
   }

   echo 'Alter Dateiname: '.$_POST['imagepath'].$_POST['imagefilename'].'<br>';
   echo 'Neuer Dateiname: '.$neuername.'<br>';
   
   rename($_POST['imagepath'].$_POST['imagefilename'], $neuername);
}

// Zurück zur vorheringen Seite
echo'<script>
        alert("Bild freigegeben.");  
        top.history.back();
</script>';