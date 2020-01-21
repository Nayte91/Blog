<?php

namespace P5blog\controllers;

use P5blog\models\Post;

final class HomeController extends AbstractController
{
    public function viewHome(): void
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

        echo $this->twig->render('home.html.twig', ['posts' => $posts, 'foo' => $foo, 'user' => $_SESSION]);
    }
}
