<?php
require 'db.php';
require 'dbEncrypt.php';

final class Users
{
    private array $options = [
        'cost' => 10,
    ];

    private function exist($username) : bool
    {
        $not_exist = false;

        $db = new DB();

        $infoUser = $db->queryDB("SELECT username FROM user");

        if ( isset($infoUser) && $infoUser !== $username ) {
            $not_exist = true;
        }

        return $not_exist;
    }

    public function registerUser()
    {

        $lastname = htmlentities($_POST['lastname']);
        $firstname = htmlentities($_POST['firstname']);
        $email = htmlentities($_POST['email']);
        $phone= htmlentities($_POST['phone']);
        $address= htmlentities($_POST['Address']);
        $username = password_hash($_POST['username'],PASSWORD_BCRYPT, $this->options);;
        $password = password_hash($_POST['mdp'], PASSWORD_BCRYPT, $this->options);

        $bool = $this->exist($username);
        if (!$bool) {
            return header('location: /Users/error');
        }

        $db = new DB();
        $dbEncrypt = new dbEncrypt();

        $db->execDB("INSERT INTO user (username,password)
                               VALUES ('$username','$password')");

        $requestID= $db->queryDB("SELECT LAST_INSERT_ID(id) as ID FROM user");
        $user_id = (int)$requestID->ID;

        $db->execDB("INSERT INTO user_details (user_id,lastname,firstname,phone,email,address)
                               VALUES ('$user_id','$lastname','$firstname','$phone','$email','$address')");

        $ip = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $db->execDB("INSERT INTO ip_address (user_id,user_agent,ip)
                               VALUES ('$user_id','$user_agent','$ip')");

        $key = openssl_random_pseudo_bytes(256/4);

        $ivlen = openssl_cipher_iv_length('AES128');
        $iv = openssl_random_pseudo_bytes($ivlen);

        $keyHash = htmlentities(bin2hex($key));

        $dbEncrypt->execDB("INSERT INTO encrypt (user_id,key,iv)
                               VALUES ('$user_id','$keyHash','$iv')");

        return header('location: ../Pages/login');
    }

    private function resetTentatives($db, $resultRequest, $email) : bool
    {
        $bloquer =$resultRequest->I;
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
        $username = htmlentities($_POST['username']);
        $db = new DB();
        $request = $db->queryDB("SELECT * FROM user WHERE email='$username'");
        $requestToken = $db->queryDB("SELECT * FROM token WHERE email_user='$email'");

        $resultRequest = $request->fetch();

        $mdp = $resultRequest->password;
        $emailDB = $resultRequest->email;

        $password = password_verify($_POST['mdp'], $mdp);

        if (!$this->verifierTentatives($email, $emailDB, $password)) {
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