<?php
require'db.php';
require 'dbEncrypt.php';

final class Users
{
    private array $options = [
        'cost' => 10,
    ];

    public function lastID(){
        $db = new DB();
        $request = $db->queryDB("SELECT LAST_INSERT_ID() FROM user ");
        $user_id = $request->fetch();
        return $user_id;
    }

    private function exist($username) : bool
    {
        $not_exist = false;

        $db = new DB();

        $info = $db->queryDB("SELECT username FROM user");
        $infoUser = $info->fetch();

        if ( isset($infoUser) && $infoUser !== $username ) {
            $not_exist = true;
        }

        return $not_exist;
    }

    public function registerUser()
    {

        $lastname = $_POST['lastname'];
        $firstname = $_POST['firstname'];
        $email = $_POST['email'];
        $phone= $_POST['phone'];
        $address= $_POST['Address'];
        $username = $_POST['username'];
        $password = password_hash($_POST['mdp'], PASSWORD_BCRYPT, $this->options);

        $bool = $this->exist($username);
        if (!$bool) {
            return header('location: /Users/error');
        }

        $db = new DB();
        $dbEncrypt = new dbEncrypt();
        $user_id = $this->lastID();
        var_dump($user_id);
        $db->queryDB("INSERT INTO user (username,password)
                               VALUES ('$username','$password')");
        $db->queryDB("INSERT INTO user_details (user_id,lastname,firstname,phone,email,address)
                               VALUES ('$user_id','$lastname','$firstname','$phone','$email','$address')");

        $key = openssl_random_pseudo_bytes(256/4);

        $ivlen = openssl_cipher_iv_length('AES128');
        $iv = openssl_random_pseudo_bytes($ivlen);

        $dbEncrypt->queryDB("INSERT INTO encrypt (user_id,key,iv)
                               VALUES (LAST_INSERT_ID(),'$key','$iv')");
        return header('location: ../Pages/login');
    }

    private function resetTentatives($db, $resultRequest, $email) : bool
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

    private function increaseTentative($db, $resultRequest, $email) : bool
    {
        $tentatives = $resultRequest->tentatives;
        $db->queryDB("UPDATE user SET tentatives = '$tentatives' + 1 WHERE email = '$email';");
        if($tentatives >= 2){
            $db->queryDB("UPDATE user SET bloquer = 1 WHERE email = '$email';");
        }
        return false;
    }

    private function verifierTentatives($email,$emailDB, $password) : bool
    {
        $db = new DB();
        $result_db = $db->queryDB("SELECT * FROM user WHERE email='$email'");
        $resultRequest = $result_db->fetch();

        return match (TRUE) {
            ( $email == $emailDB && $password == true ) => $this->resetTentatives($db,$resultRequest,$email),
            ($email == $emailDB && $password != true) => $this->increaseTentative($db,$resultRequest,$email),
            default => false,
        };
    }

    public function connect()
    {
        session_start();
        $email = $_POST['email'];
        $db = new DB();
        $request = $db->queryDB("SELECT * FROM user WHERE email='$email'");
        $requestToken = $db->queryDB("SELECT * FROM token WHERE email_user='$email'");

        $resultToken = $requestToken->fetch();
        $resultRequest = $request->fetch();

        $mdp = $resultRequest->password;
        $emailDB = $resultRequest->email;
        $time = date("H:i:s",strtotime( +3600));

        if(isset($resultToken->time_expiration) && $time > $resultToken->time_expiration){
            $db->execDB("DELETE FROM token WHERE email_user = '$email'");
            return "Token incorrect ou expiré";
        }
        if($resultRequest->token == 1){
            $mdp = $resultToken->token_mdp;
        }
        $password = password_verify($_POST['mdp'], $mdp);

        if (!$this->verifierTentatives($email, $emailDB, $password)) { //$bool true user est bien vérifié et false ne reconnait pas l'user
            $_SESSION['tentatives'] += 1;
            $requestUpdate = $db->queryDB("SELECT * FROM user WHERE email='$email'");
            $resultUpdate = $requestUpdate->fetch();
            $bloquer = $resultUpdate->bloquer;

            if($bloquer != 1){
                return header('Location: /Pages/login');
            }
            return header('Location: /Users/bloquer');
        }
        $_SESSION['log'] = $resultRequest->role;
        $_SESSION['email'] = $email;
        return header('Location: /Pages/home');
    }

    public function disconnect() : void
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
        header('Location: /Pages');
    }

}