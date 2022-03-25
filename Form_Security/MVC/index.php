<?php

    $S_urlADecortiquer = isset($_GET['url']) ? $_GET['url'] : null;
    $A_postParams = isset($_POST) ? $_POST : null;

    Vue::ouvrirTampon();

    try
    {
        $O_controleur = new Controleur($S_urlADecortiquer, $A_postParams);
        $O_controleur->executer();
    }
    catch (ControleurException $O_exception)
    {
        echo ('Une erreur s\'est produite : ' . $O_exception->getMessage());
    }

    $contenuPourAffichage = Vue::recupererContenuTampon();

    Vue::montrer('gabarit', array('body' => $contenuPourAffichage));