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
            case "deletePost":
                $this->deletePost($form);
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

        if(!User::createOne($form))
            throw new \Exception("Création ratée");

        $this->message = "Compte créé, connectez-vous";
    }

    public function signout(): void
    {
        if (!array_key_exists("id", $_SESSION) || !$_SESSION['id'])
            throw new \Exception("Petit coquinou");

        if(!User::deleteFromId($_SESSION['id']))
            throw new \Exception("Destruction ratée ?");

        $_SESSION = [];
        $this->message = "Compte détruit";
    }

    /**
     * @param array $form -> 'form', 'title', 'heading', 'content', 'id', 'admin'
     * @throws \Exception
     */
    public function addPost(array $form): void
    {
        $form['author'] = $form['id'];
        unset($form['id']);

        if (array_search("", $form))
            throw new \Exception("bien joué le formulaire vide");

        if ($form['admin'] != 1)
            throw new \Exception("Pas admin, que fais tu là ?");

        if(!Post::createOne($form))
            throw new \Exception("Billet non ajouté");

        $this->message = "Billet bien ajouté !";
    }

    public function deletePost(array $form): void
    {

        if(!Post::deleteFromId($form['postid']))
            throw new \Exception("Impossible de supprimer ce billet...");

        $this->message = "Billet détruit !";
    }
    public function contact($form): void
    {

    }
}
