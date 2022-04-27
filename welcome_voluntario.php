<?php
session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
	header("location: login.php");
	exit;
}

$username = $_SESSION['username'];
$user_id = $_SESSION['id'];
$ID = $_SESSION['userID'];

include "abreconexao.php";

$query_voluntario = "SELECT * FROM Voluntario WHERE id='$user_id'";
$result_voluntario = mysqli_query($conn, $query_voluntario);

//--------------Welcome section---------------

$row_gender = mysqli_fetch_assoc($result_voluntario); 
$gender = $row_gender["genero"];
$welcome = '';

if ($gender == 'Female'){
	$welcome = 'Bem vinda  ';
}else{
	$welcome = 'Bem vindo  ';
}

//--------------BD Profile section----------------

$nova_query = "SELECT * FROM Voluntario WHERE id='$user_id'";
$novo_result = mysqli_query($conn, $nova_query);

$row_profile = mysqli_fetch_assoc($novo_result);
$bd_email = $row_profile['email'];
$bd_phone = $row_profile['numero'];
$bd_distrito = $row_profile['distrito'];
$bd_concelho = $row_profile['concelho'];
$bd_freguesia =	$row_profile['freguesia'];
$bd_nascimento = $row_profile['data_nasc'];
$bd_carta_cond = $row_profile['carta_cond'];
$bd_cartao_cidadao =  $row_profile['cartao_cidadao'];

//-------------Updating Profile section-----------

if(isset($_POST['update-profile-btn'])){

	$updated_name = htmlspecialchars($_POST['updated_name']);
	$updated_email = htmlspecialchars($_POST['updated_email']);
	$updated_phone = htmlspecialchars($_POST['updated_phone']);
	$updated_birth = htmlspecialchars($_POST['updated_birth']);
	$updated_drivers = htmlspecialchars($_POST['updated_drivers']);
	$updated_distrito = htmlspecialchars($_POST['updated_distrito']);
	$updated_concelho = htmlspecialchars($_POST['updated_concelho']);
	$updated_freguesia = htmlspecialchars($_POST['updated_freguesia']);
	$updated_cartao_cidadao = htmlspecialchars($_POST['updated_cartao_cidadao']);
	$updated_password = htmlspecialchars($_POST['updated_password']);

	$updated_hash_password = password_hash($updated_password, PASSWORD_DEFAULT);
	
	$error = '';
	$error_msg = '';
	$alert = "Failed to update! Check your profile.";
	$alert_msg = "<div style='position: absolute; top: 3%; left: 50%; transform: translate(-50%, -50%);' class='mt-3 pt-4 pb-4 alert alert-danger alert-dismissible fade show' role='alert'>
			<button type='button' class='pt-4 close' data-dismiss='alert'>&times;</button>
			{$alert}
			</div>";

	if(strlen("$updated_password") < 6 || strlen("$updated_password") > 20){
		$error = "Password must have between 6 and 20 characters!";
                $error_msg = "<div class='container mt-2 mb-2 pt-2 pb-2 alert alert-danger alert-dismissible fade show' role='alert'>
                          <button type='button' class='pt-2 close' data-dismiss='alert'>&times;</button>
                          {$error}
                      </div>";
		echo $alert_msg;

	}else if(strlen($updated_phone) > 9){
		$error = "Phone number has a maximum of 9 digits!";
		$error_msg = "<div class='container mt-2 mb-2 pt-2 pb-2 alert alert-danger alert-dismissible fade show' role='alert'>
                          <button type='button' class='pt-2 close' data-dismiss='alert'>&times;</button>
                          {$error}
                      </div>";	
	 	echo $alert_msg;
	
	}else if(strlen($updated_drivers) > 11 || strlen($updated_cartao_cidadao) > 11){
		$error = "Your drivers license or personal ID are incorrect.";
		$error_msg = "<div class='container mt-2 mb-2 pt-2 pb-2 alert alert-danger alert-dismissible fade show' role='alert'>
                        <button type='button' class='pt-2 close' data-dismiss='alert'>&times;</button>
                          {$error}
                      </div>";
                echo $alert_msg;

	}else{

		if(is_numeric($updated_phone)){
			$update_query = "UPDATE Voluntario SET  nome='$updated_name', numero='$updated_phone', email='$updated_email', distrito='$updated_distrito',
                		concelho='$updated_concelho', freguesia='$updated_freguesia', data_nasc='$updated_birth', carta_cond='$updated_drivers',
                		cartao_cidadao='$updated_cartao_cidadao', passwd='$updated_hash_password' WHERE id='$user_id'";
	        	$result_update = mysqli_query($conn, $update_query);

        		$update_query2 = "UPDATE Utilizador SET nome='$updated_name', email='$updated_email', passwd='$updated_hash_password' WHERE id='$ID'";
        		$result_update2 = mysqli_query($conn, $update_query2);

        		$_SESSION['username'] = $updated_name;
        		header('location: welcome_voluntario.php');

		}else{
			$error = "Please insert a valid phone number.";
			$error_msg = "<div class='container mt-2 mb-2 pt-2 pb-2 alert alert-danger alert-dismissible fade show' role='alert'>
                          	<button type='button' class='pt-2 close' data-dismiss='alert'>&times;</button>
                          	{$error}
                      		</div>";	
	 		echo $alert_msg;
		}
	}	
}

