<?php
return [
    'doctrine' => [
        'driver' => [
            'zendcartdoctrineorm_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'paths' => __DIR__ . '/../src/ZendCartDoctrineORM/Entity',
            ],

            'orm_default' => [
                'drivers' => [
                    'ZendCartDoctrineORM\Entity' => 'zendcartdoctrineorm_entity',
                ],
            ],
        ],
    ]
];
