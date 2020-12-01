<?php

//phpinfo();die;

require dirname(__DIR__, 1) . '/vendor/autoload.php';

$router = new P5blog\Router();
$router->start();