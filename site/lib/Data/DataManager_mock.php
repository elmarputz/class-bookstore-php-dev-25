<?php

namespace Data;

use Bookshop\Category;
use Bookshop\Book;
use Bookshop\User;
use Bookshop\PagingResult;

/**
 * DataManager
 * Mock Version
 * 
 * 
 * @package    
 * @subpackage 
 * @author     John Doe <jd@fbi.gov>
 */
class DataManager implements IDataManager {


    /**
     * @param string $type 'categories', 'books', 'users'
     * @return array
     */
    private static function getMockData(string $type) : array {

        $data = [];
        switch ($type) {
            case 'categories':
              $data = [
                1 => new Category(1, "Mobile & Wireless Computing"),
                2 => new Category(2, "Functional Programming"),
                3 => new Category(3, "C / C++"),
                4 => new Category(4, "<< New Publications >>"),
              ];
              break;
            case 'books':
              $data = [
                1  => new Book(1, 1, "Hello, Android:\nIntroducing Google's Mobile Development Platform", "Ed Burnette", 19.97),
                2  => new Book(2, 1, "Android Wireless Application Development", "Shane Conder, Lauren Darcey", 31.22),
                5  => new Book(5, 1, "Professional Flash Mobile Development", "Richard Wagner", 19.90),
                7  => new Book(7, 1, "Mobile Web Design For Dummies", "Janine Warner, David LaFontaine", 16.32),
                11 => new Book(11, 2, "Introduction to Functional Programming using Haskell", "Richard Bird", 74.75),
                //book with bad title to show scripting attack - add for scripting attack demo only
                12 => new Book(12, 2, "Scripting (Attacks) for Beginners - <script type=\"text/javascript\">alert('All your base are belong to us!');</script>", "John Doe", 9.99),
                14 => new Book(14, 2, "Expert F# (Expert's Voice in .NET)", "Antonio Cisternino, Adam Granicz, Don Syme", 47.64),
                16 => new Book(16, 3, "C Programming Language\n(2nd Edition)", "Brian W. Kernighan, Dennis M. Ritchie", 48.36),
                27 => new Book(27, 3, "C++ Primer Plus\n(5th Edition)", "Stephan Prata", 36.94),
                29 => new Book(29, 3, "The C++ Programming Language", "Bjarne Stroustrup", 67.49),
              ];
              break;
            case 'users':
              $data = [
                1 => new User(1, "scm4", "a8af855d47d091f0376664fe588207f334cdad22"), //USER = scm4; PASSWORD = scm4
              ];
				      break;
        }
        return $data;

    }

  // /mock data


  /**
   * get the categories
   * @return array of Category-items
   */
  public static function getCategories() : array {
    
    return self::getMockData('categories');
  }

  /**
   * get the books per category
   *
   * @param integer $categoryId  numeric id of the category
   * @return array of Book-items
   */
  public static function getBooksByCategory(int $categoryId) : array {
    
    $res = [];
    foreach (self::getMockData('books') as $book) {
      if ($book->getCategoryId() ==  $categoryId) { 
        $res[] = $book;
      }
    }
    return $res;
  }

  /**
   * get the books per search term
   * 
   * note: stripos() – returns index (also 0!) on success and -1 on error
   * 0 == false but 0 === true -> thus test for !== false
   * 
   * "This function may return Boolean FALSE, but may also return a
   * non-Boolean value which evaluates to FALSE. Please read the section
   * on Booleans for more information. Use the === operator for testing
   * the return value of this function." -- http://php.net/manual/en/function.stripos.php
   *
   * @param string $term  search term: book title string match
   * @return array of Book-items
   */
  public static function getBooksForSearchCriteria(string $term) : array {
   
    $res = [];
    foreach (self::getMockData('books') as $book) {
      $termOk = (
              $term == '' || stripos($book->getTitle(), $term) !== false
              );
      if ($termOk) {
        $res[] = $book;
      }
    }
    return $res;
  }

  /**
   * get the books per search term – paginated set only
   *
   * @param string $term  search term: book title string match
   * @param integer $offset  start at the nth item
   * @param integer $numPerPage  number of items per page
   * @return PagingResult
   */
  public static function getBooksForSearchCriteriaWithPaging(string $term, int $offset, int $numPerPage) : PagingResult {
    $res = self::getBooksForSearchCriteria($term);
    return new PagingResult(array_slice($res, $offset, $numPerPage), $offset, sizeof($res));
  }

  /**
   * get the User item by id
   *
   * @param integer $userId  uid of that user
   * @return User | null
   */
  public static function getUserById(int $userId) : ?User {
    return array_key_exists($userId, self::getMockData('users')) ? self::getMockData('users')[$userId] : null;
  }

  /**
   * get the User item by name
   * 
   * note: show for case sensitive and insensitive options
   * 
   * @param string $userName  name of that user - must be exact match
   * @return User | null
   */
  public static function getUserByUserName(string $userName) : ?User { 
    foreach (self::getMockData('users') as $user) {

      if ($user->getUserName() === $userName) {
        return $user;
      }
    }
    return null;
  }

  /**
   * place to order with the shopping cart items
   * 
   * note: nothing to do here without the database
   * random order id can be used to demonstrate that POST is only executed once
   *
   * @param integer $userId   id of the ordering user
   * @param array $bookIds    integers of book ids
   * @param string $nameOnCard  cc name
   * @param string $cardNumber  cc number
   * @return integer
   */
  public static function createOrder(int $userId, array $bookIds, string $nameOnCard, string $cardNumber) : int {
    return rand();
  }

}
