<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/index.js"></script>
    <title>STUCOM MAIL</title>
</head>
<body>
    <?php 
    if(!empty($_POST)) 
    { 
        require "libs/User.php"; require "libs/errors.php";
        if(isset($_POST["login"])) // Login case
        {
            // Creation of the user
            $user = User::create()->setUsername($_POST["username"])->setPasswordLogin($_POST["password"]);
            // We try to log the user in and get a response
            $response = $user->login();
            if($response == UserEvents::OK) // If the response is OK...
            {
                $user->fetchInfo()->startSession(); // we fetch and save the user's data on $_SESSION,
                $user->submitEvent(UserEvents::LOGIN); // submit a LOGIN event,
                header("Location: home.php"); // then we redirect to the home
            }
            else
                errorUser($response); // If it's not OK, errorUser will tell us why it failed
        }
        else // Register case
        {
            if($_POST["password"] == $_POST["password-confirm"]) // If passwords match
            {
                extract($_POST);
                $user = User::create()->setUsername($username)->setPassword($password)->setName($realname)->setSurname($surname)->setType(0); // We create an instance of user
                $response = $user->register(); // We get a response trying to register it
                if($response == UserEvents::OK) // If the response is OK we proceed like on login w/o fetching info
                {
                    $user->startSession();
                    $user->submitEvent(UserEvents::LOGIN);
                    header("Location: home.php");
                }
                else
                    errorUser($response);
            }
            else
                errorUser(UserEvents::PASSWORDS_DONT_MATCH);
        }
        
    } else { ?>
    <div class="container-fluid">
        <?php include "header.php"; ?>
        <div class="row">
            <div class="col-md-3"></div>
            <div id="form-out" class="col-md-6">
                <h2 id="form-type">Iniciar sesión</h2>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="username">Nombre de usuario:</label>
                        <input type="text" class="form-control" name="username" placeholder="pop3lover" maxlength="10" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" name="password" placeholder="007" maxlength="20" required>
                    </div>
                    <div id="register" style="display: none;">
                        <div class="form-group">
                            <label for="password-confirm">Confirmar contraseña:</label>
                            <input type="password" class="form-control" name="password-confirm" placeholder="007" maxlength="20">
                        </div>
                        <div class="form-group">
                            <label for="realname">Nombre:</label>
                            <input type="text" class="form-control" name="realname" placeholder="Pepito" maxlength="20">
                        </div>
                        <div class="form-group">
                            <label for="surname">Apellido:</label>
                            <input type="text" class="form-control" name="surname" placeholder="Grillo" maxlength="50">
                        </div>
                    </div>
                    <div id="smooth"><input id="submit-type" type="submit" class="btn btn-success btn-block" name="login" value="¡Inicia sesión!">
                    <a id="change" href="#">¡Regístrate!</a></div>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <?php } ?>
</body>
</html>