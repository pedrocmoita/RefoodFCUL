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
	$welcome = 'Bem vinda ';
}else{
	$welcome = 'Bem vindo ';
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
	$alert = '';
	if(strlen("$updated_password") < 6 || strlen("$updated_password") > 20){
		$error = "Password must have between 6 and 20 characters!";
                $error_msg = "<div class='container mt-2 mb-2 pt-2 pb-2 alert alert-danger alert-dismissible fade show' role='alert'>
                          <button type='button' class='pt-2 close' data-dismiss='alert'>&times;</button>
                          {$error}
                      </div>";
		$alert = "Failed to update! Check your profile.";
		$alert_msg = "<div style='position: absolute; top: 3%; left: 50%; transform: translate(-50%, -50%);' class='mt-3 pt-4 pb-4 alert alert-danger alert-dismissible fade show' role='alert'>
                      <button type='button' class='pt-4 close' data-dismiss='alert'>&times;</button>
                      {$alert}
                      </div>";
		echo $alert_msg;

	}else if(strlen($updated_phone) > 9){
		$error = "Phone number has a maximum of 9 digits!";
		$error_msg = "<div class='container mt-2 mb-2 pt-2 pb-2 alert alert-danger alert-dismissible fade show' role='alert'>
                          <button type='button' class='pt-2 close' data-dismiss='alert'>&times;</button>
                          {$error}
                      </div>";	
		$alert = "Failed to update! Check your profile.";	
                $alert_msg = "<div style='position: absolute; top: 3%; left: 50%; transform: translate(-50%, -50%);' class='mt-3 pt-4 pb-4 alert alert-danger alert-dismissible fa$
                      <button type='button' class='pt-4 close' data-dismiss='alert'>&times;</button>
                      {$alert}
                      </div>";
	 	echo $alert_msg;

	}else{
		$update_query = "UPDATE Voluntario SET  nome='$updated_name', numero='$updated_phone', email='$updated_email', distrito='$updated_distrito',
                concelho='$updated_concelho', freguesia='$updated_freguesia', data_nasc='$updated_birth', carta_cond='$updated_drivers',
                cartao_cidadao='$updated_cartao_cidadao', passwd='$updated_hash_password' WHERE id='$user_id'";
	        $result_update = mysqli_query($conn, $update_query);

        	$update_query2 = "UPDATE Utilizador SET nome='$updated_name', email='$updated_email', passwd='$updated_hash_password' WHERE id='$ID'";
        	$result_update2 = mysqli_query($conn, $update_query2);

        	$_SESSION['username'] = $updated_name;
        	header('location: welcome_voluntario.php');
	}	

}

//----------------Preferences section---------------------




?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/welcome.css">
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
          <p><?php echo $welcome ?><?php echo $username ?></p>
            <p><a href="login.php" style="font-size: 1.125rem; margin: 0; padding: 0;" data-toggle="modal" data-target="#logout">Logout</a></p>
            <div class="modal fade" id="logout">
              <div class="modal-dialog">
                <div class="modal-content text-center p-2">
                  <div class="modal-body">
                    <p>Are you sure you want to logout of this session?</p>
                    <div>
                      <a href="login.php" class="btn btn-danger m-2 mt-3">Yes, logout</a>
                      <button type="button" class="btn btn-success m-2 mt-3" data-dismiss="modal">Close</button>
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
                        <p>Nome</p>	
                        <input type="text" name="updated_name" value="<?php echo $username; ?>" placeholder="Insert new name" required>
                        <p>Email</p>
                        <input type="email" name="updated_email" value="<?php echo $bd_email; ?>" placeholder="Insert new email" required>
                        <p>Telemóvel</p>
                        <input type="text" name="updated_phone" value="<?php echo $bd_phone; ?>" placeholder="Insert new number" required>
                        <p>Data Nascimento</p>
                        <input type="date" name="updated_birth" value="<?php echo $bd_nascimento; ?>" required>
                        <p>Carta Condução</p>
                        <input type="text" name="updated_drivers" value="<?php echo $bd_carta_cond;  ?>" placeholder="Insert new license" required>
                      </div>
                      <div class="col">
                        <p>Distrito</p>
                        <input type="text" name="updated_distrito" value="<?php echo $bd_distrito; ?>" placeholder="Insert new distrito" required>
                        <p>Concelho</p>
                        <input type="text" name="updated_concelho" value="<?php echo $bd_concelho; ?>" placeholder="Insert new concelho" required>
                        <p>Freguesia</p>
                        <input type="text" name="updated_freguesia" value="<?php echo $bd_freguesia; ?>" placeholder="Insert new freguesia" required>
                        <p>Cartão Cidadão</p>
                        <input type="text" name="updated_cartao_cidadao" value="<?php echo $bd_cartao_cidadao; ?>" placeholder="Insert new ID" required>
                        <p>Password</p>
                        <input type="password" name="updated_password" value="" placeholder="Insert new password" required>
                      </div>
                    </div>
		    <?php echo $error_msg; ?>
                    <div><button class="profile-form-btn" type="submit" name="update-profile-btn">Update Profile</button></div>
		  </form>  
                </div>
                <div class="col-sm-5 p-0 mt-3 mb-3">
                  <h4 class="m-0">Preferências</h4>
                  <hr>
                  <div>
                    <form action="" method="post">
                      <input style="width: 50%;" type="text" placeholder="Concelho" required>
                      <div class="row mt-3"> 
                        <div class="col">
                          <label for="first_day">Dia 1</label>
                          <select name="week_days" id="first_day">
                            <option selected value="monday">Segunda</option>
                            <option value="tuesday">Terça</option>
                            <option value="wednesday">Quarta</option>
                            <option value="thursday">Quinta</option>
                            <option value="friday">Sexta</option>
                          </select>
                        </div>
                        <div class="col">
                          <label for="second_day">Dia 2<span class="text-danger">*</span></label>
                          <select name="week_days" id="second_day">
                            <option selected value="no_day2_selected">None</option>
                            <option value="monday">Segunda</option>
                            <option value="tuesday">Terça</option>
                            <option value="wednesday">Quarta</option>
                            <option value="thursday">Quinta</option>
                            <option value="friday">Sexta</option>
                          </select>
                        </div>
                      </div>
                      <div class="mt-2">
                        <label for="day_period">Período dia</label>
                        <select name="day_period" id="day_period">
                          <option selected value="morning">Manhã</option>
                          <option value="midday">Meio do dia</option>
                          <option value="afternoon">Tarde</option>
                          <option value="night">Noite</option>
                        </select>
                        <p><span class="text-danger">*</span> O segundo dia é opcional.</p>
                      </div>
		      <div><button class="profile-form-btn" type="submit">Save</button></div>
                    </form>
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