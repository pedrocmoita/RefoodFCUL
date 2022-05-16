<?php
include "abreconexao.php";
$message = $_POST['message'];
$de = $_POST['de'];
$para = $_POST['para'];

//echo $message . " " . $de .  " " . $para; 

$insertMsg_query = "INSERT INTO Mensagens VALUES(id, '$de', '$para', '$message')";
$insertMsg_result = mysqli_query($conn, $insertMsg_query);
//if($insertMsg_result){
//	echo "sent";
//}else{
//	echo "not sent";
//}
?>
