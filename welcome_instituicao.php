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
//--------------BD Profile section----------------
$nova_query = "SELECT * FROM Instituicao WHERE id='$user_id'";
$novo_result = mysqli_query($conn, $nova_query);
$row_profile = mysqli_fetch_assoc($novo_result);
$bd_email = $row_profile['email'];
$bd_phone = $row_profile['numero'];
$bd_distrito = $row_profile['distrito'];
$bd_concelho = $row_profile['concelho'];
$bd_freguesia =	$row_profile['freguesia'];
$bd_adress = $row_profile['morada'];
$bd_name_charge = $row_profile['nome_contacto'];
$bd_number_charge =  $row_profile['num_contacto'];
//-------------Updating Profile section-----------
if(isset($_POST['instituicao-profile-btn'])){

	$updated_name = htmlspecialchars($_POST['updated_name']);
	$updated_email = htmlspecialchars($_POST['updated_email']);
	$updated_phone = htmlspecialchars($_POST['updated_phone']);
	$updated_person_charge = htmlspecialchars($_POST['updated_person_charge']);
	$updated_number_charge = htmlspecialchars($_POST['updated_number_charge']);
	$updated_distrito = htmlspecialchars($_POST['updated_distrito']);
	$updated_concelho = htmlspecialchars($_POST['updated_concelho']);
	$updated_freguesia = htmlspecialchars($_POST['updated_freguesia']);
	$updated_adress = htmlspecialchars($_POST['updated_adress']);
	$updated_password = htmlspecialchars($_POST['updated_password']);
	$updated_hash_password = password_hash($updated_password, PASSWORD_DEFAULT);

	$error = '';
	$error_msg = '';
	$alert = "Failed to update! Check your profile.";
	$alert_msg = "<div style='position: absolute; top: 3%; left: 50%; transform: translate(-50%, -50%);' class='mt-3 pt-4 pb-4 alert alert-danger alert-dismissible fade show' role='alert'>
			<button type='button' class='pt-4 close' data-dismiss='alert'>&times;</button>
			{$alert}
			</div>";
	
	if(strlen($updated_password) < 6 || strlen($updated_password) > 20){
		$error = "Password must have between 6 and 20 characters!";
		$error_msg = "<div class='container m-0 mt-2 pt-2 pb-2 w-50 alert alert-danger alert-dismissible fade show' role='alert'>
                    <button type='button' class='pt-2 close' data-dismiss='alert'>&times;</button>
                    {$error}
                    </div>";
		echo $alert_msg;

	}else if(strlen($updated_phone) > 9){
		$error = "Phone number has a maximum of 9 digits!";
		$error_msg = "<div class='container m-0 mt-2 pt-2 pb-2 w-50 alert alert-danger alert-dismissible fade show' role='alert'>
                          <button type='button' class='pt-2 close' data-dismiss='alert'>&times;</button>
                          {$error}
                      </div>";	
	 	echo $alert_msg;

	}else if(strlen("$updated_number_charge") > 9){
		$error = "Phone of the person in charge must have a maximum of 9 digits.";
		$error_msg = "<div class='container m-0 mt-2 pt-2 pb-2 w-50 alert alert-danger alert-dismissible fade show' role='alert'>
                        <button type='button' class='pt-2 close' data-dismiss='alert'>&times;</button>
                          {$error}
                      </div>";
                echo $alert_msg;
	}else{
		if (is_numeric("$updated_phone") && is_numeric("$updated_number_charge")){
			$update_query = "UPDATE Instituicao SET  nome='$updated_name', numero='$updated_phone', email='$updated_email', morada='$updated_adress', 
					distrito='$updated_distrito', concelho='$updated_concelho', freguesia='$updated_freguesia', nome_contacto='$updated_person_charge', 
					num_contacto='$updated_number_charge', passwd='$updated_hash_password' WHERE id='$user_id'";
			$result_update = mysqli_query($conn, $update_query);

			$update_query2 = "UPDATE Utilizador SET nome='$updated_name', email='$updated_email', passwd='$updated_hash_password' WHERE id='$ID'";
			$result_update2 = mysqli_query($conn, $update_query2);

	    		$_SESSION['username'] = $updated_name;
			header('location: welcome_instituicao.php');
		
		}else{
			$error = "Please insert valid phone numbers.";
			$error_msg = "<div class='container m-0 mt-2 pt-2 pb-2 w-50 alert alert-danger alert-dismissible fade show' role='alert'>
                          	<button type='button' class='pt-2 close' data-dismiss='alert'>&times;</button>
                          	{$error}
                      		</div>";	
			echo $alert_msg;
		}
	}
}
//---------------Preferences section--------------
if(isset($_POST['update-inst-preferences-btn'])){

	$inst_concelho = htmlspecialchars($_POST['inst_preferences_concelho']);
	$inst_type = htmlspecialchars($_POST['type']);
	$pickup_day1 = htmlspecialchars($_POST['pickup_day1']);
	$pickup_day2 = htmlspecialchars($_POST['pickup_day2']);
	$pickup_day3 = htmlspecialchars($_POST['pickup_day3']);
	$open_pickup_day1 = htmlspecialchars($_POST['open_pickup_day1']);
	$open_pickup_day2 = htmlspecialchars($_POST['open_pickup_day2']);
	$open_pickup_day3 = htmlspecialchars($_POST['open_pickup_day3']);	
	$food_type_day1 = htmlspecialchars($_POST['food_type_day1']);
	$food_type_day2 = htmlspecialchars($_POST['food_type_day2']);
	$food_type_day3 = htmlspecialchars($_POST['food_type_day3']);
	$food_quantity_day1 = htmlspecialchars($_POST['food_amount_day1']);
	$amount_type_day1 = htmlspecialchars($_POST['amount_type_day1']);
	$food_quantity_day2 = htmlspecialchars($_POST['food_amount_day2']);
	$amount_type_day2 = htmlspecialchars($_POST['amount_type_day2']);
	$food_quantity_day3 = htmlspecialchars($_POST['food_amount_day3']);
	$amount_type_day3 = htmlspecialchars($_POST['amount_type_day3']);
	$preferences_query = "SELECT * FROM Doacao WHERE id='$user_id'";
	$preferences_result = mysqli_query($conn, $preferences_query);

	if(mysqli_num_rows($preferences_result) > 0){
		$inst_preferences_update_query = "UPDATE Doacao SET concelho='$inst_concelho', tipo_instituicao='$inst_type', 
				dia_semana_1='$pickup_day1', hr_inic_dia_1 = '$open_pickup_day1', tipo_dia_1 = '$food_type_day1', quant_dia_1 = '$food_quantity_day1', 
				dia_semana_2='$pickup_day2', hr_inic_dia_2 = '$open_pickup_day2', tipo_dia_2 = '$food_type_day2', quant_dia_2 = '$food_quantity_day2', 
				dia_semana_3='$pickup_day3', hr_inic_dia_3 = '$open_pickup_day3', tipo_dia_3 = '$food_type_day3', quant_dia_3 = '$food_quantity_day3' WHERE id='$user_id'"; 
		$inst_preferences_update_result = mysqli_query($conn, $inst_preferences_update_query);	
	}else{
		$inst_preferences_insert_query = "INSERT INTO Doacao VALUES('$user_id', '$inst_concelho', '$inst_type', 
					'$pickup_day1', '$open_pickup_day1', '$food_type_day1', '$food_quantity_day1', '$amount_type_day1', 
					'$pickup_day2', '$open_pickup_day2', '$food_type_day2', '$food_quantity_day2', '$amount_type_day2', 
					'$pickup_day3', '$open_pickup_day3', '$food_type_day3', '$food_quantity_day3', '$amount_type_day3')";
		$inst_preferences_insert_result = mysqli_query($conn, $inst_preferences_insert_query);	
	}
	header('location: welcome_instituicao.php');
}
//---------------------BD PREFERENCES-------------------------
$doacao_bd_query = "SELECT * FROM Doacao WHERE id='$user_id'";
$result_doacao_bd = mysqli_query($conn, $doacao_bd_query);
$row_doacao = mysqli_fetch_assoc($result_doacao_bd);
$bd_preferences_concelho = $row_doacao['concelho'];
$bd_preferences_inst_type = $row_doacao['tipo_instituiao'];
$bd_dia_semana_1 = $row_doacao['dia_semana_1'];
$bd_hr_inic_dia_1 = $row_doacao['hr_inic_dia_1'];
$bd_tipo_dia_1 = $row_doacao['tipo_dia_1'];
$bd_quant_dia_1 = $row_doacao['quant_dia_1'];
$bd_quant_tipo_dia_1 = $row_doacao['quant_tipo_dia_1'];
$bd_dia_semana_2 = $row_doacao['dia_semana_2'];
$bd_hr_inic_dia_2 = $row_doacao['hr_inic_dia_2'];
$bd_tipo_dia_2 = $row_doacao['tipo_dia_2'];
$bd_quant_dia_2 = $row_doacao['quant_dia_2'];
$bd_quant_tipo_dia_2 = $row_doacao['quant_tipo_dia_2'];
$bd_dia_semana_3 = $row_doacao['dia_semana_3'];
$bd_hr_inic_dia_3 = $row_doacao['hr_inic_dia_3'];
$bd_tipo_dia_3 = $row_doacao['tipo_dia_3'];
$bd_quant_dia_3 = $row_doacao['quant_dia_3'];
$bd_quant_tipo_dia_3 = $row_doacao['quant_tipo_dia_3'];
//-----------------------SEARCH BAR------------------------
if(isset($_POST['teste'])){
              $searched_name = htmlspecialchars($_POST['searched_name']);
             $selected_filter = htmlspecialchars($_POST['selected_filter']);

  if($selected_filter == "freguesia" || $selected_filter == "concelho" || $selected_filter == "distrito" || $selected_filter == "nome"){
              $search_query = "SELECT * FROM Voluntario WHERE $selected_filter LIKE '%$searched_name%'";
              $search_result = mysqli_query($conn, $search_query);
  }else{
              echo "Something went wrong!";
  }
}
//-------------------------STATS---------------------------
$vol_stats = "SELECT MAX(id) AS maximumID FROM Voluntario";
$vol_stats_result = mysqli_query($conn, $vol_stats);
$vol_stats_row = mysqli_fetch_assoc($vol_stats_result);
$vol_maximumID = $vol_stats_row['maximumID'];

$inst_stats = "SELECT MAX(id) AS maximumID FROM Instituicao";
$inst_stats_result = mysqli_query($conn, $inst_stats);
$inst_stats_row = mysqli_fetch_assoc($inst_stats_result);
$inst_maximumID = $inst_stats_row['maximumID'];

$users_stats = "SELECT MAX(id) AS maximumID FROM Utilizador";
$users_stats_result = mysqli_query($conn, $users_stats);
$users_stats_row = mysqli_fetch_assoc($users_stats_result);
$users_maximumID = $users_stats_row['maximumID'];
//---------------------------------------------------------
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refood | FCUL</title>
    <link rel="stylesheet" href="css/welcome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/c63aba2ece.js" crossorigin="anonymous"></script>
    <script defer src="./script/script.js"></script>
</head>
<body>
    <div class="body">
    <header class="d-flex justify-content-between">
            <div>
              <p>Bem vinda  <span style="color: #EED202; margin-left: .125rem;"><?php echo $username ?></p>
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
                    <div class="modal-body p-0">
                      <div class="p-4">
			<form class="mb-0" action="" method="post">
                          <h3 class="m-0">Conta</h3>  
                          <hr>
                          <div class="row d-flex justify-content-around">
                            <div class="col">
                              <h5 class="mt-2 mb-2">Nome</h5>	
                              <input type="text" class="w-50" name="updated_name" value="<?php echo $username?>" placeholder="Insert new name" required>
                              <h5 class="mt-2 mb-2">Email</h5>
                              <input type="email" class="w-50" name="updated_email" value="<?php echo $bd_email ?>" placeholder="Insert new email" required>
                              <h5 class="mt-2 mb-2">Telemóvel</h5>
                              <input type="text" class="w-50" name="updated_phone" value="<?php echo $bd_phone?>" placeholder="Insert new number" required>
                              <h5 class="mt-2 mb-2">Pessoa responsável</h5>
                              <input type="text" class="w-50" name="updated_person_charge" value="<?php echo $bd_name_charge ?>" placeholder="Insert new name" required>
                              <h5 class="mt-2 mb-2">Número pessoa responsável</h5>
                              <input type="text" class="w-50" name="updated_number_charge" value="<?php echo $bd_number_charge ?>" placeholder="Insert new number" required>
			      <hr>
                              <button class="profile-form-btn m-0" type="submit" name="instituicao-profile-btn"><i class="fa-regular fa-pen-to-square"></i><span class="ml-2">Update account</span></button>
                            </div>
                            <div class="col">
                              <h5 class="mt-2 mb-2">Distrito</h5>
                              <input type="text" class="w-50" name="updated_distrito" value="<?php echo $bd_distrito ?>" placeholder="Insert new distrito" required>
                              <h5 class="mt-2 mb-2">Concelho</h5>
                              <input type="text" class="w-50" name="updated_concelho" value="<?php echo $bd_concelho ?>" placeholder="Insert new concelho" required>
                              <h5 class="mt-2 mb-2">Freguesia</h5>
                              <input type="text" class="w-50" name="updated_freguesia" value="<?php echo $bd_freguesia ?>" placeholder="Insert new freguesia" required>
                              <h5 class="mt-2 mb-2">Morada</h5>
                              <input type="text" class="w-50" name="updated_adress" value="<?php echo $bd_adress ?>" placeholder="Insert new adress" required>
                              <h5 class="mt-2 mb-2">Password</h5>
                              <input type="password" class="w-50" name="updated_password" value="" placeholder="Insert new password" required>
                              <hr>
			      <button class="delete-account-btn m-0" name="delete-account"><i class="fa-regular fa-trash-can"></i><span class="ml-2">Delete account</span></button>
                            </div>
                          </div>
			  <?php echo $error_msg; ?>
			</form>  
                      </div>
                      <div class="p-4">
			<form action="" method="post">
                        <h3 class="m-0">Preferências</h3>
                        <hr>
                        <div class="row">
                          <div class="col">
                            <h5 class="mt-2 mb-2">Local de recolha</h5>
                            <input type="text" name="inst_preferences_concelho" placeholder="Concelho" required>
                          </div>
                          <div class="col">
                            <h5 class="mt-2 mb-2">Tipo de instituição</h5>
                            <select name="type">
                              <option selected value="Cafe">Café</option>
                              <option value="Restaurante">Restaurante</option>
                              <option value="Refeitorio">Refeitório</option>
                              <option value="Supermercado">Supermercado</option>
                              <option value="Cooperativa">Cooperativa</option>
                            </select>
                         </div>
                        </div>
                        <hr class="m-4">
                        <div class="row mt-3"> 
                          <div class="col-sm">
                            <h5 class="mt-2 mb-2">Dias de recolha</h5>
                              <div>
                                <select class="mt-2 mb-2" name="pickup_day1" id="pickup_day">
                                  <option selected value="Segunda-feira">Segunda-feira</option>
                                  <option value="Terça-feira">Terça-feira</option>
                                  <option value="Quarta-feira">Quarta-feira</option>
                                  <option value="Quinta-feira">Quinta-feira</option>
                                  <option value="Sexta-feira">Sexta-feira</option>
                                </select>
                              </div>
                              <div>
                                <select class="mt-2 mb-2" name="pickup_day2">
                                  <option selected value="N/A">None</option>
                                  <option value="Segunda-feira">Segunda-feira</option>
                                  <option value="Terça-feira">Terça-feira</option>
                                  <option value="Quarta-feira">Quarta-feira</option>
                                  <option value="Quinta-feira">Quinta-feira</option>
                                  <option value="Sexta-feira">Sexta-feira</option>
                                </select>
                              </div>
                              <div>
                                <select class="mt-2 mb-2" name="pickup_day3">
                                  <option selected value="N/A">None</option>
                                  <option value="Segunda-feira">Segunda-feira</option>
                                  <option value="Terça-feira">Terça-feira</option>
                                  <option value="Quarta-feira">Quarta-feira</option>
                                  <option value="Quinta-feira">Quinta-feira</option>
                                  <option value="Sexta-feira">Sexta-feira</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm">
                              <h5 class="mt-2 mb-2">Hora de recolha</h5>
                              <div class="mt-2 mb-2">
                                <input type="time" id="pickup_hr" name="open_pickup_day1" min="09:00" max="19:00" required>
                              </div>
                              <div class="mt-2 mb-2">
                                <input type="time" name="open_pickup_day2"  min="09:00" max="19:00">
                              </div>
                              <div class="mt-2 mb-2">
                                <input type="time" name="open_pickup_day3" min="09:00" max="19:00">
                              </div>
                            </div>
                            <div class="col-sm">
                              <h5 class="mt-2 mb-2">Tipos de alimentos</h5>
                              <div>
                                <select class="mt-2 mb-2" name="food_type_day1">
                                  <option selected value="Consumo no dia">Consumo no dia</option>
                                  <option value="Longa duração">Longa duração</option>
                                </select>
                              </div>
                              <div>
                                <select class="mt-2 mb-2" name="food_type_day2">
				  <option selected value="N/A">None</option>
                                  <option value="Consumo no dia">Consumo no dia</option>
                                  <option value="Longa duração">Longa duração</option>
                                </select>
                              </div>
                              <div>
                                <select class="mt-2 mb-2" name="food_type_day3">
				  <option selected value="N/A">None</option>
                                  <option value="Consumo no dia">Consumo no dia</option>
                                  <option value="Longa duração">Longa duração</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm">
                              <h5 class="mt-2 mb-2">Quantidade de alimentos</h5>
                              <div class="mt-2 mb-2">
                                <input class="w-25" name="food_amount_day1" type="text" required>
                                <select name="amount_type_day1">
                                  <option selected value="Refeições">Refeições</option>
                                  <option value="Kg">Kg</option>
                                </select>
                              </div>
                              <div class="mt-2 mb-2">
                                <input class="w-25" name="food_amount_day2" type="text">
                                  <select name="amount_type_day2">
				    <option selected value="N/A">None</option>
                                    <option value="Refeições">Refeições</option>
                                    <option value="Kg">Kg</option>
                                  </select>
                                </div>
                                <div class="mt-2 mb-2">
                                  <input class="w-25" name="food_amount_day3" type="text">
                                  <select name="amount_type_day3">
				    <option selected value="N/A">None</option>
                                    <option value="Refeições">Refeições</option>
                                    <option value="Kg">Kg</option>
                                  </select>
                                </div>
                              </div>
                            </div>
			    <hr>
			    <button class="profile-form-btn m-0" type="submit" name="update-inst-preferences-btn"><i class="fa-regular fa-pen-to-square"></i><span class="ml-2">Update Preferences</span></button>
			   </form>
			   <button class="profile-form-btn m-0" data-toggle="modal" data-target="#preferenciasatuais"><i class="fa-regular fa-eye"></i><span class="ml-2">Show Current Preferences</span></button>
			   <div class="modal fade" id="preferenciasatuais" tabindex="-1" role="dialog" aria-labelledby="PreferenciasAtuais" aria-hidden="true">
                           <div class="modal-dialog" role="document">
                             <div class="modal-content mt-5" styles="border-radius: 0;">
                               <div class="modal-header" style="background: white; color: #EED202;">
                                 <h4 class="modal-title" id="preferenciasatuais">Current Preferences</h4>
                               </div>
                               <div class="modal-body" style="background: radial-gradient(#202020, #191919, #181818); color: white;">
                                 <h5 class="mt-2 mb-2" style="color: #EED202;">Concelho de Recolha</h5>
                                 <p><?php echo $bd_preferences_concelho ?></p>
                                 <div class="row">
                                   <div class="col">
                                     <h5 class="mt-2 mb-2" style="color: #EED202;">Dias de recolha</h5>
                                     <p><?php echo $bd_dia_semana_1; ?></p>
                                     <p><?php echo $bd_dia_semana_2; ?></p>
                                     <p><?php echo $bd_dia_semana_3; ?></p>
                                   </div>
                                   <div class="col">
                                     <h5 class="mt-2 mb-2" style="color: #EED202;">Hora de recolha</h5>
                                     <p><?php echo $bd_hr_inic_dia_1; ?></p>
                                     <p><?php echo $bd_hr_inic_dia_2 ?></p>
                                     <p><?php echo $bd_hr_inic_dia_3 ?></p>
                                   </div>
                                   <div class="col">
                                     <h5 class="mt-2 mb-2" style="color: #EED202;">Tipos de alimentos</h5>
                                     <p><?php echo $bd_tipo_dia_1 ?></p>
                                     <p><?php echo $bd_tipo_dia_2 ?></p>
                                     <p><?php echo $bd_tipo_dia_3 ?></p>
                                   </div>
                                   <div class="col">
                                     <h5 class="mt-2 mb-2" style="color: #EED202;">Quantidade de alimentos</h5>
                                     <p><?php echo  $bd_quant_dia_1 . " " . $bd_quant_tipo_dia_1 ?></p>
                                     <p><?php echo  $bd_quant_dia_2 . " " . $bd_quant_tipo_dia_2 ?></p>
                                     <p><?php echo  $bd_quant_dia_3 . " " . $bd_quant_tipo_dia_3 ?></p>
                                   </div>
                                 </div>
                               </div>
                             </div>
                           </div>
                         </div>
                       </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
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
            <h4 class="text-warning">Voluntários</h4>
            <ul>
            <?php            
	            $dias_query = "SELECT * FROM Dias WHERE concelho='$bd_preferences_concelho'";
              $dias_query_result = mysqli_query($conn, $dias_query);
              $echo = "";
              if (mysqli_num_rows($dias_query_result) > 0) {
                while($row = mysqli_fetch_assoc($dias_query_result)) {
                              if( ($bd_dia_semana_1 === $row['dia_semana_1']) || ($bd_dia_semana_1 === $row['dia_semana_2']) || ($bd_dia_semana_1 === $row['dia_semana_3']) ){
                                  $echo = "ok";
                                }else if( ($bd_dia_semana_2 === $row['dia_semana_1']) || ($bd_dia_semana_2 === $row['dia_semana_2']) || ($bd_dia_semana_2 === $row['dia_semana_3']) ){
                                  $echo = "ok";
                                }else if( ($bd_dia_semana_3 === $row['dia_semana_1']) || ($bd_dia_semana_3 === $row['dia_semana_2']) || ($bd_dia_semana_3 === $row['dia_semana_3']) ){
                                  $echo = "ok";
                                }else{
                                  $echo = "nok";
                                }
                                if ($echo === "ok"){
                                    $id = $row['id'];
                                    $query = "SELECT * FROM Voluntario WHERE id='$id'";
                                    $result = mysqli_query($conn, $query);
                                    $vol_row = mysqli_fetch_assoc($result);
                                    echo "<li>" . $vol_row['nome'] . "</li>";
                                }					
                            }
                echo "</ul>";
              }else {
                echo "<span style='opacity: .75;'>Atualize as suas preferências de modo a ter correspondências.</span>";
              }
              mysqli_close($conn);
            ?>
           </ul>
          </div>
        </div>
        <div class="main-section col-lg-10 p-0"> 
          <div class="content">
            <form action="" method="post" class="search-bar">
              <input name="searched_name" class="form-control m-3" type="text" placeholder="Pesquise um voluntário...">
              <div class="filter m-3">
                <select name="selected_filter">
                  <option selected value="freguesia">Freguesia</option>
                  <option value="concelho">Concelho</option>
                  <option value="distrito">Distrito</option>
                  <option value="nome">Nome</option>
                </select>
              </div>
              <button class="search-btn m-3" type="submit" name="teste"><i class="fa fa-search"></i></button>
            </form>
          </div>
          <table class="d-flex justify-content-center mt-5">
	  <?php 
            if(mysqli_num_rows($search_result) > 0){
	      echo "<tr><th></th><th>Nome</th><th>Distrito</th><th>Concelho</th><th>Freguesia</th></tr>";
              while($row = mysqli_fetch_assoc($search_result)){
                echo '<tr><td><i class="fa-solid fa-address-card" data-toggle="modal" data-target="#info"></i>  
                      <div class="modal" id="info">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Info</h5>
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">' . 
                          '<div><p style="color: #EED202;">Contactos</p>' . 
                            '<p><i class="fa-solid fa-mobile mr-2"></i>' . $row['numero'] . '</p>' . 
                            '<p><i class="fa-solid fa-envelope mr-2"></i>' . $row['email'] . '</p>' . 
                          '</div>' .
                          '<div><p style="color: #EED202;">Concelho de Recolha</p>' . '</div>' . 
                           '</div>
                          </div>
                        </div>
                      </div></td><td>' . $row["nome"] . "</td><td>" . $row["distrito"] . "</td><td>" . $row["concelho"] . "</td><td>" . $row["freguesia"] . "</td></tr>";
              }
              echo "</table>";
            }else{
              echo "<tr><td>No results found yet...</td></tr>";
            }
          ?>
          </table>  
          <p class="text-center mt-5 font-weight-bold" style="color: white;">O <span style="color: #EED202;">IMPACTO</span> REFOOD EM <span style="color: black;">NÚMEROS.</span></p>
          <div class="row d-flex justify-content-center mt-5">
            <div class="col-lg-2">
               <div class="counter-box">
                  <i class="fa fa-group"></i>
                  <span class="counter"><?php echo $users_maximumID; ?></span>
                  <p>Utilizadores</p>
               </div>
            </div>
            <div class="col-lg-2">
              <div class="counter-box">
                <i class="fa-solid fa-building-columns"></i>
                <span class="counter"><?php echo $inst_maximumID ?></span>
                <p>Instituições</p>
              </div>
            </div>
            <div class="col-lg-2">
               <div class="counter-box">
                <i class="fa  fa-user"></i>
                <span class="counter"><?php echo $vol_maximumID ?></span>
                <p>Voluntários</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</body>
</html>