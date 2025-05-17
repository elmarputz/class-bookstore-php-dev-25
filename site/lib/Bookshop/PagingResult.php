<?php

namespace Bookshop;

/**
 * PagingResult
 *
 */
class PagingResult  {

	
	/**
	 * php 8 
	 * Constructor property promotion 
	 */
	public function __construct(

		private array $result,
		private int $offset,
		private int $totalCount,

	) {}

	/**
	 * getter for result
	 */
	public function getResult() : array {
		return $this->result;
	}

	/**
	 * getter for offset
	 */
	public function getOffset() : int {
		return $this->offset;
	}

	/**
	 * getter for total count
	 */
	public function getTotalCount() : int {
		return $this->totalCount;
	}

	/**
	 * getter for first page position
	 *
	 */
	public function getPositionOfFirst() : int {
		return $this->getOffset() + 1;
	}

	/**
	 * getter for last page position
	 *
	 */
	public function getPositionOfLast()  : int {
		return $this->getOffset() + sizeof($this->result);
	}

}