<?php

session_start();

require 'vendor/autoload.php';

$config = yaml_parse_file('config.yaml');

$database = new Dibi\Connection([
    'driver' => $config->database->driver,
    'database' => $config->database->dbName,
    'profiler' => [
        'file' => 'file.log',
    ],
]);