<?php

session_start();
include "abreconexao.php";

$de = $_POST['de'];
$para = $_POST['para'];
$message = $_POST['message'];

$output="";

$insertMsg_query = "INSERT INTO Mensagens VALUES(id, '1', '2','ola');
if($conn -> query($insertMsg)){
        $output.="";
}else{
        $output.="Error. Please Try Again.";
}
echo $output;

?>
