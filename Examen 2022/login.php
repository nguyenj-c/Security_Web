<?php

echo '
        <h3>Login Form</h3>
  <form class="form-text" action="#" method="POST">
        <label class="form-label" for="username">Username :</label>
        <input type="text" name="username" id="username" size="10" placeholder="toto"
               class="input-group-text" required>
        <label class="form-label" for="mdp">Mot de passe :</label>
        <input type="password" name="password" id="mdp" class="input-group-text">
        <input type="submit" name="submit" value="Envoyer" class="btn btn-lg btn-primary btn-block">
 </form>
    ';

if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = hash('sha512',htmlentities($_POST['username']));
    $password = password_hash(htmlentities($_POST['password']),PASSWORD_BCRYPT, ['cost' => 10,]);
    $mysqli = new mysqli("localhost", "cyber1", "azerty", "bdd_1");
    if ($mysqli->connect_errno) {
        die("Impossible de se connecter");
    } else {
        $rows = $mysqli->query("SELECT * FROM `user` WHERE `login`='$username'");
        $row = $rows->fetch_assoc();

        $password = password_verify($_POST['password'], $row['password']);

        if (!isset($rows) || $password !== true) {
            echo "Mauvais nom d'utilisateur ou mot de passe.";
        } else {
            $_SESSION['user'] = $row['login'];
            $user_id = (int)$row['id'];
        }
        $ip = '147.94.73.0'; #ip du réseau
        $ip_details = json_decode(file_get_contents("https://ipinfo.io/{$ip}"));
        $user_agent = $_SERVER['HTTP_USER_AGENT'];

        $connexion = $mysqli->prepare("INSERT INTO connexion (user_id,ip, user_agent, zipcode, country)
                               VALUES (?,?,?,?,?)");

        $connexion->bind_param('issss', $user_id, $ip, $user_agent, $ip_details->postal, $ip_details->country);

        $connexion->execute();
    }

    $mysqli2 = new mysqli("localhost", "cyber1", "azerty", "bdd_2");
    if ($mysqli2->connect_errno) {
        die("Impossible de se connecter");
    } else {
        $keyGenerate = openssl_random_pseudo_bytes(256 / 4);
        $ivlen = openssl_cipher_iv_length('AES128');
        $iv = bin2hex(openssl_random_pseudo_bytes($ivlen));
        $keyHash = htmlentities(bin2hex($keyGenerate));


        $exist = $mysqli2->query("SELECT * FROM `cles` WHERE `id_user`='$user_id'");

        if($exist->num_rows == 0) {
            $cle = $mysqli2->prepare("INSERT INTO cles (id_user, cle, iv)
                               VALUES (?,?,?)");

            $cle->bind_param('iss', $user_id, $keyHash, $iv);

            $cle->execute();
        }
    }
}
?>