<?php

namespace P5blog\controllers;

class HomeController
{
    private $userController;
    private $articleController;

    public function getOne($id)
    {

    }

    public function viewHome()
    {
        $loader = new \Twig\Loader\FilesystemLoader('templates');

        // Instantiate our Twig
        $twig = new \Twig\Environment($loader);

        echo $twig->render('index.html.twig', ['foo' => $foo] );
    }

}