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
$_SESSION['inst_id'] = $inst_id;

$query = "SELECT * FROM Instituicao WHERE id = '$inst_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$numero = $row['numero']; //inst number
$email = $row['email']; //inst email
$nome = $row['nome']; //inst name

$doacao_query = "SELECT * FROM Doacao WHERE id = '$inst_id'";
$doacao_result = mysqli_query($conn, $doacao_query);

$concelho_recolha_query = "SELECT concelho FROM Doacao WHERE id = '$inst_id'";
$concelho_recolha_query_result = mysqli_query($conn, $concelho_recolha_query);
$concelho_row = mysqli_fetch_assoc($concelho_recolha_query_result);
$concelho_recolha = $concelho_row['concelho'];
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
    <link rel="stylesheet" href="css/infoo.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/c63aba2ece.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script defer src="script/script.js"></script>
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
		<h1 style="color: #EED202;" class="mb-3"><?php echo $nome . '  <span style="font-size: 1rem;">(' . $classif . '&starf;)</span>'?></h1>
		<input type="hidden" id="de" value="<?php echo $user_id; ?>">
		<input type="hidden" id="para" value="<?php echo $inst_id; ?>">
                <h3 style="color: #EED202;">Contactos</h3>
                <p><i class="fa-solid fa-phone mr-2" style="color: #EED202;"></i><?php echo $numero; ?></p>
                <p><i class="fa-solid fa-envelope mr-2" style="color: #EED202;"></i><?php echo $email; ?></p>
		<h3 style="color: #EED202;">Concelho Recolha</h3>
		<p><i class="fa-solid fa-map-location-dot mr-2" style="color: #EED202;"></i><?php echo $concelho_recolha; ?></p>
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
		<h3 style="color: #EED202;">Dias de Recolha Disponiveis</h3>
		<form method="POST" action="">
			<table class="delivery">
			<?php
			$recolha_dia_1 = "SELECT * FROM Recolha WHERE inst_id='$inst_id' AND vol_id='$user_id' AND info='dia1_choosen'";
			$recolha_result_dia_1 = mysqli_query($conn, $recolha_dia_1);
			$recolha_dia_2 = "SELECT * FROM Recolha WHERE inst_id='$inst_id' AND vol_id='$user_id' AND info='dia2_choosen'";
			$recolha_result_dia_2 = mysqli_query($conn, $recolha_dia_2);
			$recolha_dia_3 = "SELECT * FROM Recolha WHERE inst_id='$inst_id' AND vol_id='$user_id' AND info='dia3_choosen'";
			$recolha_result_dia_3 = mysqli_query($conn, $recolha_dia_3);
			if(mysqli_num_rows($doacao_result) > 0){
				if(mysqli_num_rows($recolha_result_dia_1) > 0 && mysqli_num_rows($recolha_result_dia_2) > 0 && mysqli_num_rows($recolha_result_dia_3) > 0){
					echo "<p style='opacity: 0.5; text-align: center;' class='mt-3 mb-3'>Os dias de recolha estão todos ocupados.</p>";
				}else{
					 
					echo "<tr>
						<th>Dia</th>
						<th>Horas</th>
						<th>Tipo</th>
						<th>Quantidade</th>
						<th>Recolher</th>
					</tr>";
				
					while($doacao_row = mysqli_fetch_assoc($doacao_result)){				
					
						if(mysqli_num_rows($recolha_result_dia_1) === 0 ){
							if(strlen($doacao_row['dia_semana_1']) > 0 && strlen($doacao_row['hr_inic_dia_1']) > 0){
								echo "<tr>
								<td>" . $doacao_row['dia_semana_1'] . "</td>
								<td>" . $doacao_row['hr_inic_dia_1'] . "</td>
								<td>" . $doacao_row['tipo_dia_1'] . "</td>
								<td>" . $doacao_row['quant_dia_1'] . " " . $doacao_row['quant_tipo_dia_1'] . "</td>
								<td><input type='checkbox' class='get_value' value='dia1_choosen'></td>
								</tr>";
							}
						}
						if(mysqli_num_rows($recolha_result_dia_2) === 0){
							if(strlen($doacao_row['dia_semana_2']) > 0 && strlen($doacao_row['hr_inic_dia_2']) > 0){
								echo "<tr>
								<td>" . $doacao_row['dia_semana_2'] . "</td>
								<td>" . $doacao_row['hr_inic_dia_2'] . "</td>
								<td>" . $doacao_row['tipo_dia_2'] . "</td>
								<td>" . $doacao_row['quant_dia_2'] . " " . $doacao_row['quant_tipo_dia_2'] . "</td>
								<td><input type='checkbox' class='get_value' value='dia2_choosen'></td>
								</tr>";
							}
						}
						if(mysqli_num_rows($recolha_result_dia_3) === 0){
							if(strlen($doacao_row['dia_semana_3']) > 0 && strlen($doacao_row['hr_inic_dia_3']) > 0){
								echo "<tr>
								<td>" . $doacao_row['dia_semana_3'] . "</td>
								<td>" . $doacao_row['hr_inic_dia_3'] . "</td>
								<td>" . $doacao_row['tipo_dia_3'] . "</td>
								<td>" . $doacao_row['quant_dia_3'] . " " . $doacao_row['quant_tipo_dia_3'] . "</td>
								<td><input type='checkbox' class='get_value' value='dia3_choosen'></td>
								</tr>";
							}
						}
					}
				}
			}else{
				echo "<p style='opacity: 0.5; text-align: center;' class='mt-3 mb-3'>A instituição em questão ainda não selecionou nenhuma data para as doações.</p>";
			}
			?>
	                </table>
			<button name="donation-submit-btn" id="donation-submit-btn" class="profile-form-btn mt-3">Solicitar Recolha</button>
        	</form>
	</div>
        <div class="col chat">
                <h2 style="color: #EED202;">Chat</h2>
		<div class="chat-area" id="chat-area">
			<?php 
				$chats = "SELECT * FROM Mensagens WHERE (de='$user_id' AND para='$inst_id') OR (de='$inst_id' AND para='$user_id')";
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
			                <input type="hidden" id="para" value="<?php echo $inst_id; ?>">
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

<script type="text/javascript">
        function chat_validation(){
                const textmsg = $('#message').val();
		const de = $('#de').val();
		const para = $('#para').val();
		if(textmsg == ""){
			alert("Type something...");
			return false;
		}
		const datastr = 'message='+textmsg+'&de='+de+'&para='+para;

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

<script type="text/javascript">
	$(document).ready(function(){
		$('#donation-submit-btn').click(function(){
			var donations = [];

			$('.get_value').each(function(){
				if($(this).is(":checked")){
					donations.push($(this).val());
				}
			});

			donations = donations.toString();
			$.ajax({
				url: "donations.php",
				method: "POST",
				data: {donations:donations},
				success:function(e){
					alert("Pick up days choosen");
				}
			});
	
		});
	});
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
