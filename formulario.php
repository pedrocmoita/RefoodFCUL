<?php
include "abreconexao.php";
$name = $_POST["name"];
$idade = $_POST["idade"];
$mail = $_POST["email"];
$pass = $_POST["password"];
$query = "insert into utilizador values ('$name', '$idade', '$mail' ,'$pass')";
$res = mysqli_query($conn, $query); if ($res) {
  echo "Um novo registo inserido com sucesso";
} else {
  echo "Erro: insert failed" . $query . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);
?>

<html>
<body>
<br>
Welcome <?php echo $_POST["name"]; ?><br>
Your email address is: <?php echo $_POST["email"]; ?>

</body>
</html>