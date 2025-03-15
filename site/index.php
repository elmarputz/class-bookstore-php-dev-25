<?php

use Bookshop\Book;

require_once ('inc/bootstrap.php');

$view = $default_view;

if (isset($_REQUEST['view'])
    && !empty($_REQUEST['view'])
    && file_exists(__DIR__ . '/views/' . $_REQUEST['view'] . '.php')) {

    $view = $_REQUEST['view'];
}

$book = new Book(1,2,"test", "test", 12.3);
var_dump($book);

require_once ('views/' . $view . '.php');