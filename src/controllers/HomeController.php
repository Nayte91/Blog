<?php

namespace P5blog\controllers;

use P5blog\models\Post;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

final class HomeController extends AbstractController
{
    public function __construct()
    {
        $posts = Post::retrieveLatest(5);

        // Test
        $foo = [
            ['name' => 'Alice'],
            ['name' => 'Bob'],
            ['name' => 'Charlie'],
            ['name' => 'David' ],
            ['name' => 'Eve'],
        ];

        $loader = new FilesystemLoader('../templates');
        $twig = new Environment($loader, ['cache' => false]);
        echo $twig->render('home.html.twig', ['posts' => $posts, 'foo' => $foo, 'user' => $_SESSION]);
    }
}
