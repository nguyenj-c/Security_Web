<?php
if(!isset($_SESSION)){
    session_start();
}
if(!isset($_SESSION['log']) && $_SESSION['log'] != 'U') {
    header('Location: /Pages/login');
}
if(isset($_SESSION['log']) && ($_SESSION['log'] == 'U' || $_SESSION['log'] == 'A' )) {
    echo '
    <main>
        <ul class="list-group">
            <li class="list-group-item list-group-item-action list-group-item-dark">
                Nom:' . $A_vue['infoUser'][0] . '
            </li>
            <li class="list-group-item list-group-item-action list-group-item-dark">
                Prenom: ' . $A_vue['infoUser'][1] . '
            </li>
            <li class="list-group-item list-group-item-action list-group-item-dark">
                Email : ' . $A_vue['infoUser'][2] . '
            </li>
        </ul>
    </main>
    <h1>Bouton pour télécharger l\'application</h1>
    <button class="add-button">Ajouter</button>
    <p id="post-button">Déja télécharger</p>
    <h1>Notifications</h1>
    <div class="d-grid gap-2 col-6 mx-auto">
    <button class="btn btn-primary" id="notifications">Notifications</button>
    <a href="../Users/formModifier" class="btn btn-primary">Changer votre mot de passe</a>
    </div>';
}
?>