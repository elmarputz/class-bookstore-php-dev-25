<?php

namespace Bookshop;

interface IData { // IDataManager ist ein besseres interface-beispiel
  public function getId() : int;
}

/**
 * Entity
 * 
 */

class Entity implements IData {

  private int $id;

  public function __construct(int $id) {
    $this->id = intval($id); 
  }

  /**
   * getter for the private parameter $id
   *
   * @return int
   */
  public function getId() : int {
    return $this->id;
  }

}