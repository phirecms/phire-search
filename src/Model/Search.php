<?php

namespace Phire\Search\Model;

use Phire\Search\Table\Searches;
use Phire\Content\Table;
use Phire\Model\AbstractModel;

class Search extends AbstractModel
{

    /**
     * Get all fields
     *
     * @param  int    $limit
     * @param  int    $page
     * @param  string $sort
     * @return array
     */
    public function getAll($limit = null, $page = null, $sort = null)
    {
        $order = $this->getSortOrder($sort, $page);

        if (null !== $limit) {
            $page = ((null !== $page) && ((int)$page > 1)) ?
                ($page * $limit) - $limit : null;

            return Searches::findAll([
                'offset' => $page,
                'limit'  => $limit,
                'order'  => $order
            ])->rows();
        } else {
            return Searches::findAll([
                'order'  => $order
            ])->rows();
        }
    }

    /**
     * Execute search
     *
     * @param  array               $fields
     * @params \Pop\Module\Manager $modules
     * @return array
     */
    public function search($fields, \Pop\Module\Manager $modules)
    {
        $title = strip_tags($fields['title']);

        $selectFields = [
            'id'        => DB_PREFIX . 'content.id',
            'type_id'   => DB_PREFIX . 'content.type_id',
            'parent_id' => DB_PREFIX . 'content.parent_id',
            'title'     => DB_PREFIX . 'content.title',
            'uri'       => DB_PREFIX . 'content.uri',
            'slug'      => DB_PREFIX . 'content.slug',
            'status'    => DB_PREFIX . 'content.status',
            'roles'     => DB_PREFIX . 'content.roles',
            'order'     => DB_PREFIX . 'content.order',
            'publish'   => DB_PREFIX . 'content.publish',
            'expire'    => DB_PREFIX . 'content.expire'
        ];

        $sql = Table\Content::sql();
        $sql->select($selectFields);

        $sql->select()->where('status = :status');
        $params = ['status' => 1];

        if (isset($fields['type_id'])) {
            $sql->select()->where('type_id = :type_id');
            $params['type_id'] = $fields['type_id'];
        }

        $sql->select()->where('title LIKE :title');
        $params['title'] = '%' . $title . '%';

        $sql->select()->orderBy('title', 'ASC');

        $results = Table\Content::execute((string)$sql, $params)->rows();

        foreach ($results as $i => $row) {
            $roles = unserialize($row->roles);
            if ((count($roles) > 0) && (!in_array($this->user_role_id, $roles))) {
                unset($results[$i]);
            } else if ($modules->isRegistered('phire-fields')) {
                $item = \Phire\Fields\Model\FieldValue::getModelObject(
                    'Phire\Content\Model\Content', ['id' => $row->id], 'getById', $this->filters
                );
                $results[$i] = new \ArrayObject($item->toArray(), \ArrayObject::ARRAY_AS_PROPS);
            }
        }

        $log = new Searches([
            'keywords'  => $title,
            'results'   => count($results),
            'method'    => ($_POST) ? 'post' : 'get',
            'timestamp' => time()
        ]);
        $log->save();

        return $results;
    }

    /**
     * Remove search logs
     *
     * @param  array $fields
     * @return void
     */
    public function remove(array $fields)
    {
        if (isset($fields['clear_all']) && ($fields['clear_all'])) {
            $search = new Searches();
            $search->delete(['id-' => null]);
        } else if (isset($fields['rm_searches'])) {
            foreach ($fields['rm_searches'] as $id) {
                $search = Searches::findById((int)$id);
                if (isset($search->id)) {
                    $search->delete();
                }
            }
        }
    }

    /**
     * Determine if list of searches has pages
     *
     * @param  int $limit
     * @return boolean
     */
    public function hasPages($limit)
    {
        return (Searches::findAll()->count() > $limit);
    }

    /**
     * Get count of searches
     *
     * @return int
     */
    public function getCount()
    {
        return Searches::findAll()->count();
    }

}
