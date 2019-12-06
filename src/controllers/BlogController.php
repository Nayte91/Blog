<?php

namespace P5blog\controllers;

use P5blog\models\Post;

final class BlogController extends AbstractController
{
    public function viewList(?array $message = null): void
    {
        $posts = Post::retrieveLatest();

        echo $this->twig->render('blog/blog.html.twig', ['posts' => $posts, 'user' => $_SESSION, 'message' => $message]);
    }

    public function addPost(?array $message = null): void
    {
        echo $this->twig->render('blog/addpost.html.twig', ['user' => $_SESSION, 'message' => $message]);
    }
}