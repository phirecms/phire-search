<?php
/**
 * Module Name: phire-search
 * Author: Nick Sagona
 * Description: This is the search module for Phire CMS 2, to be used in conjunction with the Content module
 * Version: 1.0
 */
return [
    'phire-search' => [
        'prefix'     => 'Phire\Search\\',
        'src'        => __DIR__ . '/../src',
        'routes'     => include 'routes.php',
        'resources'  => include 'resources.php',
        'nav.module' => [
            'name' => 'Search Log',
            'href' => '/searches',
            'acl'  => [
                'resource'   => 'searches',
                'permission' => 'index'
            ]
        ],
        'events' => [
            [
                'name'     => 'app.send.pre',
                'action'   => 'Phire\Search\Event\Search::setTemplate',
                'priority' => 1000
            ]
        ]
    ]
];
