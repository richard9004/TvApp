<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/SeriesRepository.php';
require_once __DIR__ . '/SeriesController.php';
require_once __DIR__ . '/Request.php';
require_once __DIR__ . '/Response.php';

$title = $_GET['title'] ?? null;
$datetime = $_GET['datetime'] ?? null;

$requestDTO = new Request($title, $datetime);

$database = new Database("localhost", "tv_series_db", "root", "");
$connection = $database->getConnection();
$seriesRepo = new SeriesRepository($connection);
$seriesController = new SeriesController($seriesRepo);

$seriesController->getNextAiringSeries($requestDTO);