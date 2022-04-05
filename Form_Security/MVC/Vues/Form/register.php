<h3>Register Form</h3>
<form class="form-text" action="../Users/register" method="POST" onsubmit="return Validate(this)">
    <label class="form-label" for="email">Email :</label>
    <input type="email" name="email" id="email" size="50" pattern="[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" placeholder="toto@exemple.com"
           class="input-group-text" required>
    <label class="form-label" for="username">Username :</label>
    <input type="text" name="username" id="username" placeholder="Toteau" class="input-group-text" required>
    <label class="form-label" for="lastname">Nom :</label>
    <input type="text" name="lastname" id="lastname" placeholder="Tata" class="input-group-text" required>
    <label class="form-label" for="firstname">Prenom :</label>
    <input type="text" name="firstname" id="firstname" placeholder="Toto" class="input-group-text" required>
    <label class="form-label" for="phone">Téléphone :</label>
    <input type="tel" name="phone" id="phone" placeholder="0600000000" class="input-group-text" required>
    <label class="form-label" for="Address">Addresse :</label>
    <input type="text" name="Address" id="Address" class="input-group-text" required>
    <label class="form-label" for="mdp">Mot de passe :</label>
    <input type="password" name="mdp" id="mdp" class="input-group-text" required>
    <label class="form-label" for="mdp2">Confirmation mot de passe :</label>
    <input type="password" name="mdp2" id="mdp2" class="input-group-text"  required>
    <input type="submit" name="submit" value="Envoyer" class="btn btn-lg btn-primary btn-block">
</form>