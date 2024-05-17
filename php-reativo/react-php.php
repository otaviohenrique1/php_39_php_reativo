<?php

require_once 'vendor/autoload.php';

use React\EventLoop\Factory;

$loop = Factory::create();

// $loop->addPeriodicTimer(1, function() {
$loop->addTimer(1, function() {
  echo "1 segundo" . PHP_EOL;
});

$loop->run();