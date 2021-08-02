<?php

namespace Rafwell\Focusnfe;

use Rafwell\Focusnfe\Exceptions\FocusnfeInvalidRequest;

class Webhook
{
    use FocusnfeContract;

    public function criar(array $data): FocusnfeResponse
    {
        $ch = curl_init();

        $url = $this->getServer() . '/v2/hooks';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->getLogin() . ':' . $this->getPassword());
        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_code != 200) {
            $arr = json_decode($body, true);
            $msg = 'Erro';
            if (isset($arr['codigo']))
                $msg .= ' código ' . $arr['codigo'];

            if (isset($arr['mensagem']))
                $msg .= ': ' . $arr['mensagem'];

            if ($msg == 'Erro') {
                $msg = htmlentities($body);
            }

            throw new FocusnfeInvalidRequest($msg);
        }

        $response = new FocusnfeResponse($body, $http_code);

        return $response;
    }

    public function consultar($hook_id = null): FocusnfeResponse
    {
        $ch = curl_init();

        $url = $this->getServer() . '/v2/hooks' . ($hook_id ? '/' . $hook_id : '');

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->getLogin() . ':' . $this->getPassword());
        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_code != 200) {
            $arr = json_decode($body, true);
            $msg = 'Erro';
            if (isset($arr['codigo']))
                $msg .= ' código ' . $arr['codigo'];

            if (isset($arr['mensagem']))
                $msg .= ': ' . $arr['mensagem'];

            if ($msg == 'Erro') {
                $msg = htmlentities($body);
            }

            throw new FocusnfeInvalidRequest($msg);
        }

        $response = new FocusnfeResponse($body, $http_code);

        return $response;
    }

    public function excluir($hook_id): FocusnfeResponse
    {
        $ch = curl_init();

        $url = $this->getServer() . '/v2/hooks/' . $hook_id;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_USERPWD, $this->getLogin() . ':' . $this->getPassword());
        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_code != 200) {
            $arr = json_decode($body, true);
            $msg = 'Erro';
            if (isset($arr['codigo']))
                $msg .= ' código ' . $arr['codigo'];

            if (isset($arr['mensagem']))
                $msg .= ': ' . $arr['mensagem'];

            if ($msg == 'Erro') {
                $msg = htmlentities($body);
            }

            throw new FocusnfeInvalidRequest($msg);
        }

        $response = new FocusnfeResponse($body, $http_code);

        return $response;
    }

    /**
     * Solicita à api que reenvie os postbpacks de uma nota
     */
    public function reenviar($nfse_ref): FocusnfeResponse
    {
        $ch = curl_init();

        $url = $this->getServer() . "/v2/nfse/$nfse_ref/hook";

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $this->getLogin() . ':' . $this->getPassword());
        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_code != 200) {
            $arr = json_decode($body, true);
            $msg = 'Erro';
            if (isset($arr['codigo']))
                $msg .= ' código ' . $arr['codigo'];

            if (isset($arr['mensagem']))
                $msg .= ': ' . $arr['mensagem'];

            if ($msg == 'Erro') {
                $msg = htmlentities($body);
            }

            throw new FocusnfeInvalidRequest($msg);
        }

        $response = new FocusnfeResponse($body, $http_code);

        return $response;
    }
}
