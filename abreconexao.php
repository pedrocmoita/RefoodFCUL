<?php
$dbhost = "appserver-01.alunos.di.fc.ul.pt";
$dbuser = "asw13";
$dbpass = "diretoria";
$dbname = "asw13";
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (mysqli_connect_error()) {
  die("Database connection failed: " . mysqli_connect_error());
}
?>