<?php
namespace Bookshop;

/**
 * Controller
 * 
 * class handles POST requests and redirects 
 * the client after processing
 * - demo of singleton pattern
 */

 SessionContext::create();

class Controller {
  // static strings used in views

  /*  @TODO: replace with enums */
  
  public const string ACTION = 'action';
  public const string PAGE = 'page';
  public const string CC_NAME = 'nameOnCard';
  public const string CC_NUMBER = 'cardNumber';
  public const string ACTION_ADD = 'addToCart';
  public const string ACTION_REMOVE = 'removeFromCart';
  public const string ACTION_ORDER = 'placeOrder';
  public const string ACTION_LOGIN = 'login';
  public const string ACTION_LOGOUT = 'logout';
  public const string USER_NAME = 'userName';
  public const string USER_PASSWORD = 'password';

  private static $instance = false;

  /**
   * 
   * @return Controller
   */
  public static function getInstance() : Controller {

    if (!self::$instance) {
      self::$instance = new Controller();
    }
    return self::$instance;
  }

  private function __construct() {
    
  }

  /**
   * 
   * processes POST requests and redirects client depending on selected 
   * action
   * 
   * PHP 8: returns never because either redirect or exception
   * @throws Exception
   */
  public function invokePostAction() : never {

    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
      throw new \Exception('Controller can only handle POST requests.');
    } 
    elseif (!isset($_REQUEST[self::ACTION])) {
      throw new \Exception(self::ACTION . ' not specified.');
    }

    // reset errors 
    $_SESSION['errors'] = null;

    // now process the assigned action
    $action = $_REQUEST[self::ACTION];

    switch ($action) {

      case self::ACTION_ADD :
        ShoppingCart::add((int) $_REQUEST['bookId']);
        Util::redirect();
        break;

      case self::ACTION_REMOVE :
        ShoppingCart::remove((int) $_REQUEST['bookId']);
        Util::redirect();
        break;

      case self::ACTION_ORDER :
        $user = AuthenticationManager::getAuthenticatedUser();

        if ($user == null) {
					$this->forwardRequest(['Not logged in.']);
					break;
        }
        
				if (!$this->processCheckout($_POST[self::CC_NAME], $_POST[self::CC_NUMBER])) {
					$this->forwardRequest(['Checkout failed.']);
				}
				break;

      case self::ACTION_LOGIN :
        //try to authenticate the given user
        if (!AuthenticationManager::authenticate($_REQUEST[self::USER_NAME], $_REQUEST[self::USER_PASSWORD])) {
          $this->forwardRequest(array('Invalid user name or password.'));
        }
        Util::redirect();
        break;

      case self::ACTION_LOGOUT :
        //sign out current user
        AuthenticationManager::signOut();
        Util::redirect();
        break;

      default : 
        throw new \Exception('Unknown controller action: ' . $action);
        break;
    }
  }

  /**
   * 
   * @param string $nameOnCard
   * @param integer $cardNumber
   * @return bool
   */
  protected function processCheckout(string $nameOnCard = null, string $cardNumber = null) : bool {

    $errors = [];
    $nameOnCard = trim($nameOnCard);
    if ($nameOnCard == null || strlen($nameOnCard) == 0) {
      $errors[] = 'Invalid name on card.';
    }
    if ($cardNumber == null || strlen($cardNumber) != 16 || !ctype_digit($cardNumber)) {
      $errors[] = 'Invalid card number. Card number must be sixteen digits.';
    }

    if (sizeof($errors) > 0) {
      $this->forwardRequest($errors);
      return false;
    }

    //check cart
    if (ShoppingCart::size() == 0) {
      $this->forwardRequest(['Shopping cart is empty.']);
      return false;
    }

    //try to place a new order
    $user = AuthenticationManager::getAuthenticatedUser();
    $orderId = \Data\DataManager::createOrder($user->getId(), ShoppingCart::getAll(), $nameOnCard, $cardNumber);
    if (!$orderId) {
      $this->forwardRequest(['Could not create order.']);
      return false;
    }
    //clear shopping card and redirect to success page
    ShoppingCart::clear();
    Util::redirect('index.php?view=success&orderId=' . rawurlencode($orderId));

    return true;
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
