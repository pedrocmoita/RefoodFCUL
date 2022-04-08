<?php
include "abreconexao.php";

if(isset($_POST['submit-btn'])){
        $name = htmlspecialchars($_POST['name']);
        $number = htmlspecialchars($_POST['number']);
        $email = htmlspecialchars($_POST['email']);
        $birthdate = htmlspecialchars($_POST['birthdate']);
        $gender = htmlspecialchars($_POST['gender']);
        $distrito = htmlspecialchars($_POST['distrito']);
        $freguesia = htmlspecialchars($_POST['freguesia']); 
        $concelho = htmlspecialchars($_POST['concelho']); 
        $drivers = htmlspecialchars($_POST['drivers_license']);
        $personal_ID = htmlspecialchars($_POST['personal_ID']);
        $password = htmlspecialchars($_POST['password']);

        $hashpass = password_hash('$password', PASSWORD_DEFAULT);

        $select_query = "SELECT * FROM Utilizador WHERE email='$email'";
        $result_select = mysqli_query($conn, $select_query);
	
	$select_query_nr2 = "SELECT * FROM Voluntario WHERE carta_cond='$drivers'";
	$result_select_nr2 = mysqli_query($conn, $select_query_nr2);	

        $error = "";
        $success = "";
        if( (mysqli_num_rows($result_select) == 0) && (mysqli_num_rows($result_select_nr2) == 0) ){
                if(strlen("$password") < 6 || strlen("$password") > 20){
                    $error = "password must have between 6 and 20 characters.";
                    echo "<div style='position: absolute; top: 3%; left: 50%; transform: translate(-50%, -50%);' class='container mt-3 pt-4 pb-4 alert alert-danger alert-dismissible fade show' role='alert'>
                                <button type='button' class='pt-4 close' data-dismiss='alert'>&times;</button>
                                {$error}
                         </div>";             

                }else if(strlen("$number") > 9){
                    $error = "Phone number has a maximum of 9 digits.";
                    echo "<div style='position: absolute; top: 3%; left: 50%; transform: translate(-50%, -50%);' class='container mt-3 pt-4 pb-4 alert alert-danger alert-dismissible fade show' role='alert'>
                                <button type='button' class='pt-4 close' data-dismiss='alert'>&times;</button>
                                {$error}
                        </div>";

                }else if(strlen("$drivers") > 11 && strlen("$personal_ID") > 11){
                    $error = "It appears your drivers license or personal ID are incorrect.";
                    echo "<div style='position: absolute; top: 3%; left: 50%; transform: translate(-50%, -50%);' class='container mt-3 pt-4 pb-4 alert alert-danger alert-dismissible fade show' role='alert'>
                                <button type='button' class='pt-4 close' data-dismiss='alert'>&times;</button>
                                {$error}
                        </div>";

                }else{

                    if(is_numeric("$number")){
			
                        $insert_query_1 = "INSERT INTO Voluntario VALUES('id',  '$name', '$number', '$email', '$distrito', '$concelho', '$freguesia', '$gender', '$birthdate', '$drivers', '$personal_ID', '$hashpass')";
                        $result_insert_1 = mysqli_query($conn, $insert_query_1);
    
                        $insert_query_2 = "INSERT INTO Utilizador VALUES('id', '$name', '$email', '$hashpass')";
                        $result_insert_2 = mysqli_query($conn, $insert_query_2);
    
                        $success = "Registered with sucess :). You can now log into your account.";
                        echo "<div style='position: absolute; top: 3%; left: 50%; transform: translate(-50%, -50%);' class='container mt-3 pt-4 pb-4 alert alert-success alert-dismissible fade show' role='alert'>
                                    <button type='button' class='pt-4 close' data-dismiss='alert'>&times;</button>
                                    {$success}
                             </div>";

                    }else{
                        $error = "Please insert a valid phone number / drivers license / personal ID.";
                        echo "<div style='position: absolute; top: 3%; left: 50%; transform: translate(-50%, -50%);' class='container mt-3 pt-4 pb-4 alert alert-danger alert-dismissible fade show' role='alert'>
                                    <button type='button' class='pt-4 close' data-dismiss='alert'>&times;</button>
                                    {$error}
                            </div>";
                    }
                }
        }else{
                $error = "User already exists. Login into your account please.";
                echo "<div style='position: absolute; top: 3%; left: 50%; transform: translate(-50%, -50%);' class='container mt-3 pt-4 pb-4 alert alert-danger alert-dismissible fade show' role='alert'>
                          <button type='button' class='pt-4 close' data-dismiss='alert'>&times;</button>
                          {$error}
                      </div>";
        }
	
}

