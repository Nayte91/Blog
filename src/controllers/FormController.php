<?php

namespace P5blog\controllers;

use P5blog\models\User;
use P5blog\models\UserManager;

final class FormController extends AbstractController
{
    public function __construct()
    {
        //Vérifier le POST de login
        switch ($_POST['form']){
            case "login":
            $this->login();
            break;
            case "logout":
            $this->logout();
            break;
            case "signin":
            $this->signin();
        }
    }

    public function login(): void
    {
        if (empty($_POST['name']) || !isset($_POST['name']) || empty($_POST['password']) || !isset($_POST['password']))
            throw new \Exception("bien joué le formulaire vide");

        $user = User::retrieveFromName($_POST['name']);

        if (!isset($user) || !$user->verifyPassword($_POST['password'])){
            throw new \Exception("identifiants invalides");
        }

        //Ca c'est le résultat
        $_SESSION['name'] = $user->getName();
        $_SESSION['admin'] = $user->getAdmin();
        $_SESSION['email'] = $user->getEmail();
    }

    public function logout()
    {
      $_SESSION = [];
      //session_destroy();
    }

    public function signin()
    {
        $toto = new User($_POST);
    }
}
