<?php

namespace Phire\Search\Controller;

use Phire\Search\Model;
use Phire\Controller\AbstractController;
use Pop\Paginator\Paginator;

class SearchesController extends AbstractController
{

    /**
     * Index action method
     *
     * @return void
     */
    public function index()
    {
        $search = new Model\Search();

        if ($this->request->isPost()) {
            $search->remove($this->request->getPost());
            $this->redirect(BASE_PATH . APP_URI . '/searches?removed=' . time());
        } else {
            if ($search->hasPages($this->config->pagination)) {
                $limit = $this->config->pagination;
                $pages = new Paginator($search->getCount(), $limit);
                $pages->useInput(true);
            } else {
                $limit = null;
                $pages = null;
            }

            $this->prepareView('search/index.phtml');
            $this->view->title = 'Searches';
            $this->view->pages = $pages;
            $this->view->searches = $search->getAll(
                $limit, $this->request->getQuery('page'), $this->request->getQuery('sort')
            );

            $this->send();
        }
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
