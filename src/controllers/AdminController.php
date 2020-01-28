<?php

namespace P5blog\controllers;

use P5blog\models\Post;
use P5blog\models\Comment;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

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
	var_dump($action);

        switch($action) {
            case '':
                $this->viewAdmin();
                break;
	    case 'validate':
		$this->validateComment((int)$number);
		break;
	    case 'delete':
		$this->deleteComment((int)$number);
		break;
            default:
		$this->viewError();
                break;
        }
    }

    private function viewAdmin()
    {
        $comments = Comment::retrieveAwaiting();

        $loader = new FilesystemLoader('../templates');
        $twig = new Environment($loader, ['cache' => false]);

        echo $twig->render('admin.html.twig', [
		'user' => $_SESSION,
		'comments' => $comments,
            ]);
    }

    private function validateComment(int $id): void
    {
	Comment::validateOne($id);

        header("Location: /admin");
    }

    private function deleteComment(int $id): void
    {
	
	Comment::deleteOne($id);

	header("Location: /admin");
    }

    private function viewError()
    {
        $loader = new FilesystemLoader('../templates');
        $twig = new Environment($loader, ['cache' => false]);

        echo $twig->render('Exception/error.html.twig', [
		'user' => $_SESSION,
            ]);
    }
}
