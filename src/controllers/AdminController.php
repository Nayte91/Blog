<?php

namespace P5blog\controllers;

use P5blog\models\Post;
use P5blog\models\Comment;

final class AdminController extends AbstractController
{
    public function deleteComment(?array $session, ?array $message, $commentid): void
    {
        if ($session['admin'] != 1) {
            echo $this->twig->render('Exception/error.html.twig');
            return;
        }

        echo 'coucou';

        $this->viewAdmin($session, $message);
    }

    public function viewAdmin(?array $session, ?array $message)
    {
        if ($session['admin'] != 1) {
            echo $this->twig->render('Exception/error.html.twig');
            return;
        }

        $comments = Comment::retrieveAwaiting();

        echo $this->twig->render('admin.html.twig', ['user' => $session, 'message' => $message, 'comments' => $comments]);
    }
}