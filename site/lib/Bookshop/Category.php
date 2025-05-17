<?php
namespace Bookshop;
/**
 * Category
 * 
 * 
 * @extends Entity
 * @package    
 * @subpackage 
 * @author     John Doe <jd@fbi.gov>
 */
class Category extends Entity {

  private string $name;

  /**
   * getter for the private parameter $name
   *
   */
  public function getName() : string {
    return $this->name;
  }

  public function __construct(int $id, string $name) {
    parent::__construct($id);
    $this->name = $name;
  }

  /* ab php 8 möglich
	public function __construct(private int $id, private string $name) {
    // …
	}
	*/

}