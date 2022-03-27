<?php

echo '

<h3>Login Form</h3>
 <form class="form-text" action="/Users/login" method="POST">
        <label class="form-label" for="email">Email :</label>
        <input type="email" name="email" id="email" size="50" pattern="[a-zA-Z0-9.!#$%&*+/=?^_`{|}~-]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" placeholder="toto@exemple.com"
               class="input-group-text" required>
        <label class="form-label" for="mdp">Mot de passe :</label>
        <input type="password" name="mdp" id="mdp" class="input-group-text">
        <input type="submit" name="submit" value="Envoyer" class="btn btn-lg btn-primary btn-block">
 </form>
';
session_start();

print_r($_SERVER);


