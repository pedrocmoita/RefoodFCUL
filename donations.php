<?php
include "abreconexao.php";
session_start();
$username = $_SESSION['username']; //volunteer name
$user_id = $_SESSION['id'];  // volunteer id
$don = $_POST['donations'];
$inst_id = $_SESSION['inst_id']; //institution id

if(isset($don)){
	$result = explode (",", $don);
	foreach($result as $donation){
		//echo $donation . "<br>";
		$query = "INSERT INTO Recolha VALUES(id, '$donation', '$inst_id', '$user_id')";
		$result = mysqli_query($conn, $query); 
	}
}
?>
