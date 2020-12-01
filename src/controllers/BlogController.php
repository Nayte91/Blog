<?php

namespace P5blog\controllers;

use P5blog\models\Post;
use P5blog\models\Comment;

final class BlogController extends AbstractController
{
    public function __construct(string $path)
    {
        $explodedpath = explode('/', parse_url($path, PHP_URL_PATH), 2);
        $path = $explodedpath[0];

        if (count($explodedpath) > 1){
            $query = $explodedpath[1];
        }

        switch ($path) {
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

        $this->render('blog/index.html.twig', ['posts' => $posts]);
    }

    private function viewPost(int $id): void
    {
        $post = Post::readOne($id);
        $post->comments = Comment::countFromPost($id);
        $comments = Comment::retrieveFromPost($id);

        $this->render('blog/viewpost.html.twig', ['post' => $post, 'comments' => $comments]);
    }

    private function editPost(int $id = null): void
    {
        if ($id) {
            try {
                $post = Post::readOne($id);
            } catch (\Exception $e) {
                throw new \Exception("Il n'existe pas ce billet");
            }

            $this->render('blog/editpost.html.twig', ['post' => $post]);
        } else {
            $this->render('blog/editpost.html.twig');
        }
    }

	private function viewError(): void
	{
        $this->render('Exception/error.html.twig');
    }
}
