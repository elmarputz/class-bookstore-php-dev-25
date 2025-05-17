<?php
namespace Bookshop;
/**
 * Book
 * 
 * 
 * @extends Entity
 * @package    
 * @subpackage 
 * @author     John Doe <jd@fbi.gov>
 */
class Book extends Entity {

  private int $categoryId;
  private string $title;
  private string $author;
  private float $price;



  public function __construct(int $id, int $categoryId, string $title, string $author, float $price)  {
    parent::__construct($id);
    $this->categoryId = intval($categoryId); // eigentlich obsolet
    $this->title = $title;
    $this->author = $author;
    $this->price = floatval($price); // eigentlich obsolet
  }

  /**
   * getter for the private parameter $categoryId
   */
  public function getCategoryId() : int {
    return $this->categoryId;
  }

  /**
   * getter for the private parameter $title
   */
  public function getTitle() : string {
    return $this->title;
  }

  /**
   * getter for the private parameter $author
   */
  public function getAuthor() :  string {
    return $this->author;
  }

  /**
   * getter for the private parameter $price
   */
  public function getPrice() : float {
    return $this->price;
  }
}