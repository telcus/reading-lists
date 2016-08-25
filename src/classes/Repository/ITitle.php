<?php

namespace ReadingLists\Repository;

/**
 * A repository for retrieving and storing Titles
 *
 * This interface defines the common functions that all Title
 * repositories must implement
 *
 * @package ReadingLists
 * @subpackage Repository
 */
interface ITitle {
    /**
     * The titles that are in the repository
     *
     * @param \ReadingLists\Collection\Constraints|null $constraints Any constraints to apply to the collection
     * @return \ReadingLists\Collection\Titles
     */
    public function lookupTitles(\ReadingLists\Collection\Constraints $constraints = null);

    /**
     * The title with the specific title id or null when no title found
     *
     * @param \ReadingLists\Type\Id $title_id The title reference of the title to find
     *
     * @return \ReadingLists\Model\Title|null
     */
    public function findByTitleId(\ReadingLists\Type\Id $title_id);

    /**
     * Store a Title in the repository
     *
     * @param \ReadingLists\Model\Title $title The title to store
     *
     * @return \ReadingLists\Model\Title
     */
    public function storeTitle(\ReadingLists\Model\Title $title);

    /**
     * Removes a Title in the repository
     *
     * @param \ReadingLists\Model\Title $title The title to remove
     *
     * @return \ReadingLists\Model\Title
     */
    public function removeTitle(\ReadingLists\Model\Title $title);

}

