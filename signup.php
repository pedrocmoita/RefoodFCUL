<?php
include "abreconexao.php";

if(isset($_POST['submit-btn'])){
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $idade = mysqli_real_escape_string($conn, $_POST['idade']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $hashpass = password_hash('$password', PASSWORD_DEFAULT);

        $select_query = "SELECT * FROM utilizador WHERE nome='$name' AND idade='$idade' AND email='$email'";
        $result_select = mysqli_query($conn, $select_query);

        $error = "";
        $success = "";
        if(mysqli_num_rows($result_select) == 0){
                if(strlen("$password") < 6 || strlen("$password") > 15){
                    $error = "password must have between 6 and 15 characters";
                    $success = "";
                }else{
                    $insert_query = "INSERT INTO utilizador (nome, idade, email, passwd) VALUES ('$name', '$idade', '$email', '$hashpass')";
                    $result_insert = mysqli_query($conn, $insert_query);
                    $error = "";
                    $success = "Registered with sucess :)";
                }
        }else{
                $error = "User already exists. Login in your account please.";
                $success = "";
        }
}

?>

<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
<form action="" method="POST">
        <?php
                echo "$error";
                echo "$success";
        ?><br>
        Name: <input type="text" name="name" placeholder="name" required><br>
        Idade: <input type="number" name="idade" placeholder="age"><br>
        E-mail: <input type="email" name="email" placeholder="name@example.com"><br>
        Password: <input type="password" name="password" placeholder="password"><br>
        <input type="submit" name="submit-btn">
</form>
</body>
</html>
