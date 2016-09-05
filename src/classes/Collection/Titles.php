<?php

namespace ReadingLists\Collection;

use ReadingLists\Model\IModel;
use ReadingLists\Model\Title;

/**
 * A collection of Title objects
 *
 *
 * @package ReadingLists
 * @subpackage Collection
 */
class Titles extends Collection {
    /**
     * Implementation of the isValidRecord function. Will only add
     * \ReadingLists\Model\Title implementations of IModel
     *
     * @param \ReadingLists\Model\IModel The IModel to add
     */
    protected function isValidRecord(IModel $model) { return $model instanceof Title; }

}

