<?php

namespace ReadingLists\View\JSON;

/**
 * JSON implementation of the Title view
 *
 * @package ReadingLists
 * @subpackage View\JSON
 */
class Title implements \ReadingLists\View\ITitle {
    /**
     * Gets a title as data array
     *
     * @param \ReadingLists\Model\Title $title The title to convert
     *
     * @return string[]
     */
    public function titleAsData(\ReadingLists\Model\Title $title) {
        return [
            'type'          => 'title',
            'id'            => $title->getTitleId()->getId(),
            'name'          => $title->getName(),
            'start_year'    => $title->getStartYear(),
            'end_year'      => $title->getEndYear(),
            'issue_count'   => $title->getIssueCount(),
        ];
    }

    /*
     * Shows a list of titles
     *
     * @param \ReadingLists\Collection\Titles $titles The titles to show
     */
    public function listTitles(\ReadingLists\Collection\Titles $titles) {
        $data = array();

        if ($titles->isPaginated()) {
            $data['meta']['current_page'] = $titles->getPage();
            $data['meta']['total_pages'] = $titles->getTotalPages();
            $data['meta']['count'] = $titles->getTotalRecords();
        }

        foreach ($titles as $title) {
            $data['data'][] = $this->titleAsData($title);
        }

        echo json_encode($data);
    }

    /*
     * Shows the details of a title
     *
     * @param \ReadingLists\Model\Title|null $title The title to show
     */
    public function viewTitle(\ReadingLists\Model\Title $title = null) {
        $data = array();
        if ($title) {
            $data = [
                'data' => $this->titleAsData($title), 
            ];
        } else {
            $data['errors'][] = [
                "title"     => "Title not found",
                "detail"    => "Could not find the requested Title.",
            ];
        }

        echo json_encode($data);
    }

    /*
     * Creates a new title
     *
     * @param \ReadingLists\Model\Title $title The created title
     */
    public function createTitle(\ReadingLists\Model\Title $title) {
        $this->viewTitle($title);
    }

    /*
     * Edits a title
     *
     * @param \ReadingLists\Model\Title|null $title The edited title
     */
    public function editTitle(\ReadingLists\Model\Title $title = null) {
        $this->viewTitle($title);
    }

    /*
     * Removes a title
     *
     * @param \ReadingLists\Model\Title|null $title The removed title
     */
    public function removeTitle(\ReadingLists\Model\Title $title = null) {
        $this->viewTitle($title);
    }

}

