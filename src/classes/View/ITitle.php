<?php

namespace ReadingLists\View;

/**
 * Interface for displaying information about Titles
 *
 * @package ReadingLists
 * @subpackage View
 */
interface ITitle {
    /*
     * Shows a list of titles
     *
     * @param \ReadingLists\Collection\Titles $titles The titles to show
     */
    public function listTitles(\ReadingLists\Collection\Titles $titles);

    /*
     * Shows the details of a title
     *
     * @param \ReadingLists\Model\Title|null $title The title to show
     */
    public function viewTitle(\ReadingLists\Model\Title $title = null);

    /*
     * Creates a new title
     *
     * @param \ReadingLists\Model\Title $title The created title
     */
    public function createTitle(\ReadingLists\Model\Title $title);

    /*
     * Edits a title
     *
     * @param \ReadingLists\Model\Title|null $title The edited title
     */
    public function editTitle(\ReadingLists\Model\Title $title = null);

    /*
     * Removes a title
     *
     * @param \ReadingLists\Model\Title|null $title The removed title
     */
    public function removeTitle(\ReadingLists\Model\Title $title = null);

}

