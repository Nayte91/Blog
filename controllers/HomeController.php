<?php

namespace P5blog\controllers;

class HomeController
{
    private $userController;
    private $articleController;

    public function viewHome($test)
    {
        $loader = new \Twig\Loader\FilesystemLoader('templates');

        // Sample data
        $foo = [
            ['name' => 'Alice'],
            ['name' => 'Bob'],
            ['name' => 'Charlie'],
            ['name' => 'David' ],
            ['name' => 'Eve'],
        ];

        // Instantiate our Twig
        $twig = new \Twig\Environment($loader);

        echo $twig->render('index.html.twig', ['foo' => $test] );
    }
}