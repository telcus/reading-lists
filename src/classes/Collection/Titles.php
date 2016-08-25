<?php

namespace ReadingLists\Collection;

use ReadingLists\Model\Title;

/**
 * A collection of Title objects
 *
 * Implements both the Countable and SeekableIterator builtin
 * interfaces to allow for counting and traversing
 *
 * @package ReadingLists
 * @subpackage Collection
 */
class Titles extends Collection implements \Countable, \SeekableIterator {
    /** @var array Internal storage of the Title objects */
    protected $titles = array();
    /** @var int The pointer to the current position of the iterator */
    protected $position = 0;

    /**
     * Create a new collection potentially preloaded with an array of Titles
     *
     * @param mixed $titles The preloaded list of Titles either as an array of a single Title
     * @param \ReadingLists\Collection\Constraints|null $constraints Any constraints that apply to this collection
     */
    public function __construct($titles = null, Constraints $constraints = null) {
        if (is_array($titles)) {
            foreach ($titles as $title) {
                $this->addTitle($title);
            }
        } elseif ($titles !== null) {
            $this->addTitle($titles);
        }

        $this->addConstraints($constraints);
    }

    /**
     * The number of titles in the collection
     *
     * @return int
     */
    public function count() {
        return count($this->titles);
    }

    /**
     * Moves the current position to the desired position
     *
     * @param int The desired position
     *
     * @throws \OutOfBoundsException
     */
    public function seek($position) {
        if (!isset($this->titles[$position])) {
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
     * Gets the title at the current position
     *
     * @return \ReadingLists\Model\Title
     */
    public function current() {
        return $this->titles[$this->position];
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
        return isset($this->titles[$this->position]);
    }

    /**
     * Adds a new title to the collection
     *
     * @param \ReadingLists\Model\Title the Title to add to the collection
     *
     * @return int The position of the title in the collection
     */
    public function addTitle(Title $title) {
        $this->titles[] = $title;

        return count($this->titles) - 1;
    }

    /**
     * Removes the title at the current position from the collection
     */
    public function removeTitle() {
        if ($this->isValid()) {
            unset($this->titles[$this->key()]);
        }
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

}

