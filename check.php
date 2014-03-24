<?php

if (!file_exists(__DIR__ . '/vendor/autoload.php')) {
    throw new RuntimeException("You need to install all dependencies using composer. 'php composer.phar install'");
}

echo "All done! Congrats, see you then at CloudConf 2014" . PHP_EOL;

