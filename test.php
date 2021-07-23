<?php

require_once "EvLoop.php";

$evloop = EvLoop\EvLoop::createLoop();

$interval_times = 0;
$evloop->setInterval(1000, function() use (&$interval_times) {
    echo "Execute {$interval_times} times\n";
    $interval_times++;
});

$evloop->run();