<?php

namespace Rafwell\Focusnfe;

class NFSe{    
    use FocusnfeContract;
    
    public function enviar(array $data):FocusnfeResponse{
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->getServer()."/v2/nfse?ref=" . $data['id']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->getLogin().':'.$this->getPassword());
        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        $response = new FocusnfeResponse($body, $http_code);

        return $response;
    }
}
