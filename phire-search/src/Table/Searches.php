<?php

namespace Phire\Search\Table;

use Pop\Db\Record;

class Searchs extends Record
{

    /**
     * Table prefix
     * @var string
     */
    protected $prefix = DB_PREFIX;

    /**
     * Primary keys
     * @var array
     */
    protected $primaryKeys = ['id'];

}