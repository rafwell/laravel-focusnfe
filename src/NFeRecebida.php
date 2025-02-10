<?php

namespace Rafwell\Focusnfe;

use Exception;
use Rafwell\Focusnfe\Exceptions\FocusnfeInvalidRequest;

class NFeRecebida
{
    use FocusnfeContract;

    /**
     * Envia uma NFE para emissão
     */
    public function listaNfeRecebida($cnpj, $versao): FocusnfeResponse
    {
        $ch = curl_init();

        $url = $this->getServer() . '/v2/nfes_recebidas?cnpj=' . $cnpj . '&versao=' . $versao;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array());
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->getLogin() . ':' . $this->getPassword());
        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headers = curl_getinfo($ch);

        if ($http_code != 200) {
            $arr = json_decode($body, true);
            $msg = 'Erro';
            if (isset($arr['codigo']))
                $msg .= ' código ' . $arr['codigo'];

            if (isset($arr['mensagem']))
                $msg .= ' : ' . $arr['mensagem'];

            if ($msg == 'Erro') {
                $msg = htmlentities($body);
            }

            throw new FocusnfeInvalidRequest($msg);
        }

        $response = new FocusnfeResponse($body, $http_code, $headers);

        return $response;
    }

    public function consultaXml($chave_acesso)
    {
        $ch = curl_init();

        $url = $this->getServer() . "/v2/nfes_recebidas/$chave_acesso.xml";

        curl_setopt($ch, CURLOPT_URL, $url);
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
                $msg .= ' código ' . $arr['codigo'];

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

    public function consultaPdf($chave_acesso)
    {
        $ch = curl_init();

        $url = $this->getServer() . "/v2/nfes_recebidas/$chave_acesso.pdf";

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array());
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->getLogin() . ':' . $this->getPassword());
        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headers = curl_getinfo($ch);

        if ($http_code != 302) {
            $arr = json_decode($body, true);
            $msg = 'Erro';
            if (isset($arr['codigo']))
                $msg .= ' código ' . $arr['codigo'];

            if (isset($arr['mensagem']))
                $msg .= ' : ' . $arr['mensagem'];

            if ($msg == 'Erro') {
                $msg = htmlentities($body);
            }

            throw new FocusnfeInvalidRequest($msg);
        }

        $body = json_encode([
            'url' => $headers['redirect_url']
        ]);

        $response = new FocusnfeResponse($body, $http_code);

        return $response;
    }

    public function consultaManifesto($chave_acesso)
    {
        $ch = curl_init();

        $url = $this->getServer() . "/v2/nfes_recebidas/$chave_acesso/manifesto";

        curl_setopt($ch, CURLOPT_URL, $url);
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
                $msg .= ' código ' . $arr['codigo'];

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

    public function manifesto($chave_acesso, $tipo, $justificativa)
    {
        $ch = curl_init();

        $url = $this->getServer() . "/v2/nfes_recebidas/$chave_acesso/manifesto";

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'tipo' => $tipo,
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
                $msg .= ' código ' . $arr['codigo'];

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
