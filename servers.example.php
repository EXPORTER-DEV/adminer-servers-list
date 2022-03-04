<?php
return [
    [
        'host' => 'example-app.com:3306',
        'username' => 'user',
        'password' => 'password',
        'label' => 'External Personal',
        'databases' => [
            'mobile_app' => 'Mobile App',
            'website' => 'Website'
        ]
    ],
    [
		// Using "localhost" server running on host
        'host' => 'host.docker.internal:3306',
        'username' => 'user',
        'password' => 'password',
        'label' => 'Local Personal',
    ]
];