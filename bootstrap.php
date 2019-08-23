<?php

// Load our autoloader
require_once 'vendor/autoload.php';

// Specify our Twig templates location
$loader = new \Twig\Loader\FilesystemLoader('templates');

// Instantiate our Twig
$twig = new \Twig\Environment($loader);