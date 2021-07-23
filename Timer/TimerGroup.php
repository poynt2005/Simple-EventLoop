<?php

namespace Timer;

use Timer\ITimer;

class TimerGroup implements ITimerGroup {
    private $currentTime = false;
    private $tasks;
    private $timers;
    private $isSorted;


    public function __construct(){
        $this->tasks = [];
        $this->timers = [];
        $this->isSorted = false;
        $this->currentTime = $this->getCurrentTime();
    }

    private function updateCurrentTime(){
        $this->currentTime = \hrtime(true) * 0.000000001;

        return $this->currentTime;
    }

    private function getCurrentTime(){
        return $this->currentTime ? $this->currentTime : $this->updateCurrentTime();
    }

    public function addTimer(ITimer $newTimer){
        $timerID = \spl_object_hash($newTimer);

        $this->timers[$timerID] = $newTimer;

        //task 的觸發時間為 task 本身的 timeout 加上目前的時間
        $this->tasks[$timerID] = $newTimer->getSec() + $this->updateCurrentTime();


        //當有心的 task 加進來之後，evloop 裡面的順序會被打亂
        $this->isSorted = false;
    }

    public function isTimerExists(ITimer $checkTimer){
        $timerHash = \spl_object_hash($checkTimer);

        return isset($this->timers[$timerHash]) && isset($this->tasks[$timerHash]);
    }

    public function deleteTimer(ITimer $toDelete){
        if(!isTimerExists($toDelete)){
            return false;
        }

        $timerHash = \spl_object_hash($toDelete);

        unset($this->timers[$timerHash]);
        unset($this->tasks[$timerHash]);

        return !isTimerExists($toDelete);
    }

    private function sortTasks(){
        if(!$this->isSorted){
            $this->isSorted = true;
            \asort($this->tasks);
        }
    }

    private function getTimerById($hashID){
        if(!isset($this->timers[$hashID]) || !isset($this->tasks[$hashID])){
            return null;
        }

        return $this->timers[$hashID];
    }

    public function isEmpty(){
        return \count($this->timers) == 0;
    }

    public function tick(){
        $this->sortTasks();

        $this->updateCurrentTime();

        foreach($this->tasks as $hashID => $taskSec){
            //在上面有將時間做排序ㄌ，所以當判斷到時間超過目前的時間的話就 break 掉
            if($this->currentTime <= $taskSec){
                break;
            }

            $timer = $this->getTimerById($hashID);

            if($timer === null){
                continue;
            }

            $callback = $timer->getCallback();
            $callback();

            //如果是 setInterval 的形式的話，加上目前的時間然後下一次 tick 時後繼續循環
            if($timer->getIsInterval()){
                $this->tasks[$hashID] = $timer->getSec() + $this->currentTime;

                //將時序打亂，之後才可以重排
                $this->isSorted = false;
            }
            else{
                //如果是 setTimeout 形式的話，執行一次就沒ㄌ
                unset($this->timers[$hashID]);
                unset($this->tasks[$hashID]);
            }
        }
    }
}