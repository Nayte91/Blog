<?php

namespace P5blog;

use P5blog\controllers\HomeController;
use P5blog\controllers\FormController;
//use P5blog\models\DBManager;

class Router
{
    private $homeController;
    private $formController;
    //private $postController;
    //private $commentController;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE){
            session_start();
        }
        //$this->manager = new DBManager;
        //$this->postController = new PostController();
        //$this->commentController = new CommentController();
        //$this->userController = new UserController();
    }

    public function start()
    {
        $message[] = "";
        //Si le $_POST est rempli, lancer le form controller
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            try {
                $this->formController = new FormController;
                $message['content'] = $this->formController->getMessage();
                $message['type'] = "success";
            } catch (\Exception $e) {
                //echo 'raté : ', $e->getmessage();
                $message['content'] = $e->getmessage();
                $message['type'] = "error";
            }
        }

        $getP = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_STRING);

        if (!$getP){
            $this->homeController = new HomeController;
            $this->homeController->viewHome($message);

            return;
        }

        /*
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
