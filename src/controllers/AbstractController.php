<?php

namespace P5blog\controllers;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class AbstractController
{
    protected Environment $twig;
    protected FilesystemLoader $loader;
    protected array $table;


    /**
     * Handle the twig rendering for all controllers
     * @param string $path
     * @param array ...$params
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function render(string $path, array ...$params): void
    {
        $this->loader = new FilesystemLoader('../templates');
        $this->twig = new Environment($this->loader, ['cache' => false]);

        $this->table['user'] = $_SESSION;

        foreach ($params as $param) {
            foreach ($param as $key => $value) {
                $this->table[$key] = $value;
            }
        }

        echo $this->twig->render($path, $this->table);
    }
}