//----------------Preferences section---------------------

if(isset($_POST['update-preferences-btn'])){

	$preferences_concelho = htmlspecialchars($_POST['preferences_concelho']);
	$pickup_day_1 = htmlspecialchars($_POST['pickup_day_1']);
	$pickup_day_2 = htmlspecialchars($_POST['pickup_day_2']);
	$pickup_day_3 = htmlspecialchars($_POST['pickup_day_3']);
	$pickup_period_1 = htmlspecialchars($_POST['pickup_period_1']);
	$pickup_period_2 = htmlspecialchars($_POST['pickup_period_2']);
	$pickup_period_3 = htmlspecialchars($_POST['pickup_period_3']);
  
	$preferences_query = "SELECT * FROM Dias WHERE id='$user_id'";
	$preferences_result = mysqli_query($conn, $preferences_query);

	if(mysqli_num_rows($preferences_result) > 0){
    		
		$preferences_update_query = "UPDATE Dias SET concelho='$preferences_concelho', dia_semana_1='$pickup_day_1', periodo_dia_1='$pickup_period_1',
					dia_semana_2='$pickup_day_2', periodo_dia_2='$pickup_period_2', dia_semana_3='$pickup_day_3', periodo_dia_3='$pickup_period_3' WHERE id='$user_id'"; 
		$preferences_update_result = mysqli_query($conn, $preferences_update_query);
	}else{

		$preferences_insert_query = "INSERT INTO Dias VALUES('$user_id', '$preferences_concelho', '$pickup_day_1', '$pickup_period_1', '$pickup_day_2', 
					'$pickup_period_2', '$pickup_day_3', '$pickup_period_3')";
		$preferences_insert_result = mysqli_query($conn, $preferences_insert_query);
  	}

	header('location: welcome_voluntario.php');
}
//----------------BD Preferences section--------------------

$dias_bd_query = "SELECT * FROM Dias WHERE id='$user_id'";
$result_dias_bd = mysqli_query($conn, $dias_bd_query);
$row_dias = mysqli_fetch_assoc($result_dias_bd);

$bd_preferences_concelho = $row_dias['concelho'];
$bd_dia_semana_1 = $row_dias['dia_semana_1'];
$bd_periodo_1 = $row_dias['periodo_dia_1'];
$bd_dia_semana_2 = $row_dias['dia_semana_2'];
$bd_periodo_2 = $row_dias['periodo_dia_2'];
$bd_dia_semana_3 = $row_dias['dia_semana_3'];
$bd_periodo_3 = $row_dias['periodo_dia_3'];

if($bd_dia_semana_1 === 'no_day_selected'){
	$bd_dia_semana_1 = '';
}else{
	$bd_dia_semana_1 = $row_dias['dia_semana_1'];
}

if($bd_dia_semana_2 === 'no_day_selected'){
	$bd_dia_semana_2 = '';
}else{
	$bd_dia_semana_2 = $row_dias['dia_semana_2'];
}

if($bd_dia_semana_3 === 'no_day_selected'){
	$bd_dia_semana_3 = '';
}else{
	$bd_dia_semana_3 = $row_dias['dia_semana_3'];
}

if($bd_periodo_1 === 'no_hour_selected'){
	$bd_periodo_1 = '';
}else{
	$bd_periodo_1 = $row_dias['periodo_dia_1'];	
}

if($bd_periodo_2 === 'no_hour_selected'){
	$bd_periodo_2 = '';
}else{
	$bd_periodo_2 = $row_dias['periodo_dia_2'];
}

if($bd_periodo_3 === 'no_hour_selected'){
	$bd_periodo_3 = '';
}else{
	$bd_periodo_3 = $row_dias['periodo_dia_3'];
}

