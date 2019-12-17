<?php

namespace P5blog;

use P5blog\controllers\HomeController;
use P5blog\controllers\FormController;
use P5blog\controllers\BlogController;

class Router
{
    private $homeController;
    private $formController;
    private $blogController;
    //private $commentController;
    private $path;
    private $post;
    private $get;
    private $session;
    private $server;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        $this->homeController = new HomeController;
        $this->formController = new FormController;
        $this->blogController = new BlogController;
        //$this->postController = new PostController();
        $this->path = ltrim($_SERVER['REQUEST_URI'], '/');
        $this->post = $_POST;
        $this->get = $_GET;
        $this->session = $_SESSION;
        $this->server = $_SERVER;
    }

    public function start()
    {
        if (isset($this->session) && array_key_exists('id', $this->session))
            $this->post['id'] = $this->session['id'];

        if (isset($this->session) && array_key_exists('admin', $this->session))
            $this->post['admin'] = $this->session['admin'];

        $message[] = "";

        //Si le $_POST est rempli, lancer le form controller
        if ($this->server["REQUEST_METHOD"] == "POST"){
            try {
                $this->formController->dispatch($this->post);
                $message['content'] = $this->formController->getMessage();
                $message['type'] = "success";
            } catch (\Exception $e) {
                $message['content'] = $e->getmessage();
                $message['type'] = "error";
            }
        }

        switch(parse_url($this->path, PHP_URL_PATH)) {
            case '':
                $this->homeController->viewHome($message);
                break;
            case 'blog':
                $this->blogController->viewList($message);
                break;
            case 'addpost':
                $this->blogController->addPost();
                break;
            case 'post':
                $this->blogController->viewPost($this->get['id'], $message);
                break;
            default:
                header('HTTP/1.1 404 Not Found');
        }
    }
}
