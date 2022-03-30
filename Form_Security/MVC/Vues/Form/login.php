<?php

    echo '
        <h3>Login Form</h3>
  <form class="form-text" action="/Users/login" method="POST">
        <label class="form-label" for="username">Email :</label>
        <input type="text" name="username" id="username" size="10" placeholder="toto"
               class="input-group-text" required>
        <label class="form-label" for="mdp">Mot de passe :</label>
        <input type="password" name="mdp" id="mdp" class="input-group-text">
        <input type="submit" name="submit" value="Envoyer" class="btn btn-lg btn-primary btn-block">
        <a href="../Pages/register">Vous n\'êtes pas inscrit ?</a>
 </form>
    ';

?>