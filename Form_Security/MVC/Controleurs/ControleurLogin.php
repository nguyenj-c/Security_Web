<?php

final class ControleurLogin
{
    public function defautAction()
    {
        $O_helloworld =  new Users();
        Vue::montrer('helloworld/voir', array('helloworld' =>  $O_helloworld->donneMessage()));

    }
}