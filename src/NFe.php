<?php

namespace Rafwell\Focusnfe;

use Rafwell\Focusnfe\Exceptions\FocusnfeInvalidRequest;

class NFe
{
    use FocusnfeContract;

    /**
     * Envia uma NFE para emissão
     */
    public function enviarNfe($ref, array $data): FocusnfeResponse
    {
        $ch = curl_init();

        $url = $this->getServer() . '/v2/nfe?ref=' . $ref;

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

    /**
     * Consulta uma NFE
     */
    public function consultar($ref, $completa = 0): FocusnfeResponse
    {
        $ch = curl_init();

        $url = $this->getServer() . '/v2/nfe/' . $ref . '?completa=' . $completa;

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

    /**
     * Cancela uma NFE
     */
    public function cancelar($ref, string $justificativa): FocusnfeResponse
    {
        $ch = curl_init();

        $url = $this->getServer() . '/v2/nfe/' . $ref;

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

    /**
     * Reenvia por e-mail uma NFE
     */

    public function email($ref, array $emails)
    {
        $ch = curl_init();

        $url = $this->getServer() . '/v2/nfe/' . $ref . '/email';

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

    /**
     * Envia uma carta de correção eletrônica para uma NFE
     */
    public function enviarCce($ref, array $data): FocusnfeResponse
    {
        $ch = curl_init();

        $url = $this->getServer() . '/v2/nfe/' . $ref . '/carta_correcao';

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

    public function inutilizar(array $data): FocusnfeResponse
    {
        $ch = curl_init();

        $url = $this->getServer() . '/v2/nfe/inutilizacao';

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
}
