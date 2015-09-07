<?php

return [
    '/search[/]' => [
        'controller' => 'Phire\Search\Controller\IndexController',
        'action'     => 'search'
    ],
    APP_URI => [
        '/searches[/]' => [
            'controller' => 'Phire\Search\Controller\SearchesController',
            'action'     => 'index',
            'acl'        => [
                'resource'   => 'searches',
                'permission' => 'index'
            ]
        ]
];
