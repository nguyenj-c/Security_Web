<?php

final class ControleurPages
{
    public function defautAction() : void
    {
        Vue::montrer('Form/login');
    }

    public function homeAction() : void
    {
        Vue::montrer('Home/voir');
    }
    public function parametrageAction() : void
    {
        Vue::montrer('Parametrage/voir');
    }
    public function accountAction() : void
    {
        $O_user = new Users();
        Vue::montrer('Users/voir', array('infoUser' =>  $O_user->getUserInfo()));
    }
    public function registerAction() : void
    {

        Vue::montrer('Form/register');
    }
    public function loginAction() : void
    {

        Vue::montrer('Form/login');
    }
    public function logoutAction() : void
    {
        $O_user = new Users();
        Vue::montrer('Home/voir', array('logoutUser' =>  $O_user->disconnect()));
    }
    public function historyAction() : void
    {
        $O_temp = new Temperature();
        Vue::montrer('History/voir', array('pagination' =>  $O_temp->paginationTemperature()));
    }
    public function recuperationMailAction() : void
    {
        Vue::montrer('Form/forgot');
    }
    public function documentationAction() : void
    {
        Vue::montrer('Documentation/admin');
    }
    public function adminAction() : void
    {
        $O_user = new Users();
        Vue::montrer('Users/admin', array('adminPanel' =>  $O_user->adminPanel()));
    }

    public function jsonAction() : void
    {
        $O_temp = new Temperature();
        Vue::montrer('Home/voir', array('json' =>  $O_temp->jsonTemp()));
    }
}
