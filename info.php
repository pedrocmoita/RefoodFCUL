<?php
include "abreconexao.php";
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
	header("location: login.php");
	exit;
}

if(isset($_GET['infoid'])){
	$id=$_GET['infoid'];
}

$username = $_SESSION['username'];
$user_id = $_SESSION['id'];
$ID = $_SESSION['userID'];

//-------------------------------EVALUATE INSTITUTION---------------------------------------
$query = "SELECT * FROM Instituicao WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$numero = $row['numero'];
$email = $row['email'];
$nome = $row['nome'];
if(isset($_POST['avaliacao'])){
  $rating = $_POST['rating'];
  if(strlen($rating) < 1){ 
      $rating = 5; 
  }
  $rating_query = "SELECT * FROM Avalicao WHERE de='$user_id' AND para='$id'";
  $rating_result = mysqli_query($conn, $rating_query);
  if(mysqli_num_rows($rating_result) == 0){
      $new_rating_query = "INSERT INTO Avalicao VALUES(id, '$user_id', '$id', '$rating')";
      $new_rating_result = mysqli_query($conn, $new_rating_query);
  }else{
      $update_rating_query = "UPDATE Avalicao SET avalicao = '$rating' WHERE de='$user_id'";
      $update_rating_result = mysqli_query($conn, $update_rating_query);
  }
}
//------------------------------------AVERAGE EVALUATION----------------------------------
	$classif_query = "SELECT AVG(avalicao) AS media FROM Avalicao WHERE para='$id'";
	$classif_result = mysqli_query($conn, $classif_query);
	$ruw = mysqli_fetch_assoc($classif_result);
	$classif = round($ruw['media'], 1);
//----------------------------------------------------------------------------------------
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ReFood</title>
    <link rel="stylesheet" href="css/welcome.css">
    <link rel="stylesheet" href="css/infu.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/c63aba2ece.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="header">
	<div class="container-md">
		<a href="welcome_voluntario.php"><i class="fa-solid fa-arrow-left"></i></a>
	</div>
</div>
<div class="container-md body">
<div class="row">
        <div class="col">
		<h3 style="color: #EED202;" class="mb-3"><?php echo $nome . '  <span style="font-size: 1rem;">(' . $classif . ')</span>'?></h3>
                <h5 style="color: #EED202;">Contactos</h5>
                <p><i class="fa-solid fa-phone mr-2" style="color: #EED202;"></i><?php echo $numero; ?></p>
                <p><i class="fa-solid fa-envelope mr-2" style="color: #EED202;"></i><?php echo $email; ?></p>
                <form class="rating-css" method="post" action="">
                        <div class="star-icon">
                                <input type="radio" name="rating" value="1" id="rating1">
                                <label for="rating1" class="fa fa-star"></label>
                                <input type="radio" name="rating" value="2" id="rating2">
                                <label for="rating2" class="fa fa-star"></label>
                                <input type="radio" name="rating" value="3" id="rating3">
                                <label for="rating3" class="fa fa-star"></label>
                                <input type="radio" name="rating" value="4" id="rating4">
                                <label for="rating4" class="fa fa-star"></label>
                                <input type="radio" name="rating" value="5" id="rating5">
                                <label for="rating5" class="fa fa-star"></label>
                        </div>
                        <button type="submit" name="avaliacao" class="profile-form-btn m-0">Avaliar Instituição</button>
                </form>
                <p style="color: #EED202;"><button class="profile-form-btn m-0">Solicitar Recolha</button></p>
        </div>
        <div class="col chat">
                <h5>CHAT</h5>
		<form class="send-msg-form">
			<div class="row">
				<div class="col-md-10">
					<input type="text" class="msg-input" name="msg">
				</div>
				<div class="col-md-2">
					<button type="submit" name="send-msg-btn" class="send-msg-btn"><i class="fa-solid fa-paper-plane"></i></button>
				</div>
			</div>
		</form>
	</div>
</div>
</div>
</body>
</html>
