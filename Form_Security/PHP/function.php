<?php

function exist($username)
{
    $not_exist = false;

    $db = mysqli_connect('localhost', 'root', '','security_web');

    $infoUser = mysqli_query($db,"SELECT * FROM user WHERE username='$username'");

    if ( isset($infoUser) && $infoUser->username !== $username ) {
        $not_exist = true;
    }
    return $not_exist;
}

function registerUser()
{
    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $phone= $_POST['phone'];
    $address= $_POST['Address'];
    $username = $_POST['username'];
    $password = password_hash($_POST['mdp'], PASSWORD_BCRYPT, ['cost' => 10]);
    $bool = exist($username);
    if (!$bool) {
        return header('location: error.php');
    }
    $db = mysqli_connect('localhost', 'root', '','security_web');
    $dbEncrypt = mysqli_connect('localhost', 'root', '','security_web_encrypt');
    mysqli_query($db,"INSERT INTO user (username,password,createAt)
                               VALUES ('$username','$password',NOW())");
    mysqli_query($db,"INSERT INTO user_details (user_id,lastname,firstname,phone,email,address,createdAt)
                               VALUES (LAST_INSERT_ID(),'$lastname','$firstname','$phone','$email','$address',NOW())");

    $key = openssl_random_pseudo_bytes(256/4);

    $ivlen = openssl_cipher_iv_length('AES128');
    $iv = openssl_random_pseudo_bytes($ivlen);

    mysqli_query($dbEncrypt,"INSERT INTO encrypt (user_id,key,iv)
                               VALUES (LAST_INSERT_ID(),'$key','$iv')");
    return header('location: index.php');
}

function resetTentatives($db, $resultRequest)
{
    session_start();
    $bloquer =$resultRequest->bloquer;
    $user = $_SESSION['user_id'];
    if($bloquer == 1){
        return false;
    }
    mysqli_query($db,"UPDATE user SET try = 0 WHERE user_id = '$user'");

    return true;
}

function increaseTentative($db, $resultRequest, $email)
{
    $tentatives = $resultRequest->tentatives;
    mysqli_query($db,"UPDATE user SET tentatives = '$tentatives' + 1 WHERE email = '$email'");
    if($tentatives >= 2){
        $db->query("UPDATE user SET bloquer = 1 WHERE email = '$email'");
    }
    return false;
}

function verifierTentatives($email,$emailDB, $password) : bool
{
    $db = mysqli_connect('localhost', 'root', '','security_web');
    $result_db = mysqli_query($db,"SELECT * FROM user WHERE email='$email'");
    $resultRequest = $result_db->fetch();

    return match (TRUE) {
        ($email == $emailDB && $password == true) => resetTentatives($db, $resultRequest, $email),
        ($email == $emailDB && $password != true) => increaseTentative($db, $resultRequest, $email),
        default => false,
    };
}

function connect()
{
    session_start();
    $email = $_POST['email'];
    $db = mysqli_connect('localhost', 'root', '','security_web');
    $request = $db->query("SELECT * FROM user WHERE email='$email'");
    $requestToken = $db->query("SELECT * FROM token WHERE email_user='$email'");

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