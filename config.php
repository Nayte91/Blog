<?php

/* MySQL server Hostname */
$host = 'blog-mysql';

/* MySQL account username */
$login = 'root';

/* MySQL account password */
$pass = 'toto';

/* The schema you want to use */
$schema = 'blog';

/* Connection string, or data source name */
$dsn = 'mysql:host=' . $host . ';dbname=' . $schema . ';charset=utf8';
