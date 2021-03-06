<?php
/**
 * Phire Search Module
 *
 * @link       https://github.com/phirecms/phire-search
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.phirecms.org/license     New BSD License
 */

/**
 * @namespace
 */
namespace Phire\Search\Controller;

use Phire\Search\Model;
use Phire\Controller\AbstractController;
use Pop\Paginator\Paginator;

/**
 * Search Index Controller class
 *
 * @category   Phire\Search
 * @package    Phire\Search
 * @author     Nick Sagona, III <dev@nolainteractive.com>
 * @copyright  Copyright (c) 2009-2016 NOLA Interactive, LLC. (http://www.nolainteractive.com)
 * @license    http://www.phirecms.org/license     New BSD License
 * @version    1.0.0
 */
class IndexController extends AbstractController
{

    /**
     * Search action method
     *
     * @return void
     */
    public function search()
    {
        $search = new Model\Search();
        $fields = ($this->request->isPost()) ? $this->request->getPost() : $this->request->getQuery();

        $search->user_role_id = (isset($this->sess->user)) ? $this->sess->user->role_id : -1;
        $search->filters      = $this->application->module('phire-content')->config()['filters'];

        if (isset($fields['title'])) {
            $items = $search->search($fields, $this->application->modules());
            if (count($items) > $this->config->pagination) {
                $page  = $this->request->getQuery('page');
                $limit = $this->config->pagination;
                $pages = new Paginator(count($items), $limit);
                $pages->useInput(true);
                $offset = ((null !== $page) && ((int)$page > 1)) ?
                    ($page * $limit) - $limit : 0;
                $items = array_slice($items, $offset, $limit, true);
            } else {
                $pages = null;
            }

            $this->prepareView('search-public/search.phtml');
            $this->view->title = 'Search';
            $this->view->pages = $pages;
            $this->view->items = $items;
            $this->send();
        } else {
            $this->redirect(BASE_PATH . ((BASE_PATH == '') ? '/' : ''));
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
