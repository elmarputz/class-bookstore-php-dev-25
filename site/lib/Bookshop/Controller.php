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
    public const string USER_NAME = 'userName';
    public const string USER_PASSWORD = 'password';

    public const string ACTION_LOGIN = 'login';
    public const string ACTION_LOGOUT = 'logout';

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

      $_SESSION['errors'] = null;
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

          case self::ACTION_LOGIN:
              if (!AuthenticationManager::authenticate($_REQUEST[self::USER_NAME], $_REQUEST[self::USER_PASSWORD])) {
                $this->forwardRequest(['Invalid user name or password']);
              }
              Util::redirect();
              break;

          case self::ACTION_LOGOUT:
              AuthenticationManager::signOut();
              Util::redirect();
              break;

          default:
              throw new \Exception('Invalid request action');
              break;
      }

    }



    /**
     *
     * @param array $errors : optional assign it to
     * @param string $target : url for redirect of the request
     */
    protected function forwardRequest(array $errors = null, string $target = null) : never {
        //check for given target and try to fall back to previous page if needed
        if ($target == null) {
            if (!isset($_REQUEST[self::PAGE])) {
                throw new \Exception('Missing target for forward.');
            }
            $target = $_REQUEST[self::PAGE];
        }

        // optional - add errors to redirect and process them in view
        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors;
        }

        //forward request to target
        header('location: ' . $target);
        exit();
    }

}