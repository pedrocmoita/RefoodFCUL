<?php
// Estabelece uma ligação com a base de dados usando o programa abreconexao.php
// A variável $conn é inicializada com a ligação estabelecida
include "abreconexao.php";

$sql = "SELECT * FROM utilizador";

$result=mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
        echo "Nome: " . $row["nome"]. "  |  Idade: " . $row["idade"]. "  |  Mai$
    }
} else {
    echo "Não existem utilizadores";
}

mysqli_close($conn);