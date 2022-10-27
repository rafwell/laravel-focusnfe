<?php

namespace Rafwell\Focusnfe;

use \Illuminate\Http\Response;

class FocusnfeResponse extends Response{
    
    public function setValues($content){
        
        $arr = json_decode($content, true);
        
        foreach($arr as $k=>$i){
            $this->$k = $i;
        }
        
        parent::setValues($content);
    }

    public function getValues():array
    {
        $res = parent::getContent();
        return json_decode($res, true);
    }
}