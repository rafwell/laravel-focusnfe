<?php

namespace Rafwell\Focusnfe;

use Rafwell\Focusnfe\Exceptions\FocusnfeInvalidRequest;

class NFSe{    
    use FocusnfeContract;
    
    public function enviar($ref, array $data):FocusnfeResponse{
        $ch = curl_init();

        $url = $this->getServer()."/v2/nfse?ref=" . $ref;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->getLogin().':'.$this->getPassword());
        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if($http_code!=202){
            $arr = json_decode($body, true);
            $msg = 'Erro';
            if(isset($arr['codigo']))
                $msg .= 'código '.$arr['codigo'];
            
            if(isset($arr['mensagem']))
                $msg .= ' : '.$arr['mensagem'];

            if($msg=='Erro'){
                $msg = htmlentities($body);
            }

            throw new FocusnfeInvalidRequest($msg);
        }

        $response = new FocusnfeResponse($body, $http_code);

        return $response;
    }
}
