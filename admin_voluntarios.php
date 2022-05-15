<?php
include "abreconexao.php";

if(isset($_POST['submit-btn'])){
  $searched_name = htmlspecialchars($_POST['searched_name']);
  $selected_filter = htmlspecialchars($_POST['selected_filter']);

 if($selected_filter == "freguesia" || $selected_filter == "concelho" || $selected_filter == "distrito" || $selected_filter == "nome"){
    $search_query = "SELECT * FROM Voluntario WHERE $selected_filter LIKE '%$searched_name%'";
    $search_result = mysqli_query($conn, $search_query);
  }else{
    echo "something went wrong!";
  }
}
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminPage</title>
    <link rel="stylesheet" href="css/admin.css">
    <script src="https://kit.fontawesome.com/c63aba2ece.js" crossorigin="anonymous"></script>
    <style>
    </style>
</head>
<body>
<div class="container">
        <div class="side-bar">
            <h1>Admins Only</h1>
            <ul>
                <li><button onClick="location.href='admin.php'"><i class="fa-solid fa-user"></i><a>Users</a></button></li>
                <li><button onClick="location.href='admin_voluntarios.php'" class="active"><i class="fa-solid fa-handshake-angle"></i><a>Volunteers</a></button></li>
                <li><button onClick="location.href='admin_instituicoes.php'"><i class="fa-solid fa-building-columns"></i><a>Institution</a></button></li>
                <li><button onClick="location.href=''"><i class="fa-solid fa-chart-pie"></i><a>Statistics</a></button></li>
                <li><button onClick="location.href=''"><i class="fa-solid fa-bell"></i><a>Notifications</a></button></li>
            </ul>
        </div>
        <div class="main-section">
            <form action="" method="post" class="search-form">
                <input class="main-section__search-bar" type="text" placeholder="Search.." name="searched_name">
                <button class="main-section__submit-btn" type="submit" name="submit-btn"><i class="fa fa-search"></i></button>
                <div class="search-form__filter-section">
                  <label for="filter">Filter by:</label>
                  <select id="filter" name="selected_filter">
                    <option value="freguesia" selected >Freguesia</option>
                    <option value="concelho">Concelho</option>
                    <option value="distrito">Distrito</option>
                    <option value="nome">Nome</option>
                  </select>
                </div>
            </form>
            <table>
                <tr>
                    <th>Nome</th>
                    <th>Número</th>
                    <th>Email</th>
                    <th>Distrito</th>
                    <th>Concelho</th>
                    <th>Freguesia</th>
                    <th>Cartão Cidadão</th>
                    <th>Data Nascimento</th>
                    <th>Genero</th>
                    <th>Carta Condução</th>
                    <th>Password</th>
                </tr>
                <?php
                    if (mysqli_num_rows($search_result) > 0) {
                        while($row = mysqli_fetch_assoc($search_result)) {
                            echo "<tr><td>" . $row["nome"]. " </td><td>" . $row["numero"]. "</td><td>" . $row["email"]. "</td><td>"
                                . $row["distrito"]. "</td><td>" . $row["concelho"]. "</td><td>" . $row["freguesia"]. "</td><td>"
                                . $row["cartao_cidadao"]. "</td><td>" . $row["data_nasc"]. "</td><td>". $row["genero"]. "</td><td>"
                                . $row["carta_cond"]. "</td><td>" . $row["passwd"]. "</td></tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<p>Não foram encontrados resultados nenhuns...</p>";
                    }

                    mysqli_close($conn);
                ?>
            </table>
        </div>
    </div>
</body>
</html>
