<?php
if(!isset($_SESSION)) { //démarre la gestion des sessions PHP
	session_start();
}

if(isset($_GET['id'])) {
	$mysqli = new mysqli("localhost", "cyber1", "azerty", "bdd_1"); // Connexion BDD 
	if ($mysqli->connect_errno) {
		die("Échec de la connexion - Veuillez réessayer plus tard");
	}
	$rows=$mysqli->query("DELETE FROM `articles` WHERE id=" . $_GET['id']);
	header("Location:/admin");
}
?>
