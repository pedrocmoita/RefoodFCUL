<?php

session_start();

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
	header("location: login.php");
	exit;
}

$username = $_SESSION['username'];

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
              <p>Bem-vinda <?php echo $username ?> </p>
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
                  <form action="">
                    <!-- Modal Header -->
                    <div class="modal-header">
                      <h4 class="modal-title">Profile</h4>
                      <button style="color: #EED202;" type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <!-- Modal body -->
                    <div class="modal-body row p-0 justify-content-around">
                      <div class="col-sm-5 p-0 mt-3 mb-3">
                        <h4 class="m-0">Conta</h4>  
                        <hr>
                        <div>
                          <input type="text">
                          <input type="text">
                          <input type="text">
                          <input type="text">
                          <input type="text">
                          <input type="text">
                          <input type="text">
                          <input type="text">
                        </div>  
                      </div>
                      <div class="col-sm-5 p-0 mt-3 mb-3">
                        <h4 class="m-0">Preferências</h4>
                        <hr>
                        <div>
                          <input class="" style="width: 50%;" type="text" placeholder="Concelho">
                          <div class="row mt-3"> 
                            <div class="col">
                               <label for="institution_type">Tipo de instituição</label>
                                  <select class="" name="institution_type" id="institution_type">
                 	                 <option selected value="coffee">Café</option>
                                         <option value="restaurant">Restaurante</option>
                                         <option value="refectory">Refeitório</option>
                                         <option value="market">Supermercado</option>
                                         <option value="cooperative">Cooperativa</option>
                                  </select>
                            </div>
                            <div class="col">
                               <label for="food_type">Tipos alimentos</label>
                                  <select class="" name="food_type" id="food_type">
                                       <option selected value="day_consumed">Consumo no dia</option>
                                       <option value="long_consumed">Longa duração</option>
                                  </select>
                            </div>
                          </div>
                          <div class="row mt-3"> 
                               <div class="col-sm">
                                   <label for="pickup_hr">Hora de recolha</label>
                                   <input type="time" id="pickup_hr" name="pickup_hr" min="09:00" max="19:00">
                               </div>
                               <div class="col-sm">
                                   <label for="pickup_day">Dia de recolha</label>
                                   <select class="" name="pickup_day" id="pickup_day">
                   	                <option selected value="monday">Segunda</option>
                                        <option value="tuesday">Terça</option>
                                        <option value="wednesday">Quarta</option>
                                        <option value="thursday">Quinta</option>
                                        <option value="friday">Sexta</option>
                                   </select>
                              </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                      <button type="submit" class="modal-save-btn">Save</button>
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
