<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="js/msg.js"></script>
    <title>STUCOM MAIL</title>
</head>
<body>
    <?php session_start(); require_once "libs/errors.php"; require_once "libs/success.php";
    
    // ARE YOU LOGGED IN¿¿¿
    if(empty($_SESSION["username"])) 
    {
        errorUser(UserEvents::NOT_LOGGED);
    } 
    else { 
      
    /***** INITIALIZATION ******/  
    require_once "libs/User.php"; require_once "libs/Admin.php"; require_once "libs/MailServer.php"; require_once "libs/Utils.php";
    $user = ($_SESSION["type"] == 1) ? Admin::create() : User::create(); // Proper instantiation
    $user->setUsername($_SESSION["username"])->fetchInfo();
    $MailServer = new MailServer();
    $MailServer->refresh($user->getUsername());
    
    
    /***** MAILSERVER COUNTERS *****/
    if (isset($_GET["incount"]))
        $incount = $_GET["incount"];
    else
        $incount = 0;
    if (isset($_GET["outcount"]))
        $outcount = $_GET["outcount"];
    else
        $outcount = 0;
    if (isset($_GET["totalcount"]))
        $totalcount = $_GET["totalcount"];
    else
        $totalcount = 0;
    
    /******************************
     *                            *
     *          POST ZONE         *
     *                            *
     ******************************/
    
    /******** PASSWORD CHANGE ***********/
    if(isset($_POST["changepass"]))
    {
        if(password_verify($_POST["password-act"], $user->getPassword())) // If actual password is correct
        {
            if($_POST["password"] == $_POST["password-confirm"]) // If password equals confirmation
            {
                if($_POST["password"] != $_POST["password-act"]) //  If password is different from the previous one
                {
                    $user->setPassword($_POST["password"]);
                    $user->updateInfo();
                    successUser(SuccMsgs::PASSWORD_CHANGED);
                }
                else
                    errorUser(UserEvents::SAME_PASSWORD);
            }
            else
                errorUser(UserEvents::PASSWORDS_DONT_MATCH);
        }
        else
            errorUser(UserEvents::WRONG_PASSWORD);
    }
    
    /******* SEND NEW MESSAGE *********/
    else if(isset($_POST["sendmsg"]))
    {
        $user->sendMail($_POST["to"], $_POST["subj"], $_POST["body"]);
        $user->submitEvent(UserEvents::MSG_WRITE);
        successUser(SuccMsgs::MSG_SENT);
    }
    
    /******* REGISTER AN USER (admin only) ********/
    else if(isset($_POST["newuser"]))
    {
        if($_POST["newuser-password"] == $_POST["newuser-password-confirm"])
        {
            $newuser = User::create()->
                        setUsername($_POST["newuser-username"])->
                        setPassword($_POST["newuser-password"])->
                        setName($_POST["newuser-name"])->
                        setSurname($_POST["newuser-surname"])->
                        setType($_POST["newuser-type"]);
            $response = $newuser->register();
            if($response == UserEvents::OK)
                successUser(SuccMsgs::USER_REGISTERED);
            else
                errorUser($response);
        }
        else
            errorUser(UserEvents::PASSWORDS_DONT_MATCH);
    }
    
    /****** DELETE AN USER (admin only) ********/
    else if(isset($_POST["deluser"]))
    {
        if($user->deleteUser($_POST["deluser-username"]))
            successUser(SuccMsgs::USER_DELETED);
        else
            echo "PODRIT";
    }
    
    /***** FETCH LAST LOGIN FROM AN USER (admin only) ******/
    else if(isset($_POST["lastlogin"]))
    {
        lastLogin($user->fetchLastLoginFrom($_POST["lastlogin-username"]));
    }
    
    /******************************
     *                            *
     *          MAIN VIEW         *
     *                            *
     ******************************/
    else
    {
    include "header.php"; ?>
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4"><h1 style="text-align: center;">¡Bienvenido, <?php echo $user->getName(); ?>!</h1></div>
        <div class="col-md-4">
            <div class="col-md-6"></div>
            <div class="col-md-3"><a href="logout.php" class="btn btn-block btn-danger">Cerrar sesión</a></div>
            <div class="col-md-3"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <!-- PERSONAL INFO -->
            <article id="info" class="well">
                <h2>Información personal</h2>
                <h3><span class="glyphicon glyphicon-envelope"></span> Correo electrónico: <?php echo $user->getUsername()."@stukolm.com"; ?></h3>
                <h3><span class="glyphicon glyphicon-user"></span> Nombre y apellido: <?php echo $user->getName()." ".$user->getSurname(); ?></h3>
            </article>
            <!-- end PERSONAL INFO -->
            
            <!-- CHANGE PASSWORD -->
            <article id="changepass" class="well">
                <h2>Modificar contraseña</h2>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="password-act"><span class="glyphicon glyphicon-chevron-right"></span> Contraseña actual:</label>
                        <input type="password" class="form-control" name="password-act" placeholder="007" maxlength="10" required>
                    </div>
                    <div class="form-group">
                        <label for="password"><span class="glyphicon glyphicon-chevron-right"></span> Nueva contraseña:</label>
                        <input type="password" class="form-control" name="password" placeholder="007" maxlength="10" required>
                    </div>
                    <div id="confirm-register" class="form-group">
                        <label for="password-confirm"><span class="glyphicon glyphicon-chevron-right"></span> Confirmar nueva contraseña:</label>
                        <input type="password" class="form-control" name="password-confirm" placeholder="007" maxlength="10">
                    </div>
                    <input type="submit" class="btn btn-primary btn-block" name="changepass" value="Cambiar contraseña">
                </form>
            </article>
            <!-- end CHANGE PASSWORD -->
            
            <!-- NEW MESSAGE -->
            <?php require_once "modal-newmsg.php"; ?>
            <article id="newmsg" class="well">
                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#newMsg"><span class="glyphicon glyphicon-pencil"/> Redactar mensaje</button>
            </article>
            <!-- end NEW MESSAGE -->
            
            <!-- INBOX -->
            <?php require_once "modal-readmsg.php"; ?>
            <article id="inbox" class="well">
                <h2>Mensajes recibidos</h2>
                <div class="container-fluid">
                    <table class="table table-hover">
                        <thead><th>Emisor</th><th>Asunto</th><th>Fecha / Hora</th><th>Leer</th></thead>
                        <tbody>
                            <?php $MailServer->getInbox()->showMsgsTo($user->getUsername(), $incount); ?>
                        </tbody>
                    </table>
                </div>
            </article>
            <!-- end INBOX -->
            
            <!-- SENT MESSAGES -->
            <article id="sent" class="well">
                <h2>Mensajes enviados</h2>
                <div class="container-fluid">
                    <table class="table table-hover">
                        <thead><th>Receptor</th><th>Asunto</th><th>Fecha / Hora</th><th>Leer</th></thead>
                        <tbody>
                            <?php $MailServer->getSent()->showMsgsFrom($user->getUsername(), $outcount); ?>
                        </tbody>
                    </table>
                </div>
            </article>
            <!-- end SENT MESSAGES -->
    
    <!-- \\\\\\\\\\\\\\\\\\\\ ADMIN SECTION //////////////////// -->      
    <?php } if($user->getType() == 1) { ?>
            <!-- USERS LIST -->
            <article id="user-list" class="well">
                <h2>Listado de usuarios del sistema</h2>
                <div class="container-fluid">
                    <table class="table table-hover">
                        <thead><th>Nombre</th><th>Apellido</th><th>Nombre de usuario</th></thead>
                        <tbody>
                            <?php $user->checkUsers(); ?>
                        </tbody>
                    </table>
                </div>
            </article>
            <!-- end USERS LIST -->
            
            <!-- REGISTER USER -->
            <article id="newuser" class="well">
                <h2>Registrar un nuevo usuario</h2>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="username">Nombre de usuario:</label>
                        <input type="text" class="form-control" name="newuser-username" placeholder="pop3lover" maxlength="10" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="password" class="form-control" name="newuser-password" placeholder="007" maxlength="20" required>
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Confirmar contraseña:</label>
                        <input type="password" class="form-control" name="newuser-password-confirm" placeholder="007" maxlength="20" required>
                    </div>
                    <div class="form-group">
                        <label for="realname">Nombre:</label>
                        <input type="text" class="form-control" name="newuser-name" placeholder="Pepito" maxlength="20" required>
                    </div>
                    <div class="form-group">
                        <label for="surname">Apellido:</label>
                        <input type="text" class="form-control" name="newuser-surname" placeholder="Grillo" maxlength="50" required>
                    </div>
                    <div class="form-group">
                        <label for="type">Tipo de usuario:</label>
                        <label class="radio-inline">
                            <input type="radio" name="newuser-type" value="0" checked> Usuario corriente
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="newuser-type" value="1"> Administrador
                        </label>
                    </div>
                    <input id="submit-type" type="submit" class="btn btn-success btn-block" name="newuser" value="Registrar">
                </form>
            </article>
            <!-- end REGISTER USER -->
            
            <!-- DELETE USER -->
            <article id="deleteuser" class="well">
                <h2>Eliminar a un usuario</h2>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="name"><span class="glyphicon glyphicon-chevron-right"></span> Nombre del usuario:</label>
                        <select class="form-control" name="deluser-username">
                            <?php Utils::fetchUsersOption(); ?>
                        </select>
                    </div>
                    <input id="submit-type" type="submit" class="btn btn-danger btn-block" name="deluser" value="ELIMINAR USUARIO">
                </form>
            </article>
            <!-- end DELETE USER -->
            
            <!-- FETCH ALL MESSAGES -->
            <article id="all-messages" class="well">
                <h2>Todos los mensajes</h2>
                <div class="container-fluid">
                    <table class="table table-hover">
                        <thead><th>Emisor</th><th>Receptor</th><th>Asunto</th><th>Fecha / Hora</th></thead>
                        <tbody>
                            <?php $MailServer->showAllMsg($totalcount); ?>
                        </tbody>
                    </table>
                </div>
            </article>
            <!-- end FETCH ALL MESSAGES -->
            
            <!-- LAST LOGIN -->
            <article id="last-login" class="well">
                <h2>Obtener última conexión</h2>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="name"><span class="glyphicon glyphicon-chevron-right"></span> Nombre del usuario:</label>
                        <select class="form-control" name="lastlogin-username">
                            <?php Utils::fetchUsersOption(); ?>
                        </select>
                    </div>
                    <input id="submit-type" type="submit" class="btn btn-info btn-block" name="lastlogin" value="Obtener última conexión">
                </form>
            </article>
            <!-- end LAST LOGIN -->
            
            <!-- TOP MSGS RANKING -->
            <article id="ranking-msgs" class="well">
                <h2>Ranking mensajes enviados</h2>
                <table class="table table-hover">
                    <thead><th>Nombre</th><th>Apellido</th><th>Nombre de usuario</th><th>Mensajes enviados</th></thead>
                    <tbody>
                        <?php $user->fetchMsgRanking(); ?>
                    </tbody>
                </table>
            </article>
            <!-- end TOP MSGS RANKING -->
            
    <?php } ?> </div><div class="col-md-1"></div></div> <?php }  ?>
</body>
</html>