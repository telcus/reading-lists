<?php

namespace ReadingLists\Repository;

/**
 * A repository for retrieving and storing Issues
 *
 * This interface defines the common functions that all Issue
 * repositories must implement
 *
 * @package ReadingLists
 * @subpackage Repository
 */
interface IIssue {
    /**
     * The issues that are in the repository
     *
     * @param \ReadingLists\Collection\Constraints|null $constraints Any constraints to apply to the collection
     * @return \ReadingLists\Collection\Issues
     */
    public function lookupIssues(\ReadingLists\Collection\Constraints $constraints = null);

    /**
     * The issues that are in the repository that are from a specific title
     *
     * @param \ReadingLists\Type\Id $title_id The Id of the title to lookup
     * @param \ReadingLists\Collection\Constraints|null $constraints Any constraints to apply to the collection
     * @return \ReadingLists\Collection\Issues
     */
    public function lookupIssuesByTitleId(\ReadingLists\Type\Id $id, \ReadingLists\Collection\Constraints $constraints = null);

    /**
     * The number of issues that are in the repository
     *
     * @return int
     */
    public function countIssues();

    /**
     * The title with the specific issue id or null when no title found
     *
     * @param \ReadingLists\Type\Id $issue_id The Id of the Issue to find
     *
     * @return \ReadingLists\Model\Issue|null
     */
    public function findByIssueId(\ReadingLists\Type\Id $issue_id);

    /**
     * Store an Issue in the repository
     *
     * @param \ReadingLists\Model\Issue $issue The issue to store
     *
     * @return \ReadingLists\Model\Issue
     */
    public function storeIssue(\ReadingLists\Model\Issue $issue);

    /**
     * Removes an Issue from the repository
     *
     * @param \ReadingLists\Model\Issue $issue The Issue to remove
     *
     * @return \ReadingLists\Model\Issue|null
     */
    public function removeIssue(\ReadingLists\Model\Issue $issue);

}

