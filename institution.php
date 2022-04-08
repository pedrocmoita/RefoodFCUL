<?php

include "abreconexao.php";

if(isset($_POST['submit-btn'])){
	$name = htmlspecialchars($_POST['name']);
	$number = htmlspecialchars($_POST['number']);	
	$email = htmlspecialchars($_POST['email']);
        $distrito = htmlspecialchars($_POST['distrito']);
        $freguesia = htmlspecialchars($_POST['freguesia']);
        $concelho = htmlspecialchars($_POST['concelho']);
        $adress = htmlspecialchars($_POST['adress']);
        $name_charge = htmlspecialchars($_POST['name_charge']);
        $number_charge = htmlspecialchars($_POST['number_charge']); 
        $password = htmlspecialchars($_POST['password']);

        $hashpass = password_hash('$password', PASSWORD_DEFAULT);

        $select_query = "SELECT * FROM Utilizador WHERE email='$email'";
        $result_select = mysqli_query($conn, $select_query);

        $error = "";
        $success = "";
        if(mysqli_num_rows($result_select) == 0){
                if(strlen("$password") < 6 || strlen("$password") > 20){
                    $error = "Password must have between 6 and 20 characters.";
		    echo "<div style='position: absolute; top: 3%; left: 50%; transform: translate(-50%, -50%);' class='container mt-3 pt-4 pb-4 alert alert-danger alert-dismissible fade show' role='alert'> 
				<button type='button' class='pt-4 close' data-dismiss='alert'>&times;</button>
				{$error} 
			</div>";

                }else if(strlen("$number") > 9){
		    $error = "Phone number must have a maximum of 9 digits.";
	            echo "<div style='position: absolute; top: 3%; left: 50%; transform: translate(-50%, -50%);' class='container mt-3 pt-4 pb-4 alert alert-danger alert-dismissible fade show' role='alert'>
                                <button type='button' class='pt-4 close' data-dismiss='alert'>&times;</button>
                                {$error}
                        </div>";

		}else if(strlen("$number_charge") > 9){
		   $error = "Phone of the person in charge must have a maximum of 9 digits.";
		    echo "<div style='position: absolute; top: 3%; left: 50%; transform: translate(-50%, -50%);' class='container mt-3 pt-4 pb-4 alert alert-danger alert-dismissible fade show' role='alert'>
                                <button type='button' class='pt-4 close' data-dismiss='alert'>&times;</button>
                                {$error}
                        </div>";

		}else{
		    if (is_numeric("$number") && is_numeric("$number_charge")){

                        $insert_query = "INSERT INTO Instituicao VALUES('id', '$name', '$number', '$email', '$adress', '$distrito', '$concelho', '$freguesia', '$name_charge', '$number_charge', '$hashpass')";
                        $result_insert = mysqli_query($conn, $insert_query);
    
                        $insert_query_2 = "INSERT INTO Utilizador VALUES('id', '$name', '$email', '$hashpass')";
                        $result_insert_2 = mysqli_query($conn, $insert_query_2);

                        $success = "Registered with sucess :). You can now log into your account.";
                        echo "<div style='position: absolute; top: 3%; left: 50%; transform: translate(-50%, -50%);' class='container mt-3 pt-4 pb-4 alert alert-success alert-dismissible fade show' role='alert'>
                                    <button type='button' class='pt-4 close' data-dismiss='alert'>&times;</button>
                                    {$success}
                             </div>";

                    }else{
                        $error = "Phone number must be an integer.";
                        echo "<div style='position: absolute; top: 3%; left: 50%; transform: translate(-50%, -50%);' class='container mt-3 pt-4 pb-4 alert alert-danger alert-dismissible fade show' role='alert'>
                                  <button type='button' class='pt-4 close' data-dismiss='alert'>&times;</button>
                                  {$error}
                              </div>";
                    }
                }
        }else{
                $error = "User already exists. Log into your account please.";
                echo "<div style='position: absolute; top: 3%; left: 50%; transform: translate(-50%, -50%);' class='container mt-3 pt-4 pb-4 alert alert-danger alert-dismissible fade show' role='alert'>
                          <button type='button' class='pt-4 close' data-dismiss='alert'>&times;</button>
                          {$error}
                      </div>";
        }
}
?>

<html lang="en">
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
            <a class="index-btn" href="signup.php">Are you a Volunteer ?</a>
            <a class="login-btn" href="login.php">Login</a>
        </header>
        <div class="container">
            <form action="" method="post" class="institution p-5 m-5" id="form-institution">
                <h1>Institution</h1>
                <p class="mt-3 mb-3">Account</p>
                    <div class="row">
                        <input class="col-lg ml-3 mr-3 mt-2 mb-2 p-1" style="border: 1px solid rgb(125,125,125);" type="text" placeholder="name" name="name" required>
                        <input class="col-lg ml-3 mr-3 mt-2 mb-2 p-1" style="border: 1px solid rgb(125,125,125);" type="tel" placeholder="phone number" name="number" required>
                        <input class="col-lg ml-3 mr-3 mt-2 mb-2 p-1" style="border: 1px solid rgb(125,125,125);" type="email" placeholder="e-mail" name="email" required>
                    </div>
                <p class="mt-3 mb-3">Adress</p>
                    <div class="row">
                        <input class="col-lg ml-3 mr-3 mt-2 mb-2 p-1" style="border: 1px solid rgb(125,125,125);" type="text" placeholder="district" name="distrito" required>
                        <input class="col-lg ml-3 mr-3 mt-2 mb-2 p-1" style="border: 1px solid rgb(125,125,125);" type="text" placeholder="concelho" name="concelho" required>
                        <input class="col-lg ml-3 mr-3 mt-2 mb-2 p-1" style="border: 1px solid rgb(125,125,125);" type="text" placeholder="freguesia" name="freguesia" required>
                    </div>
                    <div class="row">
                        <input class="col-lg ml-3 mr-3 mt-2 mb-2 p-1" style="border: 1px solid rgb(125,125,125);" type="text" placeholder="adress" name="adress" required>
                        <div class="col-lg ml-3 mr-3 mt-2 mb-2 p-1"></div>
                        <div class="col-lg ml-3 mr-3 mt-2 mb-2 p-1"></div>
                    </div>
                <p class="mt-3 mb-3">Final steps</p>
                    <div class="row">
                        <input class="col-lg ml-3 mr-3 mt-2 mb-2 p-1" style="border: 1px solid rgb(125,125,125);" type="text" placeholder="name person in charge" name="name_charge" required>
                        <input class="col-lg ml-3 mr-3 mt-2 mb-2 p-1" style="border: 1px solid rgb(125,125,125);" type="tel" placeholder="number person in charge" name="number_charge" required>
                        <input class="col-lg ml-3 mr-3 mt-2 mb-2 p-1" style="border: 1px solid rgb(125,125,125);" type="password" placeholder="password" name="password" id="password-institution" required>
                    </div>
                    <hr>
                    <div class="row m-3">
                        <input class="col-1 mt-1" type="checkbox" id="terms-checkbox-2" required>
                        <label class="col-11 pl-0" for="terms-checkbox-2" style="font-size: .8rem; opacity: .8;">I accept the terms and conditions for signing up to this service, and confirm I have read the privacy policy.</label>
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
