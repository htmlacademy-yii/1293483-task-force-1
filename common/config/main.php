<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                'tasks' => 'tasks/index',
                'task/<id:\d+>' => 'tasks/view',
                'create' => 'tasks/create',
                'load-files' => 'tasks/load-files',
                'users' => 'users/index',
                'user/<id:\d+>' => 'users/view',
                'signup' => 'landing/signup',
                'logout' => 'landing/logout',
            ],
        ],
    ],
];
