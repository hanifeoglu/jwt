<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        // database connection details
        "db" => [
            "host" => "localhost",
            "dbname" => "arjunphp_jwt_auth",
            "user" => "root",
            "pass" => "root",
            "unix_socket" => "/Applications/MAMP/tmp/mysql/mysql.sock"

        ],

        // jwt settings
        "jwt" => [
            'secret' => 'supersecretkeyyoushouldnotcommittogithub'
        ]
    ],
];
