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

	$update_query = "UPDATE Instituicao SET  nome='$updated_name', numero='$updated_phone', email='$updated_email', morada='$updated_adress', 
                    distrito='$updated_distrito', concelho='$updated_concelho', freguesia='$updated_freguesia', nome_contacto='$updated_person_charge', 
                    num_contacto='$updated_number_charge', passwd='$updated_hash_password' WHERE id='$user_id'";
	$result_update = mysqli_query($conn, $update_query);

	$update_query2 = "UPDATE Utilizador SET nome='$updated_name', email='$updated_email', passwd='$updated_hash_password' WHERE id='$ID'";
	$result_update2 = mysqli_query($conn, $update_query2);

	$_SESSION['username'] = $updated_name;
	header('location: welcome_instituicao.php');

}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
              <p>Bem vinda  <span style="color: #EED202; margin-left: .125rem;"><?php echo $username ?></p>
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
                  <form action="" method="post">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Profile</h4>
                      <button style="color: #EED202;" type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body p-0">
                      <div class="p-4">
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
                      </div>
                      <div class="p-4">
                        <h3 class="m-0">Preferências</h3>
                        <hr>
                        <div class="row">
                          <div class="col">
                            <h5 class="mt-2 mb-2">Local de recolha</h5>
                            <input type="text" placeholder="Concelho">
                          </div>
                          <div class="col">
                            <h5 class="mt-2 mb-2">Tipo de instituição</h5>
                            <select name="institution_type" id="institution_type">
                              <option selected value="coffee">Café</option>
                              <option value="restaurant">Restaurante</option>
                              <option value="refectory">Refeitório</option>
                              <option value="market">Supermercado</option>
                              <option value="cooperative">Cooperativa</option>
                            </select>
                         </div>
                        </div>
                        <hr class="m-4">
                        <div class="row mt-3"> 
                          <div class="col-sm">
                            <h5 class="mt-2 mb-2">Dias de recolha</h5>
                              <div>
                                <select class="mt-2 mb-2" name="pickup_day_1" id="pickup_day">
                                  <option selected value="Segunda-feira">Segunda-feira</option>
                                  <option value="Terça-feira">Terça-feira</option>
                                  <option value="Quarta-feira">Quarta-feira</option>
                                  <option value="Quinta-feira">Quinta-feira</option>
                                  <option value="Sexta-feira">Sexta-feira</option>
                                </select>
                              </div>
                              <div>
                                <select class="mt-2 mb-2" name="pickup_day_2">
                                  <option selected value="no_day_selected">None</option>
                                  <option value="Segunda-feira">Segunda-feira</option>
                                  <option value="Terça-feira">Terça-feira</option>
                                  <option value="Quarta-feira">Quarta-feira</option>
                                  <option value="Quinta-feira">Quinta-feira</option>
                                  <option value="Sexta-feira">Sexta-feira</option>
                                </select>
                              </div>
                              <div>
                                <select class="mt-2 mb-2" name="pickup_day_3">
                                  <option selected value="no_day_selected">None</option>
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
                                <input type="time" id="pickup_hr" name="open_pick_up_day1" min="09:00" max="19:00">
                                às
                                <input type="time" name="close_pick_up_day1" min="10:00" max="20:00">
                              </div>
                              <div class="mt-2 mb-2">
                                <input type="time" name="open_pick_up_day2"  min="09:00" max="19:00">
                                às
                                <input type="time" name="close_pick_up_day2" min="10:00" max="20:00">
                              </div>
                              <div class="mt-2 mb-2">
                                <input type="time" name="open_pick_up_day3" min="09:00" max="19:00">
                                  às
                                <input type="time" name="close_pick_up_day3" min="10:00" max="20:00">
                              </div>
                            </div>
                            <div class="col-sm">
                              <h5 class="mt-2 mb-2">Tipos de alimentos</h5>
                              <div>
                                <select class="mt-2 mb-2" name="food_type_1">
                                  <option selected value="day_consumed">Consumo no dia</option>
                                  <option value="long_consumed">Longa duração</option>
                                </select>
                              </div>
                              <div>
                                <select class="mt-2 mb-2" name="food_type_2">
				  <option selected value="N/A">None</option>
                                  <option value="day_consumed">Consumo no dia</option>
                                  <option value="long_consumed">Longa duração</option>
                                </select>
                              </div>
                              <div>
                                <select class="mt-2 mb-2" name="food_type_3">
				  <option selected value="N/A">None</option>
                                  <option value="day_consumed">Consumo no dia</option>
                                  <option value="long_consumed">Longa duração</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm">
                              <h5 class="mt-2 mb-2">Quantidade de alimentos</h5>
                              <div class="mt-2 mb-2">
                                <input style="width: 25%;" type="number">
                                <select name="">
                                  <option value="">Kg</option>
                                  <option value="">Refeições</option>
                                </select>
                              </div>
                              <div class="mt-2 mb-2">
                                <input style="width: 25%;" type="number">
                                  <select name="">
                                    <option value="">Kg</option>
                                    <option value="">Refeições</option>
                                  </select>
                                </div>
                                <div class="mt-2 mb-2">
                                  <input style="width: 25%;" type="number">
                                  <select name="">
                                    <option value="">Kg</option>
                                    <option value="">Refeições</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <button type="button" data-dismiss="modal">Close</button>
                    </div>
                  </form>
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
              <li>André</li>
              <li>João</li>
              <li>Afonso</li>
              <li>Pedro</li>
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