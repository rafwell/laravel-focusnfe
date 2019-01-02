<?php

namespace Rafwell\Focusnfe;

use \Illuminate\Http\Response;

class FocusnfeResponse extends Response{
    
    public function setContent($content){
        $arr = json_decode($content, true);
        
        foreach($arr as $k=>$i){
            $this->$k = $i;
        }
        
        parent::setContent($content);
    }

    public function getContent()
    {
        $res = parent::getContent();
        return json_decode($res, true);
    }
}