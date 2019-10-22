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

        //Vérifier le Session ?
    }

    public function login()
    {
        if (!empty($_POST['name']) AND isset($_POST['name'])){
            //$_SESSION['name'] = $_POST['name'];
            //Créer un objet user avec name et $password
            $user = new User($_POST);

            if ($user->isNameValid() && $user->isPasswordValid()){
                $um = new UserManager();
                $um->getOne($user);
            }
            else{
                //login failed
            }

            var_dump($user);
            //Comparer en base si un tel user existe
            //Si c'est le cas,
              //ça devrait hydrater ce même objet user
              //Remplir $_SESSION avec les infos de cet objet
            //Sinon,
              //Répondre fail au login
              //Vérifer le POST de déco
        }


        //$name = $_POST['name'];
        /*
        if (!empty($_POST['name'])){
            setcookie('user', $_POST['name']);
        }

        if (!empty($_COOKIE['user'])){
            $name = $_COOKIE['user'];
        }
        */
        //echo $this->twig->render('user.html.twig', ['name' => $name]);
    }

    public function logout()
    {
      $_SESSION['name'] = "";
    }

    public function signin()
    {
        $toto = new User(array($_POST['name'], $_POST['password'])
    }
}
