<?php

use Bookshop\Book;
use Bookshop\Category;

require_once ('inc/bootstrap.php');

$view = $default_view;



$postAction = $_REQUEST[Bookshop\Controller::ACTION] ?? null;
if ($postAction != null) {
    Bookshop\Controller::getInstance()->invokePostAction();
}

if (isset($_REQUEST['view'])
    && !empty($_REQUEST['view'])
    && file_exists(__DIR__ . '/views/' . $_REQUEST['view'] . '.php')) {

    $view = $_REQUEST['view'];
}

require_once ('views/' . $view . '.php');