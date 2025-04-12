<?php

namespace Bookshop;

use Cassandra\Exception\UnauthorizedException;

SessionContext::create();
class Controller
{
    public const string ACTION = 'action';
    public const string ACTION_ADD = 'addToCart';
    public const string ACTION_REMOVE = 'removeFromCart';
    public const string PAGE = 'page';

    private static $instance;

    public static function getInstance() : Controller {
        if (!isset(self::$instance)) {
            self::$instance = new Controller();
        }
        return self::$instance;
    }

    private function __construct() {}

    public function invokePostAction() : never {

      if  ( $_SERVER['REQUEST_METHOD'] != 'POST') {
        throw new \Exception('Invalid request method');
      }

       elseif (!isset($_REQUEST[self::ACTION])) {
          throw new \Exception('Invalid request action');
       }

      $action = $_REQUEST[self::ACTION];

      switch ($action) {

          case self::ACTION_ADD:
              ShoppingCart::add((int) $_REQUEST['bookId']);
              Util::redirect();
              break;

          case self::ACTION_REMOVE:
              ShoppingCart::remove((int) $_REQUEST['bookId']);
              Util::redirect();
              break;

          default:
              throw new \Exception('Invalid request action');
              break;
      }

    }
}