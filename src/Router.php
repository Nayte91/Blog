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
    }

    public function start()
    {
        if (isset($_SESSION)){
            if (array_key_exists('id', $_SESSION))
                $this->post['id'] = $_SESSION['id'];

            if (array_key_exists('admin', $_SESSION))
                $this->post['admin'] = $_SESSION['admin'];
        }

        //Si c'est une requête POST, lancer le form controller
        if ($this->server["REQUEST_METHOD"] == "POST"){
            $fc = new FormController();
            try {
                $fc->dispatch($this->post);
                $_SESSION['message_content'] = $fc->message;
                $_SESSION['message_type'] = "success";
            } catch (\Exception $e) {
                $_SESSION['message_content'] = $e->getmessage();
                $_SESSION['message_type'] = "error";
            }
        }

        //Virer le "/" de fin d'url si il y en a un
        if (substr($this->path, -1) == "/")
            substr($this->path, 0, -1);

        $rootpath = explode('/', parse_url($this->path, PHP_URL_PATH), 2);
	
	if (count($rootpath) == 1){
		$suiteurl = '';
	} else {
		$suiteurl = $rootpath[1];
	}

        switch($rootpath[0]) {
            case '':
                $hc = new HomeController();
                $hc->viewHome();
                break;
            case 'admin':
                $hc = new AdminController($suiteurl);
                break;
            case 'blog':
                $bc = new BlogController($suiteurl);
                //$bc = new BlogController();
                //$bc->viewIndex();
                break;

        }
    }
}
