
<?php

$mysqli = new mysqli('localhost', 'root', 'root', 'inventory');

   if(mysqli_connect_errno()) {
      echo "Connection Failed: " . mysqli_connect_errno();
      exit();
   }
?>