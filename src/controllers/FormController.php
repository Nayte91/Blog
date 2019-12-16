<?php

namespace P5blog\controllers;

use P5blog\models\User;
use P5blog\models\Post;

final class FormController extends AbstractController
{
    public function dispatch(array $form): void
    {
        //Vérifier le POST de login
        switch ($form['form'])
        {
            case "login":
                $this->login($form);
                break;
            case "logout":
                $this->logout();
                break;
            case "signin":
                $this->signin($form);
                break;
            case "signout":
                $this->signout();
                break;
            case "addpost":
                $this->addPost($form);
                break;
            case "contact":
                $this->contact($form);
                break;
            default:
                break;
        }
    }

    public function login(array $form): void
    {
        if (empty($form['name']) || !isset($form['name']) || empty($form['password']) || !isset($form['password']))
            throw new \Exception("bien joué le formulaire vide");

        $user = User::retrieveFromName($form);

        if (!isset($user) || !$user->verifyPassword($form['password']))
            throw new \Exception("identifiants invalides");

        $_SESSION = $user->getAll();

        $this->message = "Connexion réussie";
    }

    public function logout(): void
    {
        $_SESSION = [];
        $this->message = "Vous êtes déconnecté";
    }

    public function signin(array $form): void
    {
        if (array_search("", $form))
            throw new \Exception("bien joué le formulaire vide");

        if(User::createOne($form)){
            $this->message = "Compte créé, connectez-vous";
        } else {
            throw new \Exception("Création ratée");
        }
    }

    public function signout(): void
    {
        if (!array_key_exists("id", $_SESSION) || !$_SESSION['id'])
            throw new \Exception("Petit coquinou");

        if(User::deleteFromId($_SESSION['id'])){
            $_SESSION = [];
            $this->message = "Compte détruit";
        } else {
            throw new \Exception("Destruction ratée ?");
        }
    }

    /**
     * @param array $form -> 'form', 'title', 'heading', 'content', 'id', 'admin'
     * @throws \Exception
     */
    public function addpost(array $form): void
    {
        if (array_search("", $form))
            throw new \Exception("bien joué le formulaire vide");

        if ($form['admin'] != 1){
            return;
        }

        $form['author'] = $form['id'];
        unset($form['id']);

        if(Post::createOne($form)){
            echo 'toto';
            $this->message = "Billet bien ajouté !";
        } else {
            throw new \Exception("Billet non ajouté");
        }

        //$post = new Post($form);

        //$post->createOne();
    }

    public function contact($form): void
    {

    }
}
