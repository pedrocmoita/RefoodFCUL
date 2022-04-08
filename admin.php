<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AdminPage</title>
    <script src="https://kit.fontawesome.com/c63aba2ece.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <style>
        table{
                border-collapse: collapse;
                width: 100%;
                color: #3b444b;
                text-align: left;
        }

        th{
                background-color: grey;
                color: white;
        }

        tr:nth-child(even){
                background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <header>
        <a href="">Voluntários</a>
        <a href="">Instituições</a>
    </header>
    <table>
        <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Password</th>
        </tr>
        <?php
                include "abreconexao.php";

                $query = "SELECT * FROM Utilizador";

                $result = mysqli_query($conn, $query);

                if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                                echo "<tr><td>" . $row["nome"]. " </td><td>" . $row["email"]. "</td><td>" . $row["passwd"]. "<td></tr>";
                        }
                        echo "</table>";
                } else {
                echo "Não existem utilizadores";
                }

                mysqli_close($conn);
        ?>
    </table>
</body>
</html>
