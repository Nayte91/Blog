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
            case "deletePost":
                $this->deletePost($form);
                break;
            case "updatePost":
                $this->updatePost($form);
                break;
            case "addComment":
                $this->addComment($form);
                break;
            case "deleteComment":
                $this->deleteComment($form);
                break;
            case "updateComment":
                $this->updateComment($form);
                break;
            case "contact":
                $this->contact($form);
                break;
            default:
                break;
        }
    }

    private function login(array $form): void
    {
        if (empty($form['name']) || !isset($form['name']) || empty($form['password']) || !isset($form['password']))
            throw new \Exception("bien joué le formulaire vide");

        $user = User::retrieveFromName($form);

        if (!isset($user) || !$user->verifyPassword($form['password']))
            throw new \Exception("identifiants invalides");

        $_SESSION = $user->getAll();
        $this->message = "Connexion réussie";
    }

    private function logout(): void
    {
        $_SESSION = [];
        $this->message = "Vous êtes déconnecté";
    }

    private function signin(array $form): void
    {
        if (array_search("", $form))
            throw new \Exception("bien joué le formulaire vide");

        if(!User::createOne($form))
            throw new \Exception("Création ratée");

        $this->message = "Compte créé, connectez-vous";
    }

    private function signout(): void
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
    private function addPost(array $form): void
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

    private function deletePost(array $form): void
    {
        if(!Post::deleteFromId($form['postid']))
            throw new \Exception("Impossible de supprimer ce billet...");

        $this->message = "Billet détruit !";
    }

    /**
     * @param array $form -> 'form', 'postId', 'userId', 'title', 'heading', 'content', 'admin'
     * @throws \Exception
     */
    private function updatePost(array $form): void
    {
        $form['id'] = $form['postid'];
        unset($form['postid']);

        if (array_search("", $form))
            throw new \Exception("bien joué le formulaire vide");

        if ($form['admin'] != 1)
            throw new \Exception("Pas admin, que fais tu là ?");

        if(!Post::updateOne($form))
            throw new \Exception("Billet non modifié");

        $this->message = "Billet modifié";
    }

    private function contact(array $form): void
    {
        // Check for empty fields
        if(empty(['name'])  		||
            empty($form['email']) 		||
            empty($form['message'])	||
            !filter_var($form['email'],FILTER_VALIDATE_EMAIL))
        {
            throw new \Exception("On envoie du vide ?");
        }

        $name = strip_tags(htmlspecialchars($form['name']));
        $email_address = strip_tags(htmlspecialchars($form['email']));
        $message = strip_tags(htmlspecialchars($form['message']));

        // Create the email and send the message
        $to = 'robic.julien@free.fr'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
        $email_subject = "Message par le blog:  $name";
        $email_body = "Vous avez reçu un message par le formulaire de votre blog.\n\n"."Voici les détails:\n\nNon: $name\n\nEmail: $email_address\n\nMessage:\n$message";
        $headers = "From: noreply@yourdomain.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
        $headers .= "Reply-To: $email_address";

        if (!mail($to,$email_subject,$email_body,$headers))
            throw new \Exception("Pas de serveur mail configuré");

        $this->message = "Message envoyé !";
    }

    private function addComment(array $form)
    {

    }

    private function updateComment(array $form)
    {
    }

    private function deleteComment(array $form)
    {
    }
}
