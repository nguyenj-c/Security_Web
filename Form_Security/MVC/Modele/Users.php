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
        $username =  hash('sha512', $_POST['username']);
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

        $keyGenerate = openssl_random_pseudo_bytes(256/4);

        $ivlen = openssl_cipher_iv_length('AES128');
        $iv = bin2hex(openssl_random_pseudo_bytes($ivlen));

        $keyHash = htmlentities(bin2hex($keyGenerate));

        $dbEncrypt->execDB("INSERT INTO encrypt (user_id,iv,cle)
                               VALUES ('$user_id','$iv','$keyHash')");

        return header('location: ../Pages/login');
    }

    private function resetTentatives($db, $username) : bool
    {
        $request = $db->queryDB("SELECT user.user_id FROM user,ip_address WHERE username='$username' AND user.user_id = ip_address.user_id AND ip_address.ip NOT IN (SELECT ip FROM blacklist)");

        if($request != true){
            return false;
        }
        $db->queryDB("UPDATE ip_address SET try = 0 WHERE user_id = ( SELECT user_id FROM user WHERE username='$username')");
        return true;
    }

    private function increaseTentative($db, $resultRequest, $username) : bool
    {
        $try = $resultRequest->try;
        $ip = $resultRequest->ip;

        $db->queryDB("UPDATE ip_address SET try = '$try' + 1 WHERE user_id = ( SELECT user_id FROM user WHERE username='$username')");
        if($try >= 2){
            $db->queryDB("INSERT INTO blacklist (ip) VALUES ('$ip')");
        }
        return false;
    }

    private function verifierTentatives($username, $request, $password) : bool
    {
        $db = new DB();

        return match (TRUE) {
            ( $username == $request->username && $password == true ) => $this->resetTentatives($db,$request,$username),
            ($username == $request->username && $password != true ) => $this->increaseTentative($db,$request,$username),
            default => false,
        };
    }

    public function connect()
    {
        session_start();
        $db = new DB();

        $username =  hash('sha512', $_POST['username']);

        $request = $db->queryDB("SELECT * FROM user WHERE username='$username'");

        $mdp = $request->password;

        $password = password_verify($_POST['mdp'], $mdp);

        if (!$this->verifierTentatives($username,$request, $password)) {
            $_SESSION['tentatives'] += 1;
            $request = $db->queryDB("SELECT user_id FROM user,ip_address WHERE username='$username' 
                                      AND user.user_id = ip_address.user_id AND ip NOT IN (
                                                SELECT ip FROM blacklist
                                          )");

            if($request != true){
                return header('Location: /Pages/login');
            }
            return header('Location: /Users/bloquer');
        }

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