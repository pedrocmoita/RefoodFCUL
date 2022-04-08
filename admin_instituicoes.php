<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminPage</title>
    <link rel="stylesheet" href="css/admin.css">
    <script src="https://kit.fontawesome.com/c63aba2ece.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
        <div class="side-bar">
            <h1>Admins Only</h1>
            <ul>
                <li><button onClick="location.href='admin.php'"><i class="fa-solid fa-user"></i><a>Users</a></button></li>
                <li><button onClick="location.href='admin_voluntarios.php'"><i class="fa-solid fa-handshake-angle"></i><a>Volunteers</a></button></li>
                <li><button onClick="location.href='admin_instituicoes.php'" class="active"><i class="fa-solid fa-building-columns"></i><a>Institution</a></button></li>
                <li><button onClick="location.href=''"><i class="fa-solid fa-chart-pie"></i><a>Statistics</a></button></li>
                <li><button onClick="location.href=''"><i class="fa-solid fa-bell"></i><a>Notifications</a></button></li>
            </ul>
        </div>
        <div class="main-section">
            <form action="" method="" class="search-form">
                <input class="main-section__search-bar" type="text" placeholder="Search.." name="search">
                <button class="main-section__submit-btn" type="submit" name="submit-btn"><i class="fa fa-search"></i></button>
                <div class="search-form__filter-section">
                  <label for="filter">Filter by:</label>
                  <select id="filter">
                    <option value="">Freguesia</option>
                    <option value="">Concelho</option>
                    <option value="">Distrito</option>
                    <option value="" selected>Name</option>
                  </select>
                </div>
            </form>
            <table>
                <tr>
                    <th>Nome</th>
                    <th>Número</th>
                    <th>Email</th>
                    <th>Morada</th>
                    <th>Distrito</th>
                    <th>Concelho</th>
                    <th>Freguesia</th>
                    <th>Nome de contacto</th>
                    <th>Nr de contacto</th>
                    <th>Password</th>
                </tr>
                <?php
                    include "abreconexao.php";

                    $query = "SELECT * FROM Instituicao";

                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr><td>" . $row["nome"]. " </td><td>" . $row["numero"]. "</td><td>" . $row["email"]. "</td><td>"
                                . $row["morada"]. "</td><td>" . $row["distrito"]. "</td><td>" . $row["concelho"]. "</td><td>"
                                . $row["freguesia"]. "</td><td>" . $row["nome_contacto"]. "</td><td>". $row["num_contacto"]. "</td><td>" 
                                . $row["passwd"]. "</td></tr>";
                            }
                    	echo "</table>";
                    } else {
       	 	           echo "Não existem utilizadores";
                    }

                    mysqli_close($conn);
                ?>
            </table>
        </div>
    </div>
</body>
</html>
