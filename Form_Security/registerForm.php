<!DOCTYPE html>
<html lang="fr">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {font-family: Arial, Helvetica, sans-serif;}
        * {box-sizing: border-box;}

        input[type=text], select, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 6px;
            margin-bottom: 16px;
            resize: vertical;
        }

        input[type=submit] {
            background-color: #04AA6D;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        .container {
            border-radius: 5px;
            background-color: #f2f2f2;
            padding: 20px;
        }
    </style>
    <title>Register</title>
</head>
<body>

<h3>Register Form</h3>
<form class="form-text" action="" method="POST" onsubmit="return Validate(this)">
    <label class="form-label" for="email">Email :</label>
    <input type="email" name="email" id="email" size="50" pattern="[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]{1,}@[a-zA-Z.-]{2,}[.]{1}[a-zA-Z]{2,}" placeholder="toto@exemple.com"
           class="input-group-text" required>
    <label class="form-label" for="lastname">Nom :</label>
    <input type="text" name="lastname" id="lastname" placeholder="Tata" class="input-group-text" required>
    <label class="form-label" for="firstname">Prenom :</label>
    <input type="text" name="firstname" id="firstname" placeholder="Toto" class="input-group-text" required>
    <label class="form-label" for="mdp">Mot de passe :</label>
    <input type="password" name="mdp" id="mdp" class="input-group-text" required>
    <label class="form-label" for="mdp2">Confirmation mot de passe :</label>
    <input type="password" name="mdp2" id="mdp2" class="input-group-text" required>
    <input type="submit" name="submit" value="Envoyer" class="btn btn-lg btn-primary btn-block">
</form>
<script src="./form.js"></script>
</body>
</html>



