<?php

final class Controleur
{
    private $_A_urlDecortique;

    private $_A_urlParametres;

    private $_A_postParams;

    public function __construct ($S_url, $A_postParams)
    {
        if ('/' == substr($S_url ??="", -1, 1)) {
            $S_url = substr($S_url ??="", 0, strlen($S_url) - 1);
        }

        $A_urlDecortique = explode('/', $S_url);

        if (empty($A_urlDecortique[0])) {
            $A_urlDecortique[0] = 'ControleurLogin';
        } else {
            $A_urlDecortique[0] = 'Controleur' . ucfirst($A_urlDecortique[0]);
        }

        if (empty($A_urlDecortique[1])) {
            $A_urlDecortique[1] = 'defautAction';
        } else {
            $A_urlDecortique[1] = $A_urlDecortique[1] . 'Action';
        }

        if (empty($S_page)) {
            $A_urlDecortique[2] = NULL;
        }


        $this->_A_urlDecortique['controleur'] = array_shift($A_urlDecortique); // on recupere le contrôleur
        $this->_A_urlDecortique['action']     = array_shift($A_urlDecortique); // puis l'action
        $this->_A_urlParametres = $A_urlDecortique;

        $this->_A_postParams = $A_postParams;


    }


    public function executer()
    {
        if (!class_exists($this->_A_urlDecortique['controleur'])) {
            throw new ControleurException($this->_A_urlDecortique['controleur'] . " n'est pas un controleur valide.");
        }

        if (!method_exists($this->_A_urlDecortique['controleur'], $this->_A_urlDecortique['action'])) {
            throw new ControleurException($this->_A_urlDecortique['action'] . " du contrôleur " .
                $this->_A_urlDecortique['controleur'] . " n'est pas une action valide.");
        }

        $B_called = call_user_func_array(array(new $this->_A_urlDecortique['controleur'],
            $this->_A_urlDecortique['action']), array($this->_A_urlParametres, $this->_A_postParams ));

        if (false === $B_called) {
            throw new ControleurException("L'action " . $this->_A_urlDecortique['action'] .
                " du contrôleur " . $this->_A_urlDecortique['controleur'] . " a rencontré une erreur.");
        }
    }
}