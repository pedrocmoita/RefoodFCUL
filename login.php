<?php

include "abreconexao.php";

if(isset($_POST['submit-btn'])){

    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $select_query = "SELECT * FROM Utilizador WHERE email='$email'";
    $result_select = mysqli_query($conn, $select_query);

    $error = "";

    if($email === 'admin_asw13@fculti.com' && $password === 'admin_password'){
        header("Location: admin.php");
    }else{
        if(mysqli_num_rows($result_select) == 0){
		$error = "Email or password incorrect.";
                echo "<div style='position: absolute; top: 3%; left: 50%; transform: translate(-50%, -50%);' class='container mt-3 pt-4 pb-4 alert alert-danger alert-dismissible fade show' role='alert'>
                	<button type='button' class='pt-4 close' data-dismiss='alert'>&times;</button>
                	{$error}
                     </div>";
        }else{
		$select_query_2 = "SELECT passwd FROM Utilizador WHERE email='$email'";
		$result_select_2 = mysqli_query($conn, $select_query_2);
                $row = mysqli_fecth_assoc($result_select_2);

		if(password_verify($password, $row['passwd'])){
			 header("Location: welcome.php");
			
		}else{
			$error = "Email or password incorrect.";
               		echo "<div style='position: absolute; top: 3%; left: 50%; transform: translate(-50%, -50%);' class='container mt-3 pt-4 pb-4 alert alert-danger alert-dismissible fade show' role='alert'>
                       		<button type='button' class='pt-4 close' data-dismiss='alert'>&times;</button>
                        	{$error}
                     	     </div>";
		}
        }
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ReFood</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/c63aba2ece.js" crossorigin="anonymous"></script>
</head>
<body>
    <header class="login-header" style="width: 95%; max-width: 1150px; margin: 0 auto;">
        <a style="text-decoration: none;"  href="index.html">Home</a>
        <a style="text-decoration:none;" href="signup.php">Sign up</a>
    </header>
    <div class="teste">
   	 <form action="" method="post" class="login-form">
            <h1>Login</h1>
            <div class="login-form__input" style="margin-bottom: 2rem;"><i class="fa-solid fa-envelope" style="margin: 1rem; color: rgb(45, 45, 45);"></i><input type="email" name="email" placeholder="name@example.com" required></div>
            <div class="login-form__input"><i class="fa-solid fa-key" style="margin: 1rem; color: rgb(45, 45, 45);"></i><input type="password" name="password" placeholder="password" required></div>
            <div class="login-form__btn-area">
                <button type="reset">Clear All</button>
                <button type="submit" name="submit-btn">Continue</button>
            </div>
   	 </form>
         <img src="images/login-bg.png" alt="">
    </div>
</body>
</html>
