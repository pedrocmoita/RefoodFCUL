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
		$recolha_query = "SELECT * FROM Recolha WHERE info='$donation' AND inst_id='$inst_id' AND vol_id='$user_id'";
		$recolha_result = mysqli_query($conn, $recolha_query);
		if(mysqli_num_rows($recolha_result) === 0){
			$query = "INSERT INTO Recolha VALUES(id, '$donation', '$inst_id', '$user_id')";
	                $result = mysqli_query($conn, $query);

		}
	}
}
?>
