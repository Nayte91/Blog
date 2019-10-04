<?php

namespace P5blog\controllers;

final class HomeController extends AbstractController
{
    public function viewHome()
    {
        //$uc = new UserController();

        // Test
        $foo = [
            ['name' => 'Alice'],
            ['name' => 'Bob'],
            ['name' => 'Charlie'],
            ['name' => 'David' ],
            ['name' => 'Eve'],
        ];

        echo $this->twig->render('home.html.twig', ['foo' => $foo]);
        echo $this->twig->render('user.html.twig', ['name' => $_SESSION['name']]);

        //$uc->viewLogin();
    }

    public function viewContact()
    {
        $name = NULL;

        if (!empty($_POST['name']))
        {
            setcookie('user', $_POST['name']);
        }

        if (!empty($_COOKIE['user']))
        {
            $name = $_COOKIE['user'];
        }

        echo $twig->render('contact.html.twig', ['name' => $name]);
    }
}
