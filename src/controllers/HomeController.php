<?php

namespace P5blog\controllers;

use P5blog\models\Post;

final class HomeController extends AbstractController
{
    public function viewHome(?array $session, ?array $message): void
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

        echo $this->twig->render('home.html.twig', ['posts' => $posts, 'foo' => $foo, 'user' => $session, 'message' => $message]);
    }

    public function viewAdmin(?array $session, ?array $message): void
    {
        $comments = Comment::retrieveAwaiting();

        echo $this->twig->render('admin.html.twig', ['user' => $session, 'message' => $message, 'comments' => $comments]);
    }
}
