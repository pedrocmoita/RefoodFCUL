<?php
include "abreconexao.php";

$query = "SELECT * FROM utilizador";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
                echo "Nome: " . $row["nome"]. "  |  Idade: " . $row["idade"]. "  | Email: " . $row["email"];
        }
} else {
    echo "Não existem utilizadores";
}

mysqli_close($conn);

?>
