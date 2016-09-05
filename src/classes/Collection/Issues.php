<?php

namespace ReadingLists\Collection;

use ReadingLists\Model\IModel;
use ReadingLists\Model\Issue;

/**
 * A collection of Issue objects
 *
 *
 * @package ReadingLists
 * @subpackage Collection
 */
class Issues extends Collection {
    /**
     * Implementation of the isValidRecord function. Will only add \ReadingLists\Model\Issue
     * implementations of IModel
     *
     * @param \ReadingLists\Model\IModel The IModel to add
     */
    protected function isValidRecord(IModel $model) { return $model instanceof Issue; }

}

