<?php

require 'config.php';

$db = new \PDO($dsn, $login,  $pass);

$sql = file_get_contents("mysql-template.sql");

$db->exec($sql);

$db->exec("INSERT INTO `user` (`creationdate`,`name`,`email`,`password`,`admin`) VALUES (NOW(),'Nayte','nayte91@gmail.com','".password_hash(trim('admin'), PASSWORD_DEFAULT)."',1);");