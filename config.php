<?php
require_once __DIR__ . '/env.php'; 

return [
    'database' => [
        'host' => getenv('DB_HOST'),
        'dbname' => getenv('DB_NAME'),
        'username' => getenv('DB_USER'),
        'password' => getenv('DB_PASS'),
    ],
];

?>