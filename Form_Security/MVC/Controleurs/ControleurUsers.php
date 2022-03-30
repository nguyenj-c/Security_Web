<?php

final class ControleurUsers
{
    public function defautAction() : void
    {
        Vue::montrer('Home/voir');
    }
    public function loginAction() : void
    {
        $O_user = new Users();
        Vue::montrer('Form/login', array('loginUser' =>  $O_user->connect()));
    }
    public function otherLoginAction() : void
    {
        $O_user = new Users();
        Vue::montrer('Form/login', array('loginUser' =>  $O_user->otherConnect()));
    }

    public function registerAction() : void
    {
        $O_user = new Users();
        Vue::montrer('Form/login', array('register' =>  $O_user->registerUser()));
    }
    public function errorAction() : void
    {
        Vue::montrer('Users/error');
    }
    public function successAction() : void
    {
        Vue::montrer('Users/success');
    }
    public function forgotAction() : void
    {
        $O_user = new Users();
        Vue::montrer('Users/forgot', array('mdpForgot' =>  $O_user->mdpForget()));
    }
    public function cacheAction() : void
    {
        $O_user = new Users();
        Vue::montrer('Users/forgot', array('cache' =>  $O_user->cache()));
    }
    public function bloquerAction() : void
    {
        Vue::montrer('Users/bloquer');
    }
    public function formModifierAction() : void
    {
        Vue::montrer('Form/updatePsw');
    }
    public function modifierMDPAction() : void
    {
        $O_user = new Users();
        Vue::montrer('Form/updatePsw', array('modifierMDP' =>  $O_user->modifierMDP()));
    }
}
