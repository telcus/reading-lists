<?php

namespace ReadingLists\Repository\InMemory;

/**
 * Base Class for InMemory Repositories
 *
 * @package ReadingLists
 * @subpackage Repository\InMemory
 */
abstract class InMemory {
    /** @var \ReadingLists\Connection\InMemory The store for this repository */
    protected $store;

    /*
     * Creates a new InMemory Title Repository
     *
     * @param \ReadingLists\Connection\InMemory $store The store for this repository
     */
    public function __construct(\ReadingLists\Connection\InMemory $store) {
        $this->store = $store;
    }

    /**
     * Gets the next available id to be used as a title reference
     *
     * @return \ReadingLists\Type\Id
     */
    public abstract function getNextId();

}

