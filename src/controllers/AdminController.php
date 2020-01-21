<?php

namespace P5blog\controllers;

use P5blog\models\Post;
use P5blog\models\Comment;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class AdminController
{
    public function __construct(string $path)
    {
        if (!array_key_exists('admin', $_SESSION) || $_SESSION['admin'] != 1 ) {
            $this->viewError();
            return;
        }
	
	//if (!array_key_exists('1', explode('/', parse_url($path, PHP_URL_PATH), 2))){
	
	//$second = explode('/', parse_url($path, PHP_URL_PATH), 2)[1];

        switch($path) {
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

        $loader = new FilesystemLoader('../templates');
        $twig = new Environment($loader, ['cache' => false]);

        echo $twig->render('admin.html.twig', [
		'user' => $_SESSION,
		'comments' => $comments,
            ]);
    }

    public function deleteComment(?string $path, ?array $message, $commentid): void
    {
        if ($session['admin'] != 1) {
            echo $this->twig->render('Exception/error.html.twig');
            return;
        }

        $this->viewAdmin($path);
    }

    private function validateComment(): void
    {

    }

    private function viewError():void
    {
        $loader = new FilesystemLoader('../templates');
        $twig = new Environment($loader, ['cache' => false]);

        echo $twig->render('Exception/error.html.twig', [
		'user' => $_SESSION,
            ]);
    }
}
