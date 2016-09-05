<?php

namespace ReadingLists\Model;

/**
 * An issue is the representation of a physical book, containing one or more stories
 *
 * @package ReadingLists
 * @subpackage Model
 */

class Issue implements IModel {
    /** @var \ReadingLists\Type\Id The Id of the Issue, the Title Id and Issue title reference */
    protected $issue_id;
    /** @var string How the issue is referenced to the title. Usually in the form of a number */
    protected $title_reference;
    /** @var \ReadingLists\Type\Id The Id of the Title that this issue ran in */
    protected $title_id;
    /** @var string The name of the issue as printed on the cover */
    protected $cover_name;
    /** @var int The year of the issue as printed on the cover (or implied by the cover month and first published year */
    protected $cover_year;
    /** @var int The month of the issue as printed on the cover */
    protected $cover_month;
    /** @var float The price of the issue as printed on the cover */
    protected $cover_price;

    /**
     * Creates a new instance of an Issue
     *
     * @param \ReadingLists\Type\Id $issue_id The Id of the Issue
     * @param \ReadingLists\Type\Id $title_id The Id of the Title of the issue
     * @param string $title_reference How the issue is referenced to the title
     * @param string $cover_name The name of the issue as printed on the cover
     * @param int $cover_year The year of the issue as printed or implied on the cover
     * @param int $cover_month The month of the issues as printed on the cover
     * @param float $cover_price The price of the issue as printed on the cover
     */
    public function __construct(\ReadingLists\Type\Id $issue_id, \ReadingLists\Type\Id $title_id, $title_reference, $cover_name, $cover_year, $cover_month, $cover_price) {
        $this->setIssueId($issue_id);
        $this->setTitleId($title_id);
        $this->setTitleReference($title_reference);
        $this->setCoverName($cover_name);
        $this->setCoverYear($cover_year);
        $this->setCoverMonth($cover_month);
        $this->setCoverPrice($cover_price);
    }

    /**
     * The Id of the Title
     *
     * @return \ReadingLists\Type\Id
     */
    public function getIssueId() { return $this->issue_id; }

    /**
     * The Id of the Title this issue belongs to
     *
     * @return \ReadingLists\Type\Id
     */
    public function getTitleId() { return $this->title_id; }

    /**
     * How the issue is referenced to the title
     *
     * @return string
     */
    public function getTitleReference() { return $this->title_reference; }

    /**
     * The name of the issue as printed on the cover
     *
     * @return string
     */
    public function getCoverName() { return $this->cover_name; }

    /**
     * The year of the issue as printed or implied on the cover
     *
     * @return int
     */
    public function getCoverYear() { return $this->cover_year; }

    /**
     * The month of the issue as printed on the cover
     *
     * @return int
     */
    public function getCoverMonth() { return $this->cover_month; }

    /**
     * The price of the issue as printed on the cover
     *
     * @return float
     */
    public function getCoverPrice() { return $this->cover_price; }

    /**
     * Sets the issue id
     *
     * @param \ReadingLists\Type\id $issue_id The new issue id
     *
     */
    protected function setIssueId(\ReadingLists\Type\Id $issue_id) { $this->issue_id = $issue_id; }

    /**
     * Sets the issue id
     *
     * @param \ReadingLists\Type\id $title_id The new title id
     *
     */
    public function setTitleId(\ReadingLists\Type\Id $title_id) { $this->title_id = $title_id; }

    /**
     * Sets the title reference
     *
     * @param string $title_reference The new title reference
     */
    public function setTitleReference($title_reference) { $this->title_reference = $title_reference; }

    /**
     * Sets the cover name
     *
     * @param string $cover_name The new cover name
     */
    public function setCoverName($cover_name) { $this->cover_name = $cover_name; }

    /**
     * Sets the year of the issue as printed or implied on the cover
     *
     * @param int The new cover year
     */
    public function setCoverYear($cover_year) { $this->cover_year = $cover_year; }

    /**
     * Sets the month of the issue as printed on the cover
     *
     * @param int The new cover month
     */
    public function setCoverMonth($cover_month) { $this->cover_month = $cover_month; }

    /**
     * Sets the price of the issue as printed on the cover
     *
     * @param float The new cover price
     */
    public function setCoverPrice($cover_price) { $this->cover_price = $cover_price; }

}

