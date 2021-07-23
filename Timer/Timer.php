<?php

namespace Timer;

use Timer\ITimer;

class Timer implements ITimer {
    private $callback;
    private $sec;
    private $isInterval;

    public function __construct($sec, $callback, $isInterval){
        $this->sec = $sec;
        $this->callback = $callback;
        $this->isInterval = $isInterval;
    }

    public function getCallback(){
        return $this->callback;
    }

    public function getIsInterval(){
        return $this->isInterval;
    }

    public function getSec(){
        return $this->sec;
    }
}