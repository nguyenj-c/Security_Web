<?php

function addUser($nom, $prenom, $phone,$email, $address)
{
    $db = new PDO('mysql:host=localhost;dbname=security_web; charset=utf8', 'root', '');
    return $db->query("INSERT INTO user_details (lastname,firstname,phone,email,address,createdAt) 
                               VALUES ('$nom','$prenom','$phone','$email','$address',NOW())");
}

function exist() : bool
{
    $not_exist = false;

    $db = new PDO('mysql:host=localhost;dbname=security_web; charset=utf8', 'root', '');
    $username = $_POST['username'];

    $infoUser = $db->query("SELECT * FROM user WHERE username='$username'");

    if ( isset($infoUser) && $infoUser->username !== $username ) {
        $not_exist = true;
    }
    return $not_exist;
}

function registerUser()
{
    $bool = exist();
    if (!$bool) {
        return header('location: ./error.php');
    }
    $nom = $_POST['lastname'];
    $prenom = $_POST['firstname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['mdp'], PASSWORD_BCRYPT, ['cost' => 10]);
    addUser($nom, $prenom, $email, $password);
    return header('location: ./index.php');
}

function resetTentatives($db, $resultRequest, $email) : bool
{
    $bloquer =$resultRequest->bloquer;
    $current_connexion = $resultRequest->current_connexion;
    if($bloquer == 1){
        return false;
    }
    $db->query("UPDATE user SET nb_connexion = '$resultRequest->nb_connexion' + 1, tentatives = 0 WHERE email = '$email';");
    $db->query("UPDATE user SET last_connexion = '$current_connexion', current_connexion = NOW() WHERE email = '$email';");
    return true;
}

function increaseTentative($db, $resultRequest, $email) : bool
{
    $tentatives = $resultRequest->tentatives;
    $db->query("UPDATE user SET tentatives = '$tentatives' + 1 WHERE email = '$email';");
    if($tentatives >= 2){
        $db->query("UPDATE user SET bloquer = 1 WHERE email = '$email';");
    }
    return false;
}

function verifierTentatives($email,$emailDB, $password) : bool
{
    $db = new PDO('mysql:host=localhost;dbname=security_web; charset=utf8', 'root', '');
    $result_db = $db->query("SELECT * FROM user WHERE email='$email'");
    $resultRequest = $result_db->fetch();

    return match (TRUE) {
        ($email == $emailDB && $password == true) => resetTentatives($db, $resultRequest, $email),
        ($email == $emailDB && $password != true) => increaseTentative($db, $resultRequest, $email),
        default => false,
    };
}

public function connect()
{
    session_start();
    $email = $_POST['email'];
    $db = new PDO('mysql:host=localhost;dbname=security_web; charset=utf8', 'root', '');
    $request = $db->queryDB("SELECT * FROM user WHERE email='$email'");
    $requestToken = $db->queryDB("SELECT * FROM token WHERE email_user='$email'");

    $resultToken = $requestToken->fetch();
    $resultRequest = $request->fetch();

    $mdp = $resultRequest->password;
    $emailDB = $resultRequest->email;
    $time = date("H:i:s",strtotime( +3600));

    if(isset($resultToken->time_expiration) && $time > $resultToken->time_expiration){
        $db->exec("DELETE FROM token WHERE email_user = '$email'");
        return "Token incorrect ou expiré";
    }
    if($resultRequest->token == 1){
        $mdp = $resultToken->token_mdp;
    }
    $password = password_verify($_POST['mdp'], $mdp);

    if (!verifierTentatives($email, $emailDB, $password)) { //$bool true user est bien vérifié et false ne reconnait pas l'user
        $_SESSION['tentatives'] += 1;
        $requestUpdate = $db->query("SELECT * FROM user WHERE email='$email'");
        $resultUpdate = $requestUpdate->fetch();
        $bloquer = $resultUpdate->bloquer;

        if($bloquer != 1){
            return header('Location: ./index.php');
        }
        return header('Location: ./error.php');
    }
    $_SESSION['log'] = $resultRequest->role;
    $_SESSION['email'] = $email;
    return header('Location: ./success.php');
}

function disconnect() : void
{
    session_start();
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
    header('Location: ./index.php');
}