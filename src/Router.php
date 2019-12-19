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
    //private CommentController $cc;
    private string $path;
    private array $post;
    private array $get;
    private array $session;
    private array $server;
    private array $message = [];

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
        if (isset($_SESSION))
            $this->session = $_SESSION;

        $this->server = $_SERVER;
    }

    public function start()
    {
        if (array_key_exists('id', $this->session))
            $this->post['id'] = $this->session['id'];

        if (array_key_exists('admin', $this->session))
            $this->post['admin'] = $this->session['admin'];

        //Si le $_POST est rempli, lancer le form controller
        if ($this->server["REQUEST_METHOD"] == "POST"){
            try {
                $this->fc->dispatch($this->post);
                $this->message['content'] = $this->fc->getMessage();
                $this->message['type'] = "success";
            } catch (\Exception $e) {
                $this->message['content'] = $e->getmessage();
                $this->message['type'] = "error";
            }
        }

        switch(parse_url($this->path, PHP_URL_PATH)) {
            case '':
                $this->hc->viewHome($this->message);
                break;
            case 'blog':
                $this->bc->viewList($this->message);
                break;
            case 'addpost':
                $this->bc->addPost();
                break;
            case 'post':
                $this->bc->viewPost($this->get['id'], $this->message);
                break;
            case 'updatepost':
                $this->bc->updatePost($this->get['id']);
                break;
            default:
                header('HTTP/1.1 404 Not Found');
        }
    }
}
