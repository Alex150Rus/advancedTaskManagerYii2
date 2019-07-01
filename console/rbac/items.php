<?php
return [
    'createProject' => [
        'type' => 2,
        'description' => 'Create project',
    ],
    'user' => [
        'type' => 1,
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'createProject',
            'user',
        ],
    ],
];
