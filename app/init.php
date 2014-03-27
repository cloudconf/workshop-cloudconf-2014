<?php
require_once __DIR__ . '/../vendor/autoload.php';

$config = new Config();
$config->load(__DIR__ . '/../config/services.ini', array('dev'));

$pdo = new PDO(
    $config->db()->dsn,
    $config->db()->user,
    $config->db()->pass
);

$pdo->exec(file_get_contents(__DIR__ . '/../data/dump.sql'));

