<?php

namespace Loop;

use Timer\Timer;
use Timer\TimerGroup;


class Loop implements ILoop {
    private $isRunning;
    private $timerGroup;


    public function __construct(){
        $this->timerGroup = new TimerGroup();
    }

    public function setTimeout($millisecond, $callback){
        if(is_int($millisecond) && is_callable($callback)){
            $this->timerGroup->addTimer(new Timer($millisecond/1000, $callback, false));
        }
        else {
            trigger_error("The provided argument is not a vaild type", E_USER_WARNING);
        }
    }

    public function setInterval($millisecond, $callback){
        if(is_int($millisecond) && is_callable($callback)){
            $this->timerGroup->addTimer(new Timer($millisecond/1000, $callback, true));
        }
        else {
            trigger_error("The provided argument is not a vaild type", E_USER_WARNING);
        }
    }

    public function run(){
        $this->isRunning = true;

        while($this->isRunning){
            $this->timerGroup->tick();
        }
    }

    public function stop(){
        $this->isRunning = false;
    }

}