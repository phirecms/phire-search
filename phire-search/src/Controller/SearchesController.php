<?php

namespace Phire\Search\Controller;

use Phire\Search\Model;
use Phire\Controller\AbstractController;
use Pop\Paginator\Paginator;

class SearchesController extends AbstractController
{

    /**
     * Search action method
     *
     * @return void
     */
    public function search()
    {
        $this->prepareView('search-public/index.phtml');
        $this->view->title = 'Searches';
        $this->send();
    }

    /**
     * Prepare view
     *
     * @param  string $search
     * @return void
     */
    protected function prepareView($search)
    {
        $this->viewPath = __DIR__ . '/../../view';
        parent::prepareView($search);
    }

}
