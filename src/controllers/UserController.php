<?php

namespace P5blog\controllers;

class UserController extends AbstractController
{


    public function viewLogin()
    {
        $name = NULL;

        if (!empty($_POST['name'])){
            setcookie('user', $_POST['name']);
        }

        if (!empty($_COOKIE['user'])){
            $name = $_COOKIE['user'];
        }

        echo $this->twig->render('login.html.twig', ['name' => $name]);
    }
}