<?php

namespace P5blog\controllers;

use P5blog\models\Post;

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

        $this->render('home.html.twig', ['posts' => $posts, 'foo' => $foo]);
    }
}
