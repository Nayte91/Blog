<?php

namespace P5blog;

use P5blog\controllers\HomeController;
use P5blog\controllers\FormController;
use P5blog\controllers\BlogController;

class Router
{
    private HomeController $hc;
    private FormController $fc;
    private BlogController $bc;
    //private CommentController $commentController;
    private string $path;
    private array $post;
    private array $get;
    private array $session;
    private array $server;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();

        $this->hc = new HomeController;
        $this->fc = new FormController;
        $this->bc = new BlogController;
        //$this->cc = new CommentController;
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
                $this->fc->dispatch($this->post);
                $message['content'] = $this->fc->getMessage();
                $message['type'] = "success";
            } catch (\Exception $e) {
                $message['content'] = $e->getmessage();
                $message['type'] = "error";
            }
        }

        switch(parse_url($this->path, PHP_URL_PATH)) {
            case '':
                $this->hc->viewHome($message);
                break;
            case 'blog':
                $this->bc->viewList($message);
                break;
            case 'addpost':
                $this->bc->addPost();
                break;
            case 'post':
                $this->bc->viewPost($this->get['id'], $message);
                break;
            default:
                header('HTTP/1.1 404 Not Found');
        }
    }
}
