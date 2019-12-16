<?php

namespace P5blog\controllers;

use P5blog\models\Post;
use P5blog\models\User;

abstract class AbstractController
{
    protected $user;
    protected $post;
    protected $twig;
    protected $message;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('templates');
        $this->twig = new \Twig\Environment($loader, ['cache' => false]);
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }
}
