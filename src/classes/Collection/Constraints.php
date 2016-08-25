<?php

namespace ReadingLists\Collection;

/**
 * Information about any constraints that have been applied to this collection
 *
 * This allows the collection to express that it is part of a larger collection
 * or that is has been sorted in a certain way
 *
 * @package ReadingLists
 * @subpackage Collection
 */
class Constraints {
    /** @var int|null $page The current page of the total set this collection represents */
    protected $page = null;
    /** @var int $page_size The size of the pagination */
    protected $page_size = 20;

    /**
     * Creates a new constraint
     *
     * @param int|null $page The current page of the total set, null when no paging
     * @param int $page_size The size of the page
     *
     */
    public function __construct($page = null, $page_size = 20) {
        $this->page = $page;
        $this->page_size = $page_size;
    }

    /**
     * Whether or not the constraint is paginated
     *
     * @return bool
     */
    public function isPaginated() { return $this->page !== null; }

    /**
     * The current page of the total collection
     *
     * @return int|null
     */
    public function getPage() { return $this->page; }

    /**
     * The page that a specific record would be placed in
     *
     * @param $record_number The count to calculate the page for
     *
     * @return int The page that record would sit in
     */
    public function getRecordPage($record_number) {
        return $this->page_size > 0 ? ceil($record_number / $this->page_size) : 1;
    }

    /**
     * The size of the page
     *
     * @return int
     */
    public function getPageSize() { return $this->page_size; }

    /**
     * How many records to skip to get to the first record in the set
     *
     * @return int
     */
    public function getPageOffset() { return ($this->page - 1) * $this->page_size; }

}

