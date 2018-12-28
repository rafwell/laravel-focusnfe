<?php

namespace Rafwell\Focusnfe;

use \Illuminate\Http\Response;
use Rafwell\Focusnfe\Exceptions\FocusnfeInvalidRequest;

class FocusnfeResponse extends Response{
    public function setContent($content){
        $arr = json_decode($content, true);
        
        if($arr['codigo']!=200){
            throw new FocusnfeInvalidRequest('Erro '.$arr['codigo'].': '.$arr['mensagem']);
        }
        
        parent::setContent($content);
    }
}