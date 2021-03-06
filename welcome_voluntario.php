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
	
	$success = "Profile updated with success!";
        $success_msg = "<div style='position: absolute; top: 3%; left: 50%; transform: translate(-50%, -50%);' class='mt-3 pt-4 pb-4 alert alert-success alert-dismissible fade show' role='alert'>
                        <button type='button' class='pt-4 close' data-dismiss='alert'>&times;</button>
                        {$success}
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
			echo $success_msg;
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

//-------------------------SEARCH BAR---------------------------
if(isset($_POST['teste'])){
 		$searched_name = htmlspecialchars($_POST['searched_name']);
                $selected_filter = htmlspecialchars($_POST['selected_filter']);

		if($selected_filter == "freguesia" || $selected_filter == "concelho" || $selected_filter == "distrito" || $selected_filter == "nome"){
                  $search_query = "SELECT * FROM Instituicao WHERE $selected_filter LIKE '%$searched_name%'";
                  $search_result = mysqli_query($conn, $search_query);

                }else if($selected_filter == "tipo_instituicao"){
		  $search_query_2 = "SELECT * FROM Doacao WHERE $selected_filter LIKE '%$searched_name%'";
                  $search_result_2 = mysqli_query($conn, $search_query_2);
                  $InstNomes_arr = array();
        	  $InstType_arr = array(); 
		  $InstConcelho_arr = array();
	          while($row_2 = mysqli_fetch_assoc($search_result_2)){
                    $search_inst_id = $row_2['id'];
                    $search_inst_query = "SELECT * FROM Instituicao WHERE id='$search_inst_id'";
                    $search_inst_result = mysqli_query($conn, $search_inst_query);
                    $inst = mysqli_fetch_assoc($search_inst_result);
		    $new = array_push($InstNomes_arr, $inst['nome']);
		    $new1 = array_push($InstType_arr, $row_2['tipo_instituicao']);
                    $new2 = array_push($InstConcelho_arr, $row_2['concelho']);
                  }
                  $arrlength = count($InstNomes_arr);
                }else{
                  echo "something went wrong!";
                }
}
//--------------------------STATS----------------------------
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
//----------------------------------------------------------
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refood | FCUL</title>
    <link rel="stylesheet" href="css/welcome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
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
          <p><?php echo $welcome ?> <span style="color: #EED202; margin-left: .125rem;"><?php echo $username ?></span></p>
          <p><i class="fa-solid fa-right-from-bracket mt-1" data-toggle="modal" data-target="#logout"></i></p>
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
                <h3 class="modal-title">Profile</h3>
                <button style="color: #EED202;" type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <!-- Modal body -->
              <div class="profile modal-body row p-0 justify-content-around">
                <div class="col-sm-5 p-0 mt-3 mb-3">
                  <h3 class="m-0">Conta</h3>  
                  <hr>
		  <form action="" method="post">
                    <div class="row">
                      <div class="col">
                        <h5 class="mt-2 mb-2">Nome</h5>	
                        <input type="text" name="updated_name" value="<?php echo $username; ?>" placeholder="Insert new name" required>
                        <h5 class="mt-2 mb-2">Email</h5>
                        <input type="email" name="updated_email" value="<?php echo $bd_email; ?>" placeholder="Insert new email" required>
                        <h5 class="mt-2 mb-2">Telem??vel</h5>
                        <input type="text" name="updated_phone" value="<?php echo $bd_phone; ?>" placeholder="Insert new number" required>
                        <h5 class="mt-2 mb-2">Data Nascimento</h5>
                        <input type="date" name="updated_birth" value="<?php echo $bd_nascimento; ?>" required>
                        <h5 class="mt-2 mb-2">Carta Condu????o</h5>
                        <input type="text" name="updated_drivers" value="<?php echo $bd_carta_cond;  ?>" placeholder="Insert new license" required>
			<hr>
			<button class="profile-form-btn m-0" type="submit" name="update-profile-btn"><i class="fa-regular fa-pen-to-square"></i><span class="ml-2">Update account</span></button>
		      </div>
                      <div class="col">
                        <h5 class="mt-2 mb-2">Distrito</h5>
                        <input type="text" name="updated_distrito" value="<?php echo $bd_distrito; ?>" placeholder="Insert new distrito" required>
                        <h5 class="mt-2 mb-2">Concelho</h5>
                        <input type="text" name="updated_concelho" value="<?php echo $bd_concelho; ?>" placeholder="Insert new concelho" required>
                        <h5 class="mt-2 mb-2">Freguesia</h5>
                        <input type="text" name="updated_freguesia" value="<?php echo $bd_freguesia; ?>" placeholder="Insert new freguesia" required>
                        <h5 class="mt-2 mb-2">Cart??o Cidad??o</h5>
                        <input type="text" name="updated_cartao_cidadao" value="<?php echo $bd_cartao_cidadao; ?>" placeholder="Insert new ID" required>
                        <h5 class="mt-2 mb-2">Password</h5>
                        <input type="password" name="updated_password" value="" placeholder="Insert new password" required>
			<hr>
			<button class="delete-account-btn m-0" name="delete-account"><i class="fa-regular fa-trash-can"></i><span class="ml-2">Delete account</span></button>
		      </div>
                    </div>
		    <?php echo $error_msg; ?>
		  </form>  
                </div>
                <div class="col-sm-5 p-0 mt-3 mb-3">
                  <h3 class="m-0">Prefer??ncias</h3>
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
                                <option selected value="Segunda-feira">Segunda</option>
                                <option value="Ter??a-feira">Ter??a</option>
                                <option value="Quarta-feira">Quarta</option>
                                <option value="Quinta-feira">Quinta</option>
                                <option value="Sexta-feira">Sexta</option>
                              </select>
                            </div>
                            <div class="mt-3 mb-3">
                              <select name="pickup_day_2">
                                <option selected value="">None</option>
                                <option value="Segunda-feira">Segunda</option>
                                <option value="Ter??a-feira">Ter??a</option>
                                <option value="Quarta-feira">Quarta</option>
                                <option value="Quinta-feira">Quinta</option>
                                <option value="Sexta-feira">Sexta</option>
                              </select>
                            </div>
                            <div class="mt-3 mb-3">
                              <select name="pickup_day_3">
                                <option selected value="">None</option>
                                <option value="Segunda-feira">Segunda</option>
                                <option value="Ter??a-feira">Ter??a</option>
                                <option value="Quarta-feira">Quarta</option>
                                <option value="Quinta-feira">Quinta</option>
                                <option value="Sexta-feira">Sexta</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-sm">
                          <label for="pickup_hr"><h5 class="mt-2 mb-2">Per??odos de recolha</h5></label>
                            <div class="mb-3">
                              <select name="pickup_period_1">
                                <option selected value="Manh??">Manh??</option>
                                <option value="Tarde">Tarde</option>
                                <option value="Noite">Noite</option>
                              </select>
                            </div>
                            <div class="mt-3 mb-3">
                              <select name="pickup_period_2">
                                <option value="">None</option>
                                <option value="Manha">Manh??</option>
                                <option value="Tarde">Tarde</option>
                                <option value="Noite">Noite</option>
                              </select>
                            </div>
                            <div class="mt-3 mb-3">
                              <select name="pickup_period_3">
                                <option value="">None</option>
                                <option value="Manha">Manh??</option>
                                <option value="Tarde">Tarde</option>
                                <option value="Noite">Noite</option>
                              </select>
                            </div>
                          </div>
                        </div>
			<hr>
                        <button class="profile-form-btn m-0" type="submit" name="update-preferences-btn"><i class="fa-regular fa-pen-to-square"></i><span class="ml-2">Update Preferences</span></button>
                    </form>
		    <button class="profile-form-btn m-0" data-toggle="modal" data-target="#preferenciasatuais"><i class="fa-regular fa-eye"></i><span class="ml-2">Show Current Preferences</span></button>
		    <div class="modal fade" id="preferenciasatuais" tabindex="-1" role="dialog" aria-labelledby="PreferenciasAtuais" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content mt-5" styles="border-radius: 0;">
                          <div class="modal-header" style="background: white; color: #EED202;">
                            <h4 class="modal-title" id="preferenciasatuais">Current Preferences</h4>
                          </div>
                          <div class="modal-body" style="background: radial-gradient(#202020, #191919, #181818); color: white;">
                          <h5 class="mt-2 mb-2" style="color: #EED202;">Concelho</h5>
                            <p><?php echo $bd_preferences_concelho ?></p>
                            <div class="row">
                              <div class="col">
                                <h5 class="mt-2 mb-2" style="color: #EED202;">Dias de recolha</h5>
                                <p><?php echo $bd_dia_semana_1; ?></p>
                                <p><?php echo $bd_dia_semana_2; ?></p>
                                <p><?php echo $bd_dia_semana_3; ?></p>
                              </div>
                              <div class="col">
                                <h5 class="mt-2 mb-2" style="color: #EED202;">Per??odos de recolha</h5>
                                <p><?php echo $bd_periodo_1; ?></p>
                                <p><?php echo $bd_periodo_2; ?></p>
                                <p><?php echo $bd_periodo_3; ?></p>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
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
                  <h4 style="color: #EED202;">O que ?? a barra do lado esquerdo com nomes de institui????es?</h4>
                        <p>A barra esquerda tem todas as correspond??ncias entre o volunt??rio e as institui????es.</p>
                  <h4 style="color: #EED202;">As correspond??ncias consistem no qu???</h4>
                        <p>As correspond??ncias querem dizer que os seus dias de recolha e a localiza????o est??o de acordo com as prefer??ncias das institui????es.</p>
                  <h4 style="color: #EED202;">Como entro em contacto com uma institui????o?</h4>
                        <p>Para entrar em contacto com uma institui????o basta pesquisar o nome da mesma, por exemplo, e carregando no bot??o de informa????o, ter?? ?? sua disponibilidade
                        os v??rios contactos assim como um chat pelo qual podem conversar.</p>
                  <h4 style="color: #EED202;">Posso alterar as minhas prefer??ncias e/ou defini????es pessoais, e onde?</h4>
                        <p>Pode alterar todas as prefer??ncias e defini????es pessoais na ??rea do perfil. (canto superior direito)</p>
                        de alimentos que quiser, que pode posterioromente alterar quando quiser.</p>
		  <h4 style="color: #EED202;">Na barra de pesquisa se pesquisar por concelho, ?? o concelho de recolha?</h4>
			<p class="m-0">N??o, ?? o concelho que a institui????o tem como concelho de resid??ncia. No entanto, normalmente os concelhos de recolha s??o os mesmo que os de resid??ncia das
			institui????es. Caso isto n??o se verifique, pode sempre entrar em contacto com a institui????o para discutir pormenores.</p>
              </div>
              <!-- Modal footer -->
              <div class="modal-footer">
                <button class="m-0" type="button" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="lista col-lg-2 text-center">
          <div class="m-3">
            <h4 class="text-warning mt-5 mb-3">Institui????es</h4>
		<ul>
	           <?php            
			$doacao_query = "SELECT * FROM Doacao WHERE concelho='$bd_preferences_concelho'";
			$doacao_query_result = mysqli_query($conn, $doacao_query);
			$echo = "";
			if (mysqli_num_rows($doacao_query_result) > 0) {
				while($row = mysqli_fetch_assoc($doacao_query_result)) {
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
                    				$query = "SELECT * FROM Instituicao WHERE id='$id'";
                    				$result = mysqli_query($conn, $query);
                    				$inst_row = mysqli_fetch_assoc($result);
                    				echo "<li>" . $inst_row['nome'] . "</li>";
                  			}					
                		}
				echo "</ul>";
			}else {
				echo "<span style='opacity: .75;'>Atualize as suas prefer??ncias de modo a ter correspond??ncias.</span>";
			}
			mysqli_close($conn);
		    ?>
		</ul>
          </div>
        </div>
        <div class="main-section col-lg-10 p-0"> 
          <div class="content">
            <form action="" method="post" class="search-bar">
              <input name="searched_name" class="form-control m-3" type="text" placeholder="Pesquise uma institui????o">
              <div class="filter m-3">
                <select name="selected_filter">
                  <option selected value="freguesia">Freguesia</option>
                  <option value="concelho">Concelho</option>
                  <option value="distrito">Distrito</option>
                  <option value="tipo_instituicao">Tipo Institui????o</option>
                  <option value="nome">Nome</option>
                </select>
              </div>
              <button class="search-btn m-3" type="submit" name="teste"><i class="fa fa-search"></i></button>
            </form>
          </div>
          <table class="d-flex justify-content-center mt-5">
	  <?php 
            if(mysqli_num_rows($search_result) > 0){
		echo "<tr><th></th><th>Nome</th><th>Morada</th><th>Distrito</th><th>Concelho</th><th>Freguesia</th></tr>";
              while($row = mysqli_fetch_assoc($search_result)){
		$id = $row['id'];
		$nome = $row['nome'];
		$morada = $row['morada'];
		$distrito = $row['distrito'];
		$concelho = $row['concelho'];
		$freguesia = $row['freguesia'];
    		echo 	'<tr>
			<td>' . '<button class="profile-form-btn m-0 mr-3"><a style="text-decoration: none;" class="info-btn" href="info.php?infoid=' . $id . '">Info</a></button></td>
			<td>' . $nome . '</td>
			<td>' . $morada . '</td>
			<td>' . $distrito . '</td>
			<td>' . $concelho . '</td>
			<td>' . $freguesia . '</td>
			</tr>';
              }
              echo "</table>";

            }else if(mysqli_num_rows($search_result_2) > 0){
		echo "<tr><th>Nome</th><th>Tipo Institui????o</th><th>Concelho Recolha</th></tr>"; 
               for($x = 0; $x < $arrlength; $x++) {
                  echo "<tr><td>" . $InstNomes_arr[$x] . "</td><td>" . $InstType_arr[$x] . "</td><td>" . $InstConcelho_arr[$x] . "</td></tr>";
                }              
              echo "</table>";
            }else{
              echo "<tr><td>No results found yet...</td></tr>";
            }
          ?>
          </table>
	  <p class="text-center mt-5 font-weight-bold" style="color: white;">O <span style="color: #EED202;">IMPACTO</span> REFOOD EM <span style="color: black;">N??MEROS.</span></p>
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
                <span class="counter"><?php echo $inst_maximumID; ?></span>
                <p>Institui????es</p>
              </div>
            </div>
            <div class="col-lg-2">
               <div class="counter-box">
                <i class="fa  fa-user"></i>
                <span class="counter"><?php echo $vol_maximumID; ?></span>
                <p>Volunt??rios</p>
              </div>
            </div>
          </div>	
        </div>
      </div>
    </div>
</body>
</html>
