<?php

final class Vue
{
    public static function ouvrirTampon()
    {
        ob_start();
    }

    public static function recupererContenuTampon()
    {
        return ob_get_clean();
    }

    public static function montrer ($S_localisation, $A_parametres = array())
    {
        $S_fichier = Constantes::repertoireVues() . $S_localisation . '.php';

            $A_vue = $A_parametres;
            ob_start();
            include $S_fichier;
            ob_end_flush();
    }
}