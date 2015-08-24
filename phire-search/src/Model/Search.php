<?php

namespace Phire\Search\Model;

use Phire\Content\Table;
use Phire\Model\AbstractModel;

class Search extends AbstractModel
{

    /**
     * Execute search
     *
     * @param  array   $fields
     * @params boolean $fieldsLoaded
     * @return array
     */
    public function search($fields, $fieldsLoaded = false)
    {
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
        $params['title'] = '%' . $fields['title'] . '%';

        $sql->select()->orderBy('title', 'ASC');

        $results = Table\Content::execute((string)$sql, $params)->rows();

        foreach ($results as $i => $row) {
            $roles = unserialize($row->roles);
            if ((count($roles) > 0) && (!in_array($this->user_role_id, $roles))) {
                unset($results[$i]);
            } else if ($fieldsLoaded) {
                $filters = ['strip_tags' => null];
                if ($this->summary_length > 0) {
                    $filters['substr'] = [0, $this->summary_length];
                };
                $item = \Phire\Fields\Model\FieldValue::getModelObject(
                    'Phire\Content\Model\Content', ['id' => $row->id], 'getById', $filters
                );
                $results[$i] = new \ArrayObject($item->toArray(), \ArrayObject::ARRAY_AS_PROPS);
            }
        }

        return $results;
    }

}
