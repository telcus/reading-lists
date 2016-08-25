<?php

namespace ReadingLists\Collection;

/**
 * The base implementation of a collection that all collections are based off
 *
 * Allows for the collection to represent that it may have contraints on it
 * by including a Constraints object 
 *
 * @package ReadingLists
 * @subpackage Collection
 */
abstract class Collection {
    /** @var \ReadingLists\Collection\Constraints|null The representation of any constraints on the collection */
    protected $constraints = null;
    /** @var int The total number of records without constraints */
    protected $total_records = null;

    /**
     * Adds constraint data to the collection
     *
     * @param \ReadingLists\Collection\Constraints|null $constraints The Constraints (if any) represented by the collection
     *
     */
    public function addConstraints(Constraints $constraints = null) {
        $this->constraints = $constraints;
    }

    /**
     * Whether the collection is paginated
     *
     * @return bool
     */
    public function isPaginated() {
        return $this->constraints && $this->constraints->isPaginated();
    }

    /**
     * Returns the current page (if any) of the collection
     *
     * @return int|null
     */
    public function getPage() {
        return $this->isPaginated() ? $this->constraints->getPage() : null;
    }

    /**
     * Returns the total number of records without constraints
     *
     * If the total number of records has not been manually set, this should
     * return the number of records in the collection
     *
     * @return int
     */
    public abstract function getTotalRecords();

    /**
     * Sets the total number of records without contstraints
     *
     * @param int|null $total_records The total number of records without contraints
     *
     */
    public function setTotalRecords($total_records = null) { $this->total_records = $total_records; }

    /**
     * Gets the total number of pages (if any) that the collection spans over
     *
     * @return int|null
     */
    public function getTotalPages() {
        return $this->isPaginated() ? $this->constraints->getRecordPage($this->getTotalRecords()) : null;
    }

}

