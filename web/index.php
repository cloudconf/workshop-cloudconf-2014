<?php
require_once __DIR__ . '/../vendor/autoload.php';

set_include_path(realpath(__DIR__ .'/../src'));

Loader::register();

use Aws\Common\Aws;

$app = new Application();
$app->setControllerPath(__DIR__ . '/../src/controllers');

$app->bootstrap('config', function() {
    $conf = new Config();
    $conf->load(__DIR__ . '/../config/services.ini', array('dev'));

    return $conf;
});

$app->bootstrap("awsConf", function() {
    $conf = new Config();
    $conf->load(__DIR__ . '/../config/aws.ini');

    return $conf;
});

$app->bootstrap('aws', function() use ($app) {
    $conf = $app->getBootstrap()->getResource("awsConf");
    $aws = Aws::factory($conf->aws()->toArray());

    return $aws;
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

include __DIR__ . '/../app/events.php';
include __DIR__ .' /../app/models.php';

$app->run();

