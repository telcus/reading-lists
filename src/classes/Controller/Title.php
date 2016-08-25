<?php

namespace ReadingLists\Controller;

/**
 * Controller for Creating, Reading, Updating and Deleting of Titles
 *
 * @package ReadingLists
 * @subpackage Controller
 */

class Title {
    /** @var \ReadingLists\Repository\ITitle Repository of titles */
    protected $title_reposistory;
    /** @var \ReadingLists\View\ITitle View for displaying the results of the controller */
    protected $view;

    /**
     * Creates a new Titles controller
     *
     * @param \ReadingLists\Repository\ITitle The repository of titles
     * @param \ReadingLists\View\ITitle The view for displaying the results of the controller
     */
    public function __construct(\ReadingLists\Repository\ITitle $title_repository, \ReadingLists\View\ITitle $view) {
        $this->title_repository = $title_repository;
        $this->view = $view;
    }

    /**
     * Shows a list of titles 
     *
     * @param int $page The page of the results to show
     * @param int $page_size The size of the page to show
     */
    public function listTitles($page = 1, $page_size = 10) {
        $this->view->listTitles($this->title_repository->lookupTitles(new \ReadingLists\Collection\Constraints($page, $page_size)));
    }

    /**
     * Shows the detail of a title
     *
     * @param int $title_id The title to show
     */
    public function viewTitle($title_id) {
        $this->view->viewTitle($this->title_repository->findByTitleId(new \ReadingLists\Type\Id($title_id)));
    }

    /**
     * Creates a new title
     *
     * @param string $title_name The title to show
     */
    public function createTitle($title_name) {
        $title = new \ReadingLists\Model\Title(new \ReadingLists\Type\Id(), $title_name);
        $title = $this->title_repository->storeTitle($title);

        $this->view->createTitle($title);
    }

    /**
     * Edits a title
     *
     * @param int $title_id The title to edit
     * @param string $title_name The title to show
     */
    public function editTitle($title_id, $title_name) {
        $title = $this->title_repository->findByTitleId(new \ReadingLists\Type\Id($title_id));

        if ($title) {
            $title->setName($title_name);        
            $title = $this->title_repository->storeTitle($title);
        }

        $this->view->editTitle($title);
    }

    /**
     * Removes a title
     *
     * @param int $title_id The title to remove 
     */
    public function removeTitle($title_id) {
        $title = $this->title_repository->findByTitleId(new \ReadingLists\Type\Id($title_id));

        if ($title) {
            $title = $this->title_repository->removeTitle($title);
        }

        $this->view->removeTitle($title);
    }

}