//---------------------------------------------------------

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refood | FCUL</title>
    <link rel="stylesheet" href="css/welcomee.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/c63aba2ece.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="body">
      <header class="d-flex justify-content-between">
        <div>
          <p><?php echo $welcome ?> <span style="color: #EED202; margin-left: .125rem;"><?php echo $username ?></span></p>
          <p><i class="fa-regular fa-circle-left mt-1" data-toggle="modal" data-target="#logout"></i></p>
	    <div class="modal fade" id="logout">
              <div class="modal-dialog">
                <div class="modal-content text-center p-2">
                  <div class="modal-body">
                    <p>Are you sure you want to logout of this session?</p>
                    <div class="mt-3">
                      <a href="login.php" style="text-decoration: none; padding: .75rem 1rem;" class="logout-btn logout-yes m-2">Yes, logout</a>
                      <a style="text-decoration: none; padding: .75rem 1rem; cursor:pointer;" class="logout-btn logout-close m-2" data-dismiss="modal">Close</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <p class="m-3"><span class="text-warning">RE</span>FOOD - FCUL</p>
        <div class="m-3">
          <i class="fa-regular fa-circle-question" data-toggle="modal" data-target="#myModal2"></i>
          <i class="fa-regular fa-user" data-toggle="modal" data-target="#myModal"></i>
        </div>
      </header>
      <!-- Profile Modal -->
      <div class="container">      
        <div class="modal" id="myModal">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">Profile</h4>
                <button style="color: #EED202;" type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <!-- Modal body -->
              <div class="profile modal-body row p-0 justify-content-around">
                <div class="col-sm-5 p-0 mt-3 mb-3">
                  <h4 class="m-0">Conta</h4>  
                  <hr>
		  <form action="" method="post">
                    <div class="row">
                      <div class="col">
                        <h5 class="mt-2 mb-2">Nome</h5>	
                        <input type="text" name="updated_name" value="<?php echo $username; ?>" placeholder="Insert new name" required>
                        <h5 class="mt-2 mb-2">Email</h5>
                        <input type="email" name="updated_email" value="<?php echo $bd_email; ?>" placeholder="Insert new email" required>
                        <h5 class="mt-2 mb-2">Telemóvel</h5>
                        <input type="text" name="updated_phone" value="<?php echo $bd_phone; ?>" placeholder="Insert new number" required>
                        <h5 class="mt-2 mb-2">Data Nascimento</h5>
                        <input type="date" name="updated_birth" value="<?php echo $bd_nascimento; ?>" required>
                        <h5 class="mt-2 mb-2">Carta Condução</h5>
                        <input type="text" name="updated_drivers" value="<?php echo $bd_carta_cond;  ?>" placeholder="Insert new license" required>
			<button class="profile-form-btn m-0 mt-3" type="submit" name="update-profile-btn"><i class="fa-regular fa-pen-to-square"></i><span class="ml-2">Update account</span></button>
		      </div>
                      <div class="col">
                        <h5 class="mt-2 mb-2">Distrito</h5>
                        <input type="text" name="updated_distrito" value="<?php echo $bd_distrito; ?>" placeholder="Insert new distrito" required>
                        <h5 class="mt-2 mb-2">Concelho</h5>
                        <input type="text" name="updated_concelho" value="<?php echo $bd_concelho; ?>" placeholder="Insert new concelho" required>
                        <h5 class="mt-2 mb-2">Freguesia</h5>
                        <input type="text" name="updated_freguesia" value="<?php echo $bd_freguesia; ?>" placeholder="Insert new freguesia" required>
                        <h5 class="mt-2 mb-2">Cartão Cidadão</h5>
                        <input type="text" name="updated_cartao_cidadao" value="<?php echo $bd_cartao_cidadao; ?>" placeholder="Insert new ID" required>
                        <h5 class="mt-2 mb-2">Password</h5>
                        <input type="password" name="updated_password" value="" placeholder="Insert new password" required>
			<button class="delete-account-btn m-0 mt-3" name="delete-account"><i class="fa-regular fa-trash-can"></i><span class="ml-2">Delete account</span></button>
		      </div>
                    </div>
		    <?php echo $error_msg; ?>
		  </form>  
                </div>
                <div class="col-sm-5 p-0 mt-3 mb-3">
                  <h4 class="m-0">Preferências</h4>
		  <hr>
		  <h5 class="mt-2 mb-2">Concelho</h5>
		  <p><?php echo $bd_preferences_concelho ?></p>
		  <div class="row">
		  	<div class="col">
				<h5 class="mt-2 mb-2">Dias de recolha</h5>
				<p><?php echo $bd_dia_semana_1; ?></p>
				<p><?php echo $bd_dia_semana_2; ?></p>
				<p><?php echo $bd_dia_semana_3; ?></p>
			</div>
			<div class="col">
				<h5 class="mt-2 mb-2">Períodos de recolha</h5>
				<p><?php echo $bd_periodo_1; ?></p>
				<p><?php echo $bd_periodo_2; ?></p>
				<p><?php echo $bd_periodo_3; ?></p>
			</div>
		  </div>
		  <hr>
                    <form action="" method="post">
                      <div>
                        <label for=""><h5 class="mt-2 mb-2">Local de recolha</h5></label><br>
                        <input type="text" name="preferences_concelho" placeholder="Concelho" required>
                      </div>
                      <div class="row mt-3"> 
                          <div class="col-sm">
                          <label for="pickup_day"><h5 class="mt-2 mb-2">Dias de recolha</h5></label>
                            <div class="mb-3">
                              <select name="pickup_day_1" id="pickup_day">
				<option selected value="no_day_selected">None</option>
                                <option value="segunda-feira">Segunda</option>
                                <option value="terça-feira">Terça</option>
                                <option value="quarta-feira">Quarta</option>
                                <option value="quinta-feira">Quinta</option>
                                <option value="sexta-feira">Sexta</option>
                              </select>
                            </div>
                            <div class="mt-3 mb-3">
                              <select name="pickup_day_2">
                                <option selected value="no_day_selected">None</option>
                                <option value="segunda-feira">Segunda</option>
                                <option value="terça-feira">Terça</option>
                                <option value="quarta-feira">Quarta</option>
                                <option value="quinta-feira">Quinta</option>
                                <option value="sexta-feira">Sexta</option>
                              </select>
                            </div>
                            <div class="mt-3 mb-3">
                              <select name="pickup_day_3">
                                <option selected value="no_day_selected">None</option>
                                <option value="segunda-feira">Segunda</option>
                                <option value="terça-feira">Terça</option>
                                <option value="quarta-feira">Quarta</option>
                                <option value="quinta-feira">Quinta</option>
                                <option value="sexta-feira">Sexta</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-sm">
                          <label for="pickup_hr"><h5 class="mt-2 mb-2">Períodos de recolha</h5></label>
                            <div class="mb-3">
                              <select name="pickup_period_1">
				<option selected value="no_hour_selected">None</option>
                                <option value="manha">Manhã (9:00hr - 11:00hr)</option>
                                <option value="meio do dia">Meio do dia (12:00hr - 13:00hr)</option>
                                <option value="tarde">Tarde (14:00hr - 17:00hr)</option>
                                <option value="noite">Noite (18:00hr - 19:00hr)</option>
                              </select>
                            </div>
                            <div class="mt-3 mb-3">
                              <select name="pickup_period_2">
                                <option value="no_hour_selected">None</option>
                                <option value="manha">Manhã (9:00hr - 11:00hr)</option>
                                <option value="meio do dia">Meio do dia (12:00hr - 13:00hr)</option>
                                <option value="tarde">Tarde (14:00hr - 17:00hr)</option>
                                <option value="noite">Noite (18:00hr - 19:00hr)</option>
                              </select>
                            </div>
                            <div class="mt-3 mb-3">
                              <select name="pickup_period_3">
                                <option value="no_hour_selected">None</option>
                                <option value="manha">Manhã (9:00hr - 11:00hr)</option>
                                <option value="meio do dia">Meio do dia (12:00hr - 13:00hr)</option>
                                <option value="tarde">Tarde (14:00hr - 17:00hr)</option>
                                <option value="noite">Noite (18:00hr - 19:00hr)</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div><button class="profile-form-btn mt-1" type="submit" name="update-preferences-btn">Update</button></div>
                    </form>
                </div>
              </div>
              <!-- Modal footer -->
              <div class="modal-footer p-2">
                <button type="button" data-dismiss="modal">Close</button>
	      </div>
            </div>
          </div>
        </div>
      </div>

      <!-- FAQS Modal -->
      <div class="container">      
        <div class="modal" id="myModal2">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <!-- Modal Header -->
              <div class="modal-header">
                <h4 class="modal-title">FAQs</h4>
                <button type="button" style="color: #EED202;" class="close" data-dismiss="modal">&times;</button>
              </div>
              <!-- Modal body -->
              <div class="modal-body">
                <p>
                  Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas eligendi voluptatibus perferendis in consequuntur? Eveniet eos unde eligendi voluptas repellat?
                </p>
                <p>
                  Lorem ipsum dolor sit, amet consectetur adipisicing elit. Incidunt, unde.
                </p>
              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                <button type="button" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="lista col-lg-2 text-center">
          <div class="m-3">
            <h4 class="text-warning">Instituições</h4>
            <ul>
              <li>Continente</li>
              <li>Bom Dia</li>
              <li>Compal</li>
              <li>Refeitório</li>
           </ul>
          </div>
        </div>
        <div class="main-section col-lg-10 p-0"> 
          <div class="content">
            <form class="search-bar">
              <input class="form-control m-3" type="text" placeholder="Search">
              <div class="filter m-3">
                <select>
                  <option selected value="">Freguesia</option>
                  <option value="">Concelho</option>
                  <option value="">Distrito</option>
                  <option value="">Tipo de instituição</option>
                  <option value="">Tipo de doação</option>
                </select>
              </div>
              <button class="search-btn m-3" type="submit" name="submit-btn"><i class="fa fa-search"></i></button>
            </form>
          </div>  
        </div>
      </div>
    </div>
</body>
</html>
