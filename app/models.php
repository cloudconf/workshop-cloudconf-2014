<?php

$app->bootstrap("user", function() use ($app) {
    $model = new Model\User($app->getBootstrap()->getResource("db"));
    return $model;
});

$app->bootstrap("book", function() use ($app) {
    $model = new Model\Book($app->getBootstrap()->getResource("db"));
    return $model;
});

