<?php
$app->getEventManager()->subscribe("loop.startup", function() {
    session_start();
});

$app->getEventManager()->subscribe("pre.dispatch", function($router, $app) {
    if (!array_key_exists("auth", $_SESSION) || $_SESSION["auth"] !== true) {
        $router->setControllerName("admin");
        $router->setActionName("login");

        $app->getBootstrap()->getResource("layout")->setScriptName("admin.phtml");
    }
});


