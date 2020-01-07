<?php

namespace P5blog\controllers;

use P5blog\models\Post;
use P5blog\models\Comment;

final class BlogController extends AbstractController
{
    public function viewIndex(?array $session, ?array $message = null): void
    {
        $posts = Post::retrieveLatest();

        foreach ($posts as $key => &$post) {
            $post['comments'] = Comment::countFromPost($post['id']);
        }

        echo $this->twig->render('blog/index.html.twig', ['posts' => $posts, 'user' => $session, 'message' => $message]);
    }

    public function addPost(?array $session, ?array $message = null): void
    {
        echo $this->twig->render('blog/addpost.html.twig', ['user' => $session, 'message' => $message]);
    }

    public function viewPost(int $id, ?array $session, ?array $message = null): void
    {
        $post = Post::retrieveFromId($id);
        $post->comments = Comment::countFromPost($id);
        $comments = Comment::retrieveFromPost($id);

        echo $this->twig->render('blog/viewpost.html.twig', ['post' => $post, 'comments' => $comments, 'user' => $session, 'message' => $message]);
    }

    public function updatePost(int $id, ?array $session): void
    {
        $post = Post::retrieveFromId($id);

        echo $this->twig->render('blog/updatepost.html.twig', ['post' => $post, 'user' => $session]);
    }
}