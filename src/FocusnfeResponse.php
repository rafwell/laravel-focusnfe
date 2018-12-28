<?php

namespace Rafwell\Focusnfe;

use \Illuminate\Http\Response;

class FocusnfeResponse extends Response{
    
    public function getContent()
    {
        $res = parent::getContent();
        return json_decode($res, true);
    }
}