<?php

namespace P5blog\controllers;

use P5blog\models\Comment;

final class AdminController extends AbstractController
{
    public function __construct(string $path)
    {
        if (!array_key_exists('admin', $_SESSION) || $_SESSION['admin'] != 1 ) {
            $this->viewError();
            return;
        }

        $explodedpath = explode('/', parse_url($path, PHP_URL_PATH), 2);
        $action = $explodedpath[0];

        if (count($explodedpath) == 1) {
            $number = '';
        } else {
            $number = $explodedpath[1];
        }

        switch ($action) {
            case '':
                $this->viewAdmin();
                break;
            default:
		        $this->viewError();
                break;
        }
    }

    private function viewAdmin(): void
    {
        $comments = Comment::retrieveAwaiting();

        $this->render('admin.html.twig', ['comments' => $comments]);
    }

    private function viewError(): void
    {
        $this->render('Exception/error.html.twig');
    }
}
