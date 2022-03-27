<?php

include "abreconexao.php";

if(isset($_POST['submit-btn'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $select_query = "SELECT * FROM utilizador WHERE nome='$name'";
    $result_select = mysqli_query($conn, $select_query);

    if($name === 'admin_asw13' && $password === 'admin_password'){
        header("Location: admin.php");
        //echo "admin area found";
    }else{
        if(mysqli_num_rows($result_select) == 0){
            echo 'username or password incorrect.';
        }else{
            header('Location: welcome.php');
            //echo "Welcome user";
        }
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Refood Fcul</title>
</head>
<body>
<form action="" method="post">
        Name: <input type="text" name="name" placeholder="name" required> <br>
        Password: <input type="password" name="password" placeholder="password" required> <br>
        <input type="submit" name="submit-btn">
</form>
</body>
</html>
