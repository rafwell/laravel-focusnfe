<?php

namespace Rafwell\Focusnfe;

use Rafwell\Focusnfe\Exceptions\FocusnfeInvalidRequest;

class NFSe
{
    use FocusnfeContract;

    public function enviar(string $ref, array $data): FocusnfeResponse
    {

        $url = $this->getServerUri() . '?ref=' . $ref;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->getLogin() . ':' . $this->getPassword());
        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_code != 202) {
            $arr = json_decode($body, true);
            $msg = 'Erro';
            if (isset($arr['codigo']))
                $msg .= 'código ' . $arr['codigo'];

            if (isset($arr['mensagem']))
                $msg .= ' : ' . $arr['mensagem'];

            if ($msg == 'Erro') {
                $msg = htmlentities($body);
            }

            throw new FocusnfeInvalidRequest($msg);
        }

        $response = new FocusnfeResponse($body, $http_code);

        return $response;
    }

    public function consultar(string $ref): FocusnfeResponse
    {

        $url = $this->getServerUri() . '/' . $ref . '.json';

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url . $ref);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array());
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->getLogin() . ':' . $this->getPassword());
        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_code != 200) {
            $arr = json_decode($body, true);
            $msg = 'Erro';
            if (isset($arr['codigo']))
                $msg .= 'código ' . $arr['codigo'];

            if (isset($arr['mensagem']))
                $msg .= ' : ' . $arr['mensagem'];

            if ($msg == 'Erro') {
                $msg = htmlentities($body);
            }

            throw new FocusnfeInvalidRequest($msg);
        }

        $response = new FocusnfeResponse($body, $http_code);

        return $response;
    }

    public function cancelar(string $ref, string $justificativa): FocusnfeResponse
    {

        $url = $this->getServerUri() . '/' . $ref;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'justificativa' => $justificativa
        ]));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->getLogin() . ':' . $this->getPassword());

        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_code != 200) {
            $arr = json_decode($body, true);
            $msg = 'Erro';
            if (isset($arr['codigo']))
                $msg .= 'código ' . $arr['codigo'];

            if (isset($arr['mensagem']))
                $msg .= ' : ' . $arr['mensagem'];

            if ($msg == 'Erro') {
                $msg = htmlentities($body);
            }

            throw new FocusnfeInvalidRequest($msg, $http_code);
        }

        $response = new FocusnfeResponse($body, $http_code);

        return $response;
    }

    public function email($ref, array $emails)
    {

        $ch = curl_init();

        $url = $this->getServerUri() . '/' . $ref . '/email';

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'emails' => $emails
        ]));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->getLogin() . ':' . $this->getPassword());

        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_code != 200) {
            $arr = json_decode($body, true);
            $msg = 'Erro';
            if (isset($arr['codigo']))
                $msg .= 'código ' . $arr['codigo'];

            if (isset($arr['mensagem']))
                $msg .= ' : ' . $arr['mensagem'];

            if ($msg == 'Erro') {
                $msg = htmlentities($body);
            }

            throw new FocusnfeInvalidRequest($msg, $http_code);
        }

        $response = new FocusnfeResponse($body, $http_code);

        return $response;
    }
}
