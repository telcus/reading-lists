<?php

namespace ReadingLists\Repository\InMemory;

/**
 * An In Memory implementation of a repository for retrieving and storing Issues
 *
 * @package ReadingLists
 * @subpackage Repository\InMemory
 */
class Issue extends InMemory implements \ReadingLists\Repository\IIssue {
    /**
     * Takes an entry from the store and loads it as an Issue
     *
     * @param array $data The data representation of the Issue
     * @param int $title_id The id of the title attached to the Issue
     *
     * @return \ReadingLists\Model\Issue
     */
    protected function unloadIssue($data, $title_id) {
        return new \ReadingLists\Model\Issue(
            new \ReadingLists\Type\Id($data['id']),
            new \ReadingLists\Type\Id($title_id),
            $data['reference'],
            $data['name'],
            $data['year'],
            $data['month'],
            $data['price']);
    }

    /**
     * Takes an issue and converts into an array for storage
     *
     * @param \ReadingLists\Model\Issue $issue The Issue to store
     *
     * @return array
     */
    protected function loadIssue(\ReadingLists\Model\Issue $issue) {
        return [
            'id'        => $issue->getIssueId()->getId(),
            'reference' => $issue->getTitleReference(),
            'name'      => $issue->getCoverName(),
            'year'      => $issue->getCoverYear(),
            'month'     => $issue->getCoverMonth(),
            'price'     => $issue->getCoverPrice(),
        ];
    }

    /**
     * The issues that are in the repository
     *
     * @param \ReadingLists\Collection\Constraints|null $constraints Any constraints to apply to the collection
     * @return \ReadingLists\Collection\Issues
     */
    public function lookupIssues(\ReadingLists\Collection\Constraints $constraints = null) {
        $issues = new \ReadingLists\Collection\Issues([], $constraints);

        $page_offset = 0;
        if ($this->store->has('titles')) {
            foreach ($this->store->get('titles') as $title) {
                foreach ($title['issues'] as $issue) {
                    if (!$constraints || !$constraints->isPaginated() || ($issues->count() < $constraints->getPageSize() && $page_offset >= $constraints->getPageOffset())) {
                        $issues->addRecord($this->unloadIssue($issue, $title['id']));
                    }
                    $page_offset++;
                }
            }
        }
        $issues->setTotalRecords($page_offset);

        return $issues;
    }

    /**
     * The issues that are in the repository that are from a specific title
     *
     * @param \ReadingLists\Type\Id $title_id The Id of the title to lookup
     * @param \ReadingLists\Collection\Constraints|null $constraints Any constraints to apply to the collection
     * @return \ReadingLists\Collection\Issues
     */
    public function lookupIssuesByTitleId(\ReadingLists\Type\Id $id, \ReadingLists\Collection\Constraints $constraints = null) {
        $issues = new \ReadingLists\Collection\Issues([], $constraints);

        $page_offset = 0;
        if ($this->store->has('titles')) {
            foreach ($this->store->get('titles') as $title) {
                if ($title['id'] == $id->getId()) {
                    foreach ($title['issues'] as $issue) {
                        if (!$constraints || !$constraints->isPaginated() || ($issues->count() < $constraints->getPageSize() && $page_offset >= $constraints->getPageOffset())) {
                            $issues->addRecord($this->unloadIssue($issue, $title['id']));
                        }
                        $page_offset++;
                    }
                }
            }
        }
        $issues->setTotalRecords($page_offset);

        return $issues;
    }

    /**
     * The number of issues that are in the repository
     *
     * @return int
     */
    public function countIssues() {
        return $this->lookupIssues()->count();
    }

    /**
     * The title with the specific issue id or null when no title found
     *
     * @param \ReadingLists\Type\Id $issue_id The Id of the Issue to find
     *
     * @return \ReadingLists\Model\Issue|null
     */
    public function findByIssueId(\ReadingLists\Type\Id $issue_id) {
        if ($this->store->has('titles')) {
            foreach ($this->store->get('titles') as $title) {
                foreach ($title['issues'] as $issue) {
                    if ($issue['id'] == $issue_id->getId()) {
                        return $this->unloadIssue($issue, $title['id']);
                    }
                }
            }
        }
    }

    /**
     * Gets the next available id to be used as a title reference
     *
     * @return \ReadingLists\Type\Id
     */
    public function getNextId() {
        $id = 1;
        if ($this->store->has('titles')) {
            foreach ($this->store->get('titles') as $title) {
                foreach ($title['issues'] as $issue) {
                    if ($title['id'] >= $id) {
                        $id = $title['id'] + 1;
                    }
                }
            }
        }

        return new \ReadingLists\Type\Id($id);
    }

    /**
     * Store an Issue in the repository
     *
     * @param \ReadingLists\Model\Issue $issue The issue to store
     *
     * @return \ReadingLists\Model\Issue
     */
    public function storeIssue(\ReadingLists\Model\Issue $issue) {
        $data = $this->loadIssue($issue);

        if ($data['id'] == 0) {
            $data['id'] = $this->getNextId()->getId();
        }

        $titles = [];

        if ($this->store->has('titles')) {
            foreach ($this->store->get('titles') as $title) {
                $issues = [];
                foreach ($title['issues'] as $existing_data) {
                    if ($existing_data['id'] != $data['id']) {
                        $issues[] = $existing_data;
                    }
                }

                if ($issue->getTitleId()->getId() == $title['id']) {
                    $issues[] = $data;
                }

                $title['issues'] = $issues;
                $titles[] = $title;
            }
        }

        $this->store->set('titles', $titles);

        return $this->unloadIssue($data);
    }

    /**
     * Removes an Issue from the repository
     *
     * @param \ReadingLists\Model\Issue $issue The Issue to remove
     *
     * @return \ReadingLists\Model\Issue|null
     */
    public function removeIssue(\ReadingLists\Model\Issue $issue) {
        $titles = [];
        $has_issue = false;

        if ($this->store->has('titles')) {
            foreach ($this->store->get('titles') as $title) {
                $issues = [];
                foreach ($title['issues'] as $existing_data) {
                    if ($existing_data['id'] == $issue->getIssueId()->getId()) {
                        $has_issue = true;
                    } else {
                        $issues[] = $existing_data;
                    }
                }

                $title['issues'] = $issues;
                $titles[] = $title;
            }
        }

        $this->store->set('titles', $titles);

        return $has_issue ? $title : null;
    }

}

