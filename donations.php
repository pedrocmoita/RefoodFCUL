<?php

include "abreconexao.php";
$don = $_POST['donations'];
if(isset($don)){
	$result = explode (",", $don);
	//print_r($result);
	echo "dias escolhidos: " . $result[0] . " | " . $result[1];
}
?>
