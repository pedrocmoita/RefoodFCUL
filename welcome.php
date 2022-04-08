<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page - FCUL</title>
    <link rel="stylesheet" href="css/welcome.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/c63aba2ece.js" crossorigin="anonymous"></script>
</head>
<body>
    <div class="">
        <header class="d-flex justify-content-between">
            <div>
              <p>Bem-vindo(a) voluntário/instituição</p>
              <p><a href="index.html" style="font-size: 1.125rem; margin: 0; padding: 0;">Logout</a></p>
            </div>
            <p>REFOOD - FCUL</p>
            <i class="fa-regular fa-user" data-toggle="modal" data-target="#myModal"></i>
        </header>
        <!-- Modal -->
        <div class="container">
            <div class="modal" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">
                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Profile</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <!-- Modal body -->
                  <div class="modal-body">
                    <input type="text" id="" name="name" value="username"><br>
                    <input type="email" id="" name="email" value="email"><br>
                    <input type="date" name="birthdate" value="birthdate"><br>
                    <input type="text" name="gender" value="gender"><br>
                    <input type="text" name="distrito" value="distrito"><br>
                    <input type="text" name="concelho" value="concelho"><br>
                    <input type="text" name="freguesia" value="freguesia"><br>
                    <input type="text" name="drivers_license" value="carta condução"><br>
                    <input type="text" name="personal_ID" value="cartao cidadao"><br>
                    <input type="password" id="" name="password" value="password"><br>
                  </div>
                  <!-- Modal footer -->
                  <div class="modal-footer">
                    <button type="submit" class="modal-save-btn">Save</button>
                    <button type="button" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="row">
            <div class="lista col-xl-2 border border-warning text-center">
                <div class="m-3">
                    <ul>
                        <li>Joao</li>
                        <li>Pedro</li>
                        <li>Afonso</li>
                        <li>Tiago</li>
                    </ul>
                </div>
            </div>
            <div class="main-section col-xl-10 p-0">
            <form class="search-bar d-flex justify-content-center">
                    <input class="form-control m-5" type="text" placeholder="Search">
                    <button class="btn btn-warning m-5" type="button">Search</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>