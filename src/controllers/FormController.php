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
                break;
            case "signout":
                $this->signout();
                break;
            default:
                break;
        }
    }

    public function login(): void
    {
        if (empty($_POST['name']) || !isset($_POST['name']) || empty($_POST['password']) || !isset($_POST['password']))
            throw new \Exception("bien joué le formulaire vide");

        $user = User::retrieveFromName($_POST);

        if (!isset($user) || !$user->verifyPassword($_POST['password'])){
            throw new \Exception("identifiants invalides");
        }

        //Ca c'est le résultat
        $_SESSION = $user->getAll();

        $this->message = "Connexion réussie";
    }

    public function logout(): void
    {
        $_SESSION = [];
        $this->message = "Vous êtes déconnecté";
    }

    public function signin(): void
    {
        if (array_search("", $_POST))
            throw new \Exception("bien joué le formulaire vide");

        if(User::createOne($_POST)){
            $this->message = "Compte créé, connectez-vous";
        } else {
            throw new \Exception("Création ratée");
        }
    }

    public function signout(): void
    {
        if (!array_key_exists("id", $_SESSION) || !$_SESSION['id']){
            throw new \Exception("Petit coquinou");
        }

        if(User::deleteFromId($_SESSION['id'])){
            $_SESSION = [];
            $this->message = "Compte détruit";
        } else {
            throw new \Exception("Destruction ratée ?");
        }
    }
}
