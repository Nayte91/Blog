<?php

namespace P5blog\controllers;

use P5blog\models\Post;

final class HomeController extends AbstractController
{
    public function viewHome(?array $message): void
    {
        $posts = Post::retrieveLatest(5);
        var_dump("toto");
        // Test
        $foo = [
            ['name' => 'Alice'],
            ['name' => 'Bob'],
            ['name' => 'Charlie'],
            ['name' => 'David' ],
            ['name' => 'Eve'],
        ];

        echo $this->twig->render('home.html.twig', ['posts' => $posts, 'foo' => $foo, 'user' => $_SESSION, 'message' => $message]);
    }
    /*
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
    */
}
