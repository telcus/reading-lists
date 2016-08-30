<?php

namespace ReadingLists\Repository\InMemory;

/**
 * InMemory Repository for Titles
 *
 * @package ReadingLists
 * @subpackage Repository\InMemory
 */
class Title implements \ReadingLists\Repository\ITitle {
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
     * Takes an entry from the store and loads it as a title
     *
     * @param array $data The data representation of the title
     *
     * @return \ReadingLists\Model\Title
     */
    protected function unloadTitle($data) {
        $start_year = null;
        $end_year = null;
        $issue_count = count($data['issues']);

        foreach ($data['issues'] as $issue) {
            $start_year = $start_year == null || $issue['publish_year'] < $start_year ? $issue['publish_year'] : $start_year;
            $end_year = $end_year == null || $issue['publish_year'] > $end_year ? $issue['publish_year'] : $end_year;
        }

        return new \ReadingLists\Model\Title(new \ReadingLists\Type\Id($data['id']), $data['name'], $start_year, $end_year, $issue_count);
    }

    /**
     * Takes a title and converts into an array for storage
     *
     * @param \ReadingLists\Model\Title $title The Title to store
     *
     * @return array
     */
    protected function loadTitle(\ReadingLists\Model\Title $title) {
        return [
            'id'    => $title->getTitleId()->getId(),
            'name'  => $title->getName(),
        ];
    }

    /**
     * The titles that are in the repository
     *
     * @param \ReadingLists\Collection\Constraints|null $constraints Any constraints to apply to the collection
     *
     * @return \ReadingLists\Collection\Titles
     */
    public function lookupTitles(\ReadingLists\Collection\Constraints $constraints = null) {
        $titles = new \ReadingLists\Collection\Titles([], $constraints);

        $page_offset = 0;
        if ($this->store->has('titles')) {
            foreach ($this->store->get('titles') as $title) {
                if (!$constraints || !$constraints->isPaginated() || ($titles->count() < $constraints->getPageSize() && $page_offset >= $constraints->getPageOffset())) {
                    $titles->addTitle($this->unloadTitle($title));
                }
                $page_offset++;
            }
        }
        $titles->setTotalRecords(count($this->store->get('titles')));

        return $titles;
    }

    /**
     * The number of titles in the repository
     */
    public function countTitles() {
        return $this->lookupTitles()->count();
    }

    /**
     * The title with the specific title id or null when no title found
     *
     * @param \ReadingLists\Type\Id $title_id The title id of the title to find
     *
     * @return \ReadingLists\Model\Title|null
     */
    public function findByTitleId(\ReadingLists\Type\Id $title_id) {
        if ($this->store->has('titles')) {
            foreach ($this->store->get('titles') as $title) {
                if ($title['id'] == $title_id->getId()) {
                    return $this->unloadTitle($title);
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
                if ($title['id'] >= $id) {
                    $id = $title['id'] + 1;
                }
            }
        }

        return new \ReadingLists\Type\Id($id);
    }

    /**
     * Store a Title in the repository
     *
     * @param \ReadingLists\Model\Title $title The title to store
     *
     * @return \ReadingLists\Model\Title
     */
    public function storeTitle(\ReadingLists\Model\Title $title) {
        $data = $this->loadTitle($title);

        if ($data['id'] == 0) {
            $data['id'] = $this->getNextId()->getId();
        }

        $titles = []; 
        $has_title = false;

        if ($this->store->has('titles')) {
            foreach ($this->store->get('titles') as $existing_data) {
                if ($existing_data['id'] == $data['id']) {
                    $has_title = true;
                    $data['issues'] = $existing_data['issues'];
                    $titles[] = $data;
                } else {
                    $titles[] = $existing_data;
                }
            }
        }

        if (!$has_title) {
            $data['issues'] = array();
            $titles[] = $data;
        }

        $this->store->set('titles', $titles);

        return $this->unloadTitle($data);
    }

    /**
     * Removes a Title in the repository
     *
     * @param \ReadingLists\Model\Title $title The title to remove
     *
     * @return \ReadingLists\Model\Title|null
     */
    public function removeTitle(\ReadingLists\Model\Title $title) {
        $titles = [];
        $has_title = false;

        if ($this->store->has('titles')) {
            foreach ($this->store->get('titles') as $existing_data) {
                if ($existing_data['id'] == $title->getTitleId()->getId()) {
                    $has_title = true;
                } else {
                    $titles[] = $existing_data;
                }

            }
        }

        $this->store->set('titles', $titles);

        return $has_title ? $title : null;
    }

}

