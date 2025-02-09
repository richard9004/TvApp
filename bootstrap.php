<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/SeriesRepository.php';
require_once __DIR__ . '/SeriesController.php';
require_once __DIR__ . '/Request.php';
require_once __DIR__ . '/Response.php';
require_once __DIR__ . '/Validator.php';
$config = require __DIR__ . '/config.php';

$database = new Database($config['database']['host'], $config['database']['dbname'], $config['database']['username'], $config['database']['password']);
$connection = $database->getConnection();
$seriesRepo = new SeriesRepository($connection);
$seriesController = new SeriesController($seriesRepo);