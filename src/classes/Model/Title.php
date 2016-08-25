<?php

namespace ReadingLists\Model;

/**
 * A Title is a run of Issues that are referred to with a common name
 *
 * @package ReadingLists
 * @subpackage Model
 */
class Title {
    /** @var \ReadingLists\Type\Id The id of the title */
    protected $title_id;
    /** @var string The name of the title */
    protected $name;
    /** @var int|null The first year an issue was published for this title */
    protected $start_year;
    /** @var int|null The last year an issue was published for this title */
    protected $end_year;
    /** @var int The number of issues in the title */
    protected $issue_count = 0;

    /**
     * Creates a new Title
     *
     * @param \ReadingLists\Type\Id $title_id
     * @param string $name
     * @param int|null $start_year
     * @param int|null $end_year
     * @param int $issue_count
     *
     */
    public function __construct(\ReadingLists\Type\Id $title_id, $name, $start_year = null, $end_year = null, $issue_count = 0) {
        $this->setTitleId($title_id);
        $this->setName($name);
        $this->setStartYear($start_year);
        $this->setEndYear($end_year);
        $this->setIssueCount($issue_count);
    }

    /**
     * The id of the title
     * 
     * @return \ReadingLists\Type\Id
     */
    public function getTitleId() { return $this->title_id; }

    /**
     * The name of the title
     *
     * @return string
     */
    public function getName() { return $this->name; }

    /**
     * The start year of the title
     *
     * @return int
     */
    public function getStartYear() { return $this->start_year; }

    /**
     * The end year of the title
     *
     * @return int
     */
    public function getEndYear() { return $this->end_year; }

    /**
     * The number of issues in the title
     *
     * @return int
     */
    public function getIssueCount() { return $this->issue_count; }

    /**
     * Sets the reference number
     *
     * @param \ReadingLists\Type\Id $title_id The new title reference
     *
     */
    protected function setTitleId(\ReadingLists\Type\Id $title_id) { $this->title_id = $title_id; }

    /**
     * Sets the name of the title
     *
     * @param string $name The new name
     *
     */
    public function setName($name) { $this->name = $name; }

    /**
     * Sets the first published year of the title
     *
     * @param int|null $start_year The new start year
     *
     */
    protected function setStartYear($start_year = null) { $this->start_year = $start_year; }

    /**
     * Sets the last published year of the title
     *
     * @param int|null $end_year The new end year
     *
     */
    protected function setEndYear($end_year = null) { $this->end_year = $end_year; }

    /**
     * Sets the number of issues in the title
     *
     * @param int $issue_count The new issue count
     *
     */
    protected function setIssueCount($issue_count) { $this->issue_count = $issue_count; }

    /**
     * Adds a new issue to the title run
     *
     * @param int $published_year The year the new issue was published
     *
     */
    public function addIssue($published_year) {
        $this->setIssueCount($this->getIssueCount() + 1);

        if ($this->getStartYear() == null || $published_year < $this->getStartYear()) {
            $this->setStartYear($published_year);
        }

        if ($this->getEndYear() == null || $published_year > $this->getEndYear()) {
            $this->setEndYear($published_year);
        }
    }

}

