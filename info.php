<?php
include "abreconexao.php";
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
	header("location: login.php");
	exit;
}

if(isset($_GET['infoid'])){
	$inst_id=$_GET['infoid']; // inst id
}

$username = $_SESSION['username']; //volunteer name
$user_id = $_SESSION['id'];  // volunteer id
$ID = $_SESSION['userID']; // volunteer user id

$query = "SELECT * FROM Instituicao WHERE id = '$inst_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$numero = $row['numero']; //inst number
$email = $row['email']; //inst email
$nome = $row['nome']; //inst name
//-------------------------------EVALUATE INSTITUTION---------------------------------------
if(isset($_POST['avaliacao'])){
  $rating = $_POST['rating'];
  if(strlen($rating) < 1){ 
      $rating = 5; 
  }
  $rating_query = "SELECT * FROM Avalicao WHERE de='$user_id' AND para='$inst_id'";
  $rating_result = mysqli_query($conn, $rating_query);
  if(mysqli_num_rows($rating_result) == 0){
      $new_rating_query = "INSERT INTO Avalicao VALUES(id, '$user_id', '$inst_id', '$rating')";
      $new_rating_result = mysqli_query($conn, $new_rating_query);
  }else{
      $update_rating_query = "UPDATE Avalicao SET avalicao = '$rating' WHERE de='$user_id'";
      $update_rating_result = mysqli_query($conn, $update_rating_query);
  }
}
//------------------------------------AVERAGE EVALUATION----------------------------------
	$classif_query = "SELECT AVG(avalicao) AS media FROM Avalicao WHERE para='$inst_id'";
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
		<h1 style="color: #EED202;" class="mb-3"><?php echo $nome . '  <span style="font-size: 1rem;">(' . $classif . ')</span>'?></h1>
		<?php echo '<input type="text" value="'.$nome.'" id="para" hidden/>' ?>
		<?php echo '<input type="text" value="'.$username.'" id="de" hidden/>' ?>
                <h3 style="color: #EED202;">Contactos</h3>
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
        <div class="col chat" style="overflow-y: scroll; overflow-x: hidden;">
                <h5>Chat</h5>
		<div class="chat-area">
			<?php 
				$chats = "SELECT * FROM Mensagens WHERE (de='$user_id' AND para='$inst_id') OR (de='$inst_id' AND para='$user_id')";
				$chat_result = mysqli_query($conn, $chats);
				while($chat = mysqli_fetch_assoc($chat_result)){
        				if($chat['de'] == $user_id){
            					echo "<div style='text-align: right;'>
                    					<p style='background-color: lightblue; word-wrap: break-word; 
                        					display: inline-block; padding: .5rem; border-radius: .75rem; max-width: 70%;'>
                        					".$chat["message"]."
                    					</p>
                					</div>";
        				}else{
            					echo "<div style='text-align:left;'>
                    					<p style='background-color: lightblue; word-wrap: break-word; display: inline-block;
                        					padding: .5rem; border-radius: .75rem; max-width: 70%;'>
                        					".$chat["message"]."
                    					</p>
                					</div>";
        				}
    				}
			?>
		</div>
		<div class="send-msg-form" >
			<div class="row">
				<div class="col-md-10">
					<input type="text" class="msg-input" id="msg-input">
				</div>
				<div class="col-md-2">
					<button class="send-msg-btn" id="send"><i class="fa-solid fa-paper-plane"></i></button>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
</body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript">
        $(document).ready(function(){
                $("#send").on("click", function(){
                        $.ajax({
                                url: "insertMsg.php",
                                method: "POST",
                                data:{
                                        de: $("#de").val(),
                                        para: $("#para").val(),
                                        message: $("msg-input").val()
                                },
                                dataType: "text",
                                success:function(data){
                                        $("#msg-input").val("");
                                }
                        });
                });
        });
</script>
</html>
