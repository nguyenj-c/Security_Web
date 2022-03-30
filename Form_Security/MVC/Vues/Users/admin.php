<?php
if(!isset($_SESSION)){
session_start();
}
if(!isset($_SESSION['log']) || $_SESSION['log'] !== 'A') {
    header('Location: /Pages/home');
}
echo'<p>Nombre d\'utilisateur : ' . $A_vue['adminPanel'][0] . '</p>
<p>Nombre de tokens : ' . $A_vue['adminPanel'][1]. '</p>git';

foreach ($A_vue['adminPanel'][2] as $info){
    echo '<p>Nom : ' . $info->nom .'  |  Prenom : ' . $info->prenom . ' | Role : ' . $info->role . '<p/>';
}
