<?php

namespace Bookshop;

//as soon as shopping cart is referenced the session context is created
SessionContext::create();

/**
 * ShoppingCart
 *
 *
 * @package
 * @subpackage
 * @author     John Doe <jd@fbi.gov>
 */
class ShoppingCart {

    /**
     * add an item to the shopping cart
     *
     * @param integer $bookId book id
     */
    public static function add(int $bookId) : void {
        $cart = self::getCart();
        $cart[$bookId] = $bookId;
        self::storeCart($cart);
    }

    /**
     * remove an item from the shopping cart
     *
     * @param integer $bookId book id
     */
    public static function remove(int $bookId) : void {
        $cart = self::getCart();
        unset($cart[$bookId]);
        self::storeCart($cart);
    }

    /**
     * empty the shopping cart
     *
     */
    public static function clear() : void {
        self::storeCart([]);
    }

    /**
     * check if an item is in the shopping cart
     *
     * @param integer $bookId book id
     */
    public static function contains(int $bookId) : bool {
        $cart = self::getCart();
        return array_key_exists($bookId, $cart);
    }

    /**
     * get number of shopping cart items
     *
     */
    public static function size() : int {
        return sizeof(self::getCart());
    }

    /**
     * get the shopping cart contents
     *
     */
    public static function getAll() : array {
        return self::getCart();
    }

    /**
     * add an item to the shopping cart
     */
    private static function getCart() : array {
        return $_SESSION['cart'] ?? [];
    }

    /**
     * make shopping cart persistent
     * @param array $cart
     */
    private static function storeCart(array $cart) : void {
        $_SESSION['cart'] = $cart;
    }

}
