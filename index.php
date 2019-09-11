<?php

namespace P5blog;

require_once 'router.php';
require_once 'controllers\HomeController.php';
//require_once 'models\DBManager.php';
require __DIR__.'\vendor\autoload.php';
session_start();

if (!isset($_SESSION['name'])) {
    $_SESSION['name'] = '';
    $_SESSION['role'] = '';
}

$router = new Router();
$router->start();

/*
require_once __DIR__.'/bootstrap.php';

// Sample data
$foo = [
    [ 'name'          => 'Alice' ],
    [ 'name'          => 'Bob' ],
    [ 'name'          => 'Charlie' ],
    [ 'name'          => 'David' ],
    [ 'name'          => 'Eve' ],
];

// Render our view
echo $twig->render('index.html.twig', ['foo' => $foo] );*/
