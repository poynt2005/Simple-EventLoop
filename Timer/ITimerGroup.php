<?php

namespace Timer;

interface ITimerGroup {

    public function addTimer(ITimer $newTimer);

    public function isTimerExists(ITimer $checkTimer);

    public function deleteTimer(ITimer $toDelete);

    public function isEmpty();

    public function tick();
}