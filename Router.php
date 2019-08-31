<?php
namespace P5blog;

use P5blog\controllers\HomeController;

class Router
{
    private $homeController;
    private $postController;
    private $commentController;
    private $userController;

    public function __construct()
    {
        require_once 'controllers\HomeController.php';
        $this->homeController = new HomeController;
        /*$this->postController = new PostController();
        $this->commentController = new CommentController();
        $this->userController = new UserController();*/
    }

    public function start()
    {
        $getP = filter_input(INPUT_GET, 'p', FILTER_SANITIZE_STRING);

        if (!$getP) {
            $this->homeController->viewHome();
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
    }

}