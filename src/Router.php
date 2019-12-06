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
    //private $postController;
    //private $commentController;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        $this->homeController = new HomeController;
        $this->formController = new FormController;
        $this->blogController = new BlogController;
        //$this->postController = new PostController();
    }

    public function start()
    {
        $path = ltrim($_SERVER['REQUEST_URI'], '/');
        $post = $_POST;

        $message[] = "";

        //Si le $_POST est rempli, lancer le form controller
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            try {
                $this->formController->dispatch($post);
                $message['content'] = $this->formController->getMessage();
                $message['type'] = "success";
            } catch (\Exception $e) {
                //echo 'raté : ', $e->getmessage();
                $message['content'] = $e->getmessage();
                $message['type'] = "error";
            }
        }

        $getP = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_STRING);

        $elements = explode('/', $path);       // Split path on slashes
        if(empty($elements[0])) {                       // No path elements means home
            $this->homeController->viewHome($message);
        } else switch(array_shift($elements))   // Pop off first item and switch
        {
            case 'blog':
                $this->blogController->viewList();
                break;
            case 'addpost':
                $this->blogController->addPost();
                break;
            default:
                header('HTTP/1.1 404 Not Found');
        }

        /*
        if (!$getP){
            $this->homeController->viewHome($message);

            return;
        }


        $route = $this->getRouteWithoutRights($getP);

        if (!$route AND $this->homeController->checkRights($getP)) {
            $route = $this->getRouteWithRights($getP);
        }

        if ($route AND $this->getController($route['class'])) {
            if (!$this->{$this->getController($route['class'])}->{$getP}($route['parameters'])) {
                $errorMessage = isset($GLOBALS['errorMessage']) ? $GLOBALS['errorMessage'] : '';
                $this->homeController->displayError('Une erreur est survenue<br>' . $errorMessage);
            }
            return;
        }

        $this->homeController->displayError('Action interdite ou page inexistante !!!');
        */
    }
}
