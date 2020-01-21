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
	
	//$second = explode('/', parse_url($path, PHP_URL_PATH), 2)[1];
	
	$third = explode('/', parse_url($path, PHP_URL_PATH), 2);
	
	if (count($third) == 1){
		$suiteurl = '';
	} else {
		$suiteurl = $third[1];
	}
	var_dump($third);

        switch($third[0]) {
            case '':
                $this->viewIndex();
                break;
	    case 'addpost':
                $this->addPost();
                break;
            case 'posts':
                $this->viewPost($third[1]);
                break;
            case 'updatepost':
                $this->updatePost('8');
                break;
            default:
		$this->viewError();
                break;
        }
    }

PUT localhost/blog/posts/8

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

    private function addPost(?array $message = null): void
    {
	$loader = new FilesystemLoader('../templates');
        $this->twig = new Environment($loader, ['cache' => false]);
        echo $this->twig->render('blog/addpost.html.twig', ['user' => $_SESSION]);
    }

    private function viewPost(int $id, ?array $message = null): void
    {
        $post = Post::retrieveFromId($id);
        $post->comments = Comment::countFromPost($id);
        $comments = Comment::retrieveFromPost($id);
	
	$loader = new FilesystemLoader('../templates');
        $this->twig = new Environment($loader, ['cache' => false]);
        echo $this->twig->render('blog/viewpost.html.twig', ['post' => $post, 'comments' => $comments, 'user' => $_SESSION]);
    }

    private function updatePost(int $id): void
    {
        $post = Post::retrieveFromId($id);
	
	 $loader = new FilesystemLoader('../templates');
        $this->twig = new Environment($loader, ['cache' => false]);
        echo $this->twig->render('blog/updatepost.html.twig', ['post' => $post, 'user' => $_SESSION]);
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
