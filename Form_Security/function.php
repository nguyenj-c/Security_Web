<?php

function exist() : bool
{
    $not_exist = false;

    $db = new PDO('mysql:host=localhost;dbname=security_web; charset=utf8', 'root', '');
    $email = $_POST['email'];

    $infoEmail = $db->queryDB("SELECT * FROM user WHERE email='$email'");
    $emailDB = $infoEmail->fetch();

    if ( isset($emailDB) && $emailDB->email !== $email ) {
        $not_exist = true;
    }
    return $not_exist;
}

function registerUser()
{
    $bool = exist();
    if (!$bool) {
        return header('location: /Users/error');
    }
    $nom = $_POST['lastname'];
    $prenom = $_POST['firstname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['mdp'], PASSWORD_BCRYPT, ['cost' => 10]);
    addUser($nom, $prenom, $email, $password);
    return header('location: /Pages/login');
}

function resetTentatives($db, $resultRequest, $email) : bool
{
    $bloquer =$resultRequest->bloquer;
    $current_connexion = $resultRequest->current_connexion;
    if($bloquer == 1){
        return false;
    }
    $db->queryDB("UPDATE user SET nb_connexion = '$resultRequest->nb_connexion' + 1, tentatives = 0 WHERE email = '$email';");
    $db->queryDB("UPDATE user SET last_connexion = '$current_connexion', current_connexion = NOW() WHERE email = '$email';");
    return true;
}
