<?php

namespace P5blog\controllers;

use P5blog\models\Post;
use P5blog\models\Comment;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

final class BlogController
{
    public function __construct(string $path)
    {
	$explodedpath = explode('/', parse_url($path, PHP_URL_PATH), 2);
	$path = $explodedpath[0];

	if (count($explodedpath) > 1){
		$query = $explodedpath[1];
	}

        switch($path) {
            case '':
                $this->viewIndex();
                break;
	    case 'add':
                $this->editPost();
                break;
            case 'edit':
                $this->editPost($query);
                break;
            case 'post':
                $this->viewPost($query);
                break;
            default:
		$this->viewError();
                break;
        }
    }

    private function viewIndex(): void
    {
        $posts = Post::retrieveLatest();

        foreach ($posts as &$post) {
            $post['comments'] = Comment::countFromPost($post['id']);
        }
	$loader = new FilesystemLoader('../templates');
        $this->twig = new Environment($loader, ['cache' => false]);
        echo $this->twig->render('blog/index.html.twig', ['posts' => $posts, 'user' => $_SESSION]);
    }

    private function viewPost(int $id): void
    {
        $post = Post::retrieveFromId($id);
        $post->comments = Comment::countFromPost($id);
        $comments = Comment::retrieveFromPost($id);
	
	$loader = new FilesystemLoader('../templates');
        $this->twig = new Environment($loader, ['cache' => false]);
        echo $this->twig->render('blog/viewpost.html.twig', ['post' => $post, 'comments' => $comments, 'user' => $_SESSION]);
    }

    private function editPost(int $id = null): void
    {
	$loader = new FilesystemLoader('../templates');
        $this->twig = new Environment($loader, ['cache' => false]);

	if ($id){
	    try {
                $post = Post::retrieveFromId($id);
	    } catch (\Exception $e) {
		throw new \Exception("Il n'existe pas ce billet");
	    }
	    echo $this->twig->render('blog/editpost.html.twig', ['user' => $_SESSION, 'post' => $post]);
	} else {
	    echo $this->twig->render('blog/editpost.html.twig', ['user' => $_SESSION]);
	}
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
