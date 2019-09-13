<?php

namespace P5blog\controllers;

final class HomeController extends AbstractController
{
    private $postlist;

    public function __construct()
    {
        //$this->user = new User;
        //$this->postlist = new Post;
    }

    public function viewHome()
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
        $twig = new \Twig\Environment($loader, ['cache' => false]);

        echo $twig->render('home.html.twig', ['foo' => $foo] );
    }
}
