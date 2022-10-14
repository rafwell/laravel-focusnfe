<?php

namespace Rafwell\Focusnfe;

use Rafwell\Focusnfe\Exceptions\FocusnfeInvalidRequest;

class Revenda
{

    use FocusnfeContract;

    protected function enviar(int $id, array $arr, $type, $offset = null): FocusnfeResponse
    {
        $ch = curl_init();

        $offset = $offset ? "?offset={$offset}" : '';

        if (empty($id)) {
            $url = $this->getServer() . '/v2/empresas' . $offset;
        } else {
            $url = $this->getServer() . '/v2/empresas/' . $id;
        }

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arr));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->getLogin() . ':' . $this->getPassword());
        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_code != 200) {
            $response = json_decode($body, true);
            $msg = 'Erro';
            if (isset($response['codigo']))
                $msg .= 'código ' . $response['codigo'];

            if (isset($response['mensagem']))
                $msg .= ' : ' . $response['mensagem'];

            if ($msg == 'Erro') {
                $msg = htmlentities($body);
            }

            throw new FocusnfeInvalidRequest($msg);
        }

        $response = new FocusnfeResponse($body, $http_code);

        return $response;
    }

    /**
     * Cria uma nova empresa
     * @return array
     */
    public static function cadastrar($arr): array
    {
        $instance = new self;
        $response = $instance->enviar(0, $arr, 'POST');

        return  $response->getValues();
    }

    /**
     * Consulta todas as empresas
     * @return array
     */
    public static function listar($offset = null): array
    {
        $instance = new self;
        $response = $instance->enviar(0, [], 'GET', $offset);

        return  $response->getValues();
    }

    /**
     * 	Consulta uma a empresa a partir do seu identificador
     * @return array
     */
    public static function visualizar($id): array
    {
        $instance = new self;
        $response = $instance->enviar($id, [], 'GET');

        return  $response->getValues();
    }

    /**
     * 	Altera os dados de uma empresa específica
     * @return array
     */
    public static function editar($id, $arr): array
    {
        $instance = new self;
        $response = $instance->enviar($id, $arr, 'PUT');

        return  $response->getValues();
    }

    /**
     * Exclui uma empresa
     * @return array
     */
    public static function excluir($id): array
    {
        $instance = new self;
        $response = $instance->enviar($id, [], 'DELETE');

        return  $response->getValues();
    }
}
