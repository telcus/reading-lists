<?php

namespace ReadingLists\Collection;

use ReadingLists\Model\IModel;

/**
 * The base implementation of a collection that all collections are based off
 *
 * Allows for the collection to represent that it may have contraints on it
 * by including a Constraints object. Implements both the Countable and
 * SeekableIterator builtin interfaces to allow for counting and traversing
 *
 * @package ReadingLists
 * @subpackage Collection
 */
abstract class Collection implements \Countable, \SeekableIterator {
    /** @var \ReadingLists\Model\IModel[] Internal storage of the records */
    protected $records = array();
    /** @var int The pointer to the current position of the iterator */
    protected $position = 0;
    /** @var int The total number of records without constraints */
    protected $total_records = null;
    /** @var \ReadingLists\Collection\Constraints|null The representation of any constraints on the collection */
    protected $constraints = null;

    /**
     * Create a new collection potentially preloaded with an array of models
     *
     * @param \ReadingLists\Model\IModel|ReadingLists\Model\IModel[]|null $records The preloaded list of records either as an array or a single IModel
     * @param \ReadingLists\Collection\Constraints|null $constraints Any constraints that apply to this collection
     */
    public function __construct($records = null, Constraints $constraints = null) {
        if (is_array($records)) {
            foreach ($records as $record) {
                $this->addRecord($record);
            }
        } elseif ($record !== null) {
            $this->addRecord($record);
        }

        $this->addConstraints($constraints);
    }

    /**
     * Adds a record to the collection, returning its position
     *
     * @param \ReadingLists\Model\IModel The IModel to add
     *
     * @return int
     */
    public function addRecord(IModel $model) {
        if ($this->isValidRecord($model)) {
            $this->records[] = $model;
        }

        return $this->count() - 1;
    }

    /**
     * Whether this model is allowed to be added to the collection
     *
     * @param \ReadingLists\Model\IModel The IModel to check
     *
     * @return bool
     */
    protected abstract function isValidRecord(IModel $model);

    /**
     * Removes a record at the current position from the collection
     */
    public function removeRecord() {
        if ($this->isValid()) {
            unset($this->records[$this->key()]);
        }
    }

    /**
     *
     * Adds constraint data to the collection
     *
     * @param \ReadingLists\Collection\Constraints|null $constraints The Constraints (if any) represented by the collection
     *
     */
    public function addConstraints(Constraints $constraints = null) {
        $this->constraints = $constraints;
    }

    /**
     * The number of issue in the collection
     *
     * @return int
     */
    public function count() {
        return count($this->records);
    }

    /**
     * Moves the current position to the desired position
     *
     * @param int The desired position
     *
     * @throws \OutOfBoundsException
     */
    public function seek($position) {
        if (!isset($this->records[$position])) {
            throw new \OutOfBoundsException("Invalid Position");
        }

        $this->position = $position;
    }

    /**
     * Rewinds the position to the start
     */
    public function rewind() {
        $this->position = 0;
    }

    /**
     * Gets the IModel at the current position
     *
     * @return \ReadingLists\Model\IModel
     */
    public function current() {
        return $this->records[$this->position];
    }

    /**
     * Gets the current position
     *
     * @return int
     */
    public function key() {
        return $this->position;
    }

    /**
     * Advances the current position
     */
    public function next() {
        ++$this->position;
    }

    /**
     * Whether the current position is a valid section of the collection
     *
     * @return boolean
     */
    public function valid() {
        return isset($this->records[$this->position]);
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
    public function getTotalRecords() {
        return $this->total_records !== null ? $this->total_records : $this->count();
    }

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

