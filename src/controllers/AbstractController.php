<?php

namespace P5blog\controllers;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

abstract class AbstractController
{
    protected $user;
    protected $post;
    protected $twig;
    protected $message;

    public function __construct()
    {
        $loader = new FilesystemLoader('../templates');
        $this->twig = new Environment($loader, ['cache' => false]);
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }
}
