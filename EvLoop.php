<?php

namespace EvLoop;

spl_autoload_register(function($class){
    $classNameSplit = explode("\\", $class);

    $namespaceString = "";
    for($i = 0; $i<count($classNameSplit)-1; $i++){
        if($i != count($classNameSplit) - 2){
            $namespaceString = $namespaceString.$classNameSplit[$i].'/';
        }
        else {
            $namespaceString = $namespaceString.$classNameSplit[$i];
        }
    }

    $classString = $classNameSplit[count($classNameSplit)-1];
    

    require_once $namespaceString.'/'.$classString.'.php';
});

use Loop\Loop;

class EvLoop {
    private static $evLoopInstace;
    public static function createLoop(){
        if(self::$evLoopInstace instanceof Loop){
            return self::$evLoopInstace;
        }

        self::$evLoopInstace = new Loop();
        return self::$evLoopInstace;
    }
}