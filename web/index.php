<?php
require_once __DIR__ . '/../vendor/autoload.php';

set_include_path(realpath(__DIR__ .'/../src'));

Loader::register();

$app = new Application();
$app->setControllerPath(__DIR__ . '/../src/controllers');

$app->bootstrap('config', function() {
    $conf = new Config();
    $conf->load(__DIR__ . '/../config/services.ini', array('dev'));

    return $conf;
});

$app->bootstrap("db", function() use ($app) {
    $config = $app->getBootstrap()->getResource("config");

    $pdo = new PDO(
        $config->db()->dsn,
        $config->db()->user,
        $config->db()->pass
    );

    return $pdo;
});

$app->bootstrap("cache", function() use ($app) {
    $memcached = new \Memcached();
    $config = $app->getBootstrap()->getResource("config");

    foreach ($config->cache()->server->toArray() as $server) {
        $memcached->addServer($server["host"], $server["port"]);
    }

    return $memcached;
});

$app->bootstrap('view', function(){
    $view = new View();
    $view->addViewPath(__DIR__ . '/../views');

    return $view;
});

$app->bootstrap('layout', function(){
    $layout = new Layout();
    $layout->addViewPath(__DIR__ . '/../layouts');

    return $layout;
});

$app->run();

