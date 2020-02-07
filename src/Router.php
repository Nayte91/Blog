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
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
	    }

        $this->path = ltrim($_SERVER['REQUEST_URI'], '/');
        $this->post = $_POST;
        $this->get = $_GET;
        $this->server = $_SERVER;
	    $_SESSION['message_content'] = '';
        $_SESSION['message_type'] = '';
    }

    public function start()
    {
        if (isset($_SESSION)) {
            if (array_key_exists('id', $_SESSION)) {
                $this->post['id'] = $_SESSION['id'];
	        }

            if (array_key_exists('admin', $_SESSION)) {
                $this->post['admin'] = $_SESSION['admin'];
	        }
        }

        //Si c'est une requête POST, lancer le form controller
        if ($this->server["REQUEST_METHOD"] != "GET") {
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
		
        try {
            $controller = $this->customController();
        } catch (\Exception $e) {
            $_SESSION['message_content'] = $e->getmessage();
                    $_SESSION['message_type'] = "error";
            $controller = new HomeController();
        }
    }

    private function customController()
    {
        //Virer le "/" de fin d'url si il y en a un
        if (substr($this->path, -1) == "/") {
            substr($this->path, 0, -1);
        }

        $explodedpath = explode('/', parse_url($this->path, PHP_URL_PATH), 2);
	    $rootpath = $explodedpath[0];

	if (count($explodedpath) == 1) {
	    $this->path = '';
	} else {
	    $this->path = $explodedpath[1];
	}	

	$classname = "P5blog\\controllers\\" . ucfirst(strtolower($rootpath)) . "Controller";

	if ($rootpath == '') {
	    return new HomeController;
	}

	if (!class_exists($classname)) {
	    throw new \Exception("C'est pas le bon site là");
	}

	return new $classname($this->path);
    }
}
