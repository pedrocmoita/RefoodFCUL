<?php
include "abreconexao.php";
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
	header("location: login.php");
	exit;
}

if(isset($_GET['Infoid'])){
	$vol_id=$_GET['Infoid']; // volunteer id
}

$username = $_SESSION['username']; //institution name
$user_id = $_SESSION['id'];  // institution id
$ID = $_SESSION['userID']; // institution user id

$query = "SELECT * FROM Voluntario WHERE id = '$vol_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$numero = $row['numero']; //volunteer number
$email = $row['email']; //volunteer email
$nome = $row['nome']; //volunteer name

$dias_query = "SELECT * FROM Dias WHERE id = '$vol_id'";
$dias_result = mysqli_query($conn, $dias_query);
$dias_row = mysqli_fetch_assoc($dias_result);
$concelho_recolha = $dias_row['concelho'];
//-------------------------------EVALUATE INSTITUTION---------------------------------------
if(isset($_POST['avaliacao'])){
  $rating = $_POST['rating'];
  if(strlen($rating) < 1){ 
      $rating = 5; 
  }
  $rating_query = "SELECT * FROM Avalicao WHERE de='$user_id' AND para='$vol_id'";
  $rating_result = mysqli_query($conn, $rating_query);
  if(mysqli_num_rows($rating_result) == 0){
      $new_rating_query = "INSERT INTO Avalicao VALUES(id, '$user_id', '$vol_id', '$rating')";
      $new_rating_result = mysqli_query($conn, $new_rating_query);
  }else{
      $update_rating_query = "UPDATE Avalicao SET avalicao = '$rating' WHERE de='$user_id'";
      $update_rating_result = mysqli_query($conn, $update_rating_query);
  }
}
//------------------------------------AVERAGE EVALUATION----------------------------------
	$classif_query = "SELECT AVG(avalicao) AS media FROM Avalicao WHERE para='$vol_id'";
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
    <link rel="stylesheet" href="css/info.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/c63aba2ece.js" crossorigin="anonymous"></script>
    <script defer src="script/script.js"></script>
</head>
<body>
<div class="header">
	<div class="container-md">
		<a href="welcome_instituicao.php"><i class="fa-solid fa-arrow-left"></i></a>
	</div>
</div>
<div class="container-md body">
	<div class="row">
        <div class="col">
		<h1 style="color: #EED202;" class="mb-3"><?php echo $nome . '  <span style="font-size: 1rem;">(' . $classif . '&starf;)</span>'?></h1>
		<input type="hidden" id="de" value="<?php echo $user_id; ?>">
		<input type="hidden" id="para" value="<?php echo $vol_id; ?>">
                <h3 style="color: #EED202;">Contactos</h3>
                <p><i class="fa-solid fa-phone mr-2" style="color: #EED202;"></i><?php echo $numero; ?></p>
                <p><i class="fa-solid fa-envelope mr-2" style="color: #EED202;"></i><?php echo $email; ?></p>
		<h3 style="color: #EED202;">Concelho de Recolha</h3>
		<p><i class="fa-solid fa-map-location-dot mr-2" style="color: #EED202;"></i><?php echo $concelho_recolha ?></p>
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
                <p style="color: #EED202;"><button class="profile-form-btn m-0">Aceitar Recolha</button></p>
        </div>
        <div class="col chat">
                <h2 style="color: #EED202;">Chat</h2>
		<div class="chat-area" id="chat-area">
			<?php 
				$chats = "SELECT * FROM Mensagens WHERE (de='$user_id' AND para='$vol_id') OR (de='$vol_id' AND para='$user_id')";
				$chat_result = mysqli_query($conn, $chats);
				while($chat = mysqli_fetch_assoc($chat_result)){
        				if($chat['de'] == $user_id){
            					echo "<div style='text-align: right;'>
                    					<p style='background-color: lightblue; word-wrap: break-word; 
                        					display: inline-block; padding: .5rem; border-radius: .75rem; max-width: 70%; margin: .5rem;'>
                        					".$chat["message"]."
                    					</p>
                					</div>";
        				}else{
            					echo "<div style='text-align:left;'>
                    					<p style='background-color: antiquewhite; word-wrap: break-word; display: inline-block;
                        					padding: .5rem; border-radius: .75rem; max-width: 70%; margin: .5rem;'>
                        					".$chat["message"]."
                    					</p>
                					</div>";
        				}
    				}
			?>
			<script type="text/javascript">
				$(function(){
					const de = $('#de').val();
					const para = $('#para').val();
					const dataStr = 'de='+de+'&para='+para;
					setInterval(function(){
						$.ajax({
							type: 'GET',
							url: 'chat_loader.php',
							data: dataStr,
							success:function(e){
								$('#chat-area').html(e);
							}
						}); 
					}, 100);
				});
			</script>
		</div>
		<div class="send-msg-form" >
			<form method="POST" class="row" id="chat-form">
				<div class="col-md-10">
					<input type="hidden" id="de" value="<?php echo $user_id; ?>">
			                <input type="hidden" id="para" value="<?php echo $vol_id; ?>">
					<input type="text" class="msg-input" id="message" placeholder="Type Message...">
				</div>
				<div class="col-md-2">
					<button onclick="return chat_validation()" class="send-msg-btn" id="send"><i class="fa-solid fa-paper-plane"></i></button>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript">
        function chat_validation(){
                const textmsg = $('#message').val();
		const de = $('#de').val();
		const para = $('#para').val();
		if(textmsg == ""){
			alert("Type something...");
			return false;
		}
		const datastr = 'message='+textmsg+'&de='+de+'&para='+para;;

		$.ajax({
			url: 'chatlog.php',
			type: 'POST',
			data: datastr,
			success:function(e){
				$('#chat-area').html(e);
			}
		});
		document.getElementById('chat-form').reset();
		return false;
        }
</script>
<script>
var element = document.getElementById("chat-area");
element.scrollTop = element.scrollHeight;

function updateScroll(){
    var element = document.getElementById("chat-area");
    element.scrollTop = element.scrollHeight;
}
//once a second
setInterval(updateScroll, 1000);
</script>
</body>
</html>
