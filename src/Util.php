<?php

namespace Rafwell\Focusnfe;

class Util{    
    public static function onlyNumbers($str){
       return preg_replace('/[^0-9]/', '', $str);
    }
}
