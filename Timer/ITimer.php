<?php

namespace Timer;

interface ITimer {
    public function getCallback();

    public function getIsInterval();

    public function getSec();
}

