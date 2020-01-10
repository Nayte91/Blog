<?php

namespace P5blog;

use P5blog\controllers\HomeController;
use P5blog\controllers\FormController;
use P5blog\controllers\BlogController;
use P5blog\controllers\AdminController;

class Router
{
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

        $this->path = ltrim($_SERVER['REQUEST_URI'], '/');
        $this->post = $_POST;
        $this->get = $_GET;
        $this->server = $_SERVER;
        if (isset($_SESSION))
            $this->session = $_SESSION;
    }

    public function start()
    {
        if (array_key_exists('id', $this->session))
            $this->post['id'] = $this->session['id'];

        if (array_key_exists('admin', $this->session))
            $this->post['admin'] = $this->session['admin'];

        //Si c'est une requête POST, lancer le form controller
        if ($this->server["REQUEST_METHOD"] == "POST"){
            $fc = new FormController();
            try {
                $fc->dispatch($this->post);
                $this->message['content'] = $fc->getMessage();
                $this->message['type'] = "success";
            } catch (\Exception $e) {
                $this->message['content'] = $e->getmessage();
                $this->message['type'] = "error";
            }
        }

        switch(parse_url($this->path, PHP_URL_PATH)) {
            case '':
                $hc = new HomeController();
                $hc->viewHome($this->session, $this->message);
                break;
            case 'admin':
                $hc = new AdminController();
                $hc->viewAdmin($this->session, $this->message);
                break;
            case 'blog':
                $bc = new BlogController();
                $bc->viewIndex($this->session, $this->message);
                break;
            case 'addpost':
                $bc = new BlogController();
                $bc->addPost($this->session, $this->message);
                break;
            case 'post':
                $bc = new BlogController();
                $bc->viewPost($this->get['id'], $this->session, $this->message);
                break;
            case 'updatepost':
                $bc = new BlogController();
                $bc->updatePost($this->get['id'], $this->session);
                break;
            default:
                header('HTTP/1.1 404 Not Found');
        }
    }
}
