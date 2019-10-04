<?php
require __DIR__.'\vendor\autoload.php';

$router = new P5blog\Router();
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