?>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - ReFood</title>
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-xl p-0">
        <header class="mt-3" style="display: flex; justify-content: space-between; font-family: 'Fredoka', sans-serif; font-size: 1.25rem;">
            <a class="index-btn" href="index.html">Home</a>
            <a class="index-btn" href="institution.php">Are you an Institution ?</a>
            <a class="login-btn" href="login.php">Login</a>
        </header>
        <div class="container">
            <form action="" method="post" class="volunteer p-5 m-5" id="form-volunteer">
                <h1>Volunteer</h1>
		<p class="mt-3 mb-3">Account</p>
                    <div class="row">
                        <input class="col-lg ml-3 mr-3 mt-2 mb-2 p-1" style="border: 1px solid rgb(125,125,125);" type="text" placeholder="name" name="name" required>
                        <input class="col-lg ml-3 mr-3 mt-2 mb-2 p-1" style="border: 1px solid rgb(125,125,125);" type="tel" placeholder="phone number" name="number" required>
                        <input class="col-lg ml-3 mr-3 mt-2 mb-2 p-1" style="border: 1px solid rgb(125,125,125);" type="email" placeholder="e-mail" name="email" required>
                    </div>
                    <div class="row">
                        <div class="col-lg mt-3 mb-3 p-1">
                            <label class="ml-2" for="volunteer-birth-date">Date of birth</label>
                            <input style="border: 1px solid rgb(125,125,125);" type="date" id="volunteer-birth-date" name="birthdate" required>
                        </div>
                        <div class="col-lg mt-3 mb-3">
                            <label for="volunteer-select">Gender</label>
                            <select class="volunteer-select" style="border: 1px solid rgb(125,125,125);" id="volunteer-select" name="gender">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option selected value="Other">Secret</option>
                            </select>
                        </div>
                    </div>
                <p class="mt-3 mb-3">Adress</p>
                    <div class="row">
                        <input class="col-lg ml-3 mr-3 mt-2 mb-2 p-1" style="border: 1px solid rgb(125,125,125);" type="text" placeholder="district" name="distrito" required>
                        <input class="col-lg ml-3 mr-3 mt-2 mb-2 p-1" style="border: 1px solid rgb(125,125,125);" type="text" placeholder="freguesia" name="freguesia" required>
                        <input class="col-lg ml-3 mr-3 mt-2 mb-2 p-1" style="border: 1px solid rgb(125,125,125);" type="text" placeholder="concelho" name="concelho" required>
                    </div>
                <p class="mt-3 mb-3">Final steps</p>
                    <div class="row">
                        <input class="col-lg ml-3 mr-3 mt-2 mb-2 p-1" style="border: 1px solid rgb(125,125,125);" type="text" placeholder="drivers license" name="drivers_license">
                        <input class="col-lg ml-3 mr-3 mt-2 mb-2 p-1" style="border: 1px solid rgb(125,125,125);" type="text" placeholder="personal ID" name="personal_ID">   
                        <input class="col-lg ml-3 mr-3 mt-2 mb-2 p-1" style="border: 1px solid rgb(125,125,125);" type="password" placeholder="password" name="password" id="password-volunteer">
                    </div>    
                    <hr class="m-3">               
                    <div class="row m-3">
                        <input class="col-1 mt-1" type="checkbox" id="terms-checkbox-1" required>
                        <label class="col-11" for="terms-checkbox-1" style="font-size: .8rem; opacity: .8;">I accept the terms and conditions for signing up to this service, and confirm I have read the privacy policy.</label>
                    </div> 
                <div class="row mt-3 ml-5 mr-5">
                    <button type="reset" class="btn btn-dark col ml-5 mr-5 mb-2">Clear All</button>
                    <button type="submit" class="btn btn-dark col ml-5 mr-5 mb-2" name="submit-btn">Continue</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
