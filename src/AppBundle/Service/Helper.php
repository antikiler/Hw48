<?php
namespace AppBundle\Service;

use Symfony\Component\HttpFoundation\Session\Session;

class Helper
{
    public static function statGreeting()
    {
        $greeting = [
            0 => "Добро пожаловать на сайт!",
            1 => "Спасибо что зашили на этот сайт!",
            2 => "Спасибо за регистрацию на сайте!",
            3 => "Рады вас видеть на нашем сайте!",
        ];
        $session = new Session();

        $countMessage = $session->get("countMessage");
        if ($countMessage >= 0 && $countMessage < count($greeting)-1){
            $session->set("countMessage",intval($session->get("countMessage"))+1);
        }else{
            $session->set("countMessage",0);
        }
        $session->set("welcomeMessage",$greeting[$session->get("countMessage")]);
    }
}