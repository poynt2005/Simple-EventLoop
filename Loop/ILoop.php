<?php

namespace Loop;

interface ILoop {
    public function setTimeout($millisecond, $callback);
    public function setInterval($millisecond, $callback);
    public function run();
    public function stop();
}