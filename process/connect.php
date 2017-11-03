<?php
 $serverName = "localhost";
  $userName = "root";
  $userPassword = "rootroot";
  $dbName = "bscan";
 $con = mysqli_connect ($serverName,$userName,$userPassword,$dbName);
 mysqli_set_charset($con,"UTF8");
?>