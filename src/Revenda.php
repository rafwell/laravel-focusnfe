<?php

namespace Rafwell\Focusnfe;

use Rafwell\Focusnfe\Exceptions\FocusnfeInvalidRequest;

class Revenda
{

    use FocusnfeContract;

    public function __construct($config = [])
    {
        //merge the configurations
        $this->_config = include __DIR__ . '/../config/focusnfe.php';
        $this->_config = array_merge($this->_config, config('focusnfe'));
        $this->_config = array_merge($this->_config, $config);

        return $this;
    }

    /**
     * Monta url da api. Obs: Não existe url de homologação para este endpoint, para testar um novo (post) cadastro, usa-se o parâmetro ?dry_run=1
     * @return string
     */
    protected function getUrl(int $id = null, $offset = null)
    {
        $url = 'https://api.focusnfe.com.br/v2/empresas/';

        if ($id) {
            $url .= $id;
        }

        $params = [];

        if ($offset) {
            $params[] = 'offset=' . $offset;
        }

        if ($this->_config['sandbox']) {
            $params[] = 'dry_run=1';
        }

        $search = implode('&', $params);

        if ($search) {
            $url .= '?' . $search;
        }

        return $url;
    }

    protected function enviar(int $id = null, array $arr, $type, $offset = null): FocusnfeResponse
    {
        $ch = curl_init();

        $offset = $offset ? "&offset={$offset}" : '';

        $url = $this->getUrl($id, $offset);

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arr));
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $this->getLogin() . ':' . $this->getPassword());
        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_code > 201) {
            $response = json_decode($body, true);

            $msg = 'Erro';
            if (isset($response['codigo']))
                $msg .= 'código ' . $response['codigo'];

            if (isset($response['mensagem']))
                $msg .= ' : ' . $response['mensagem'];

            if (isset($response['erros']))
                $msg .= ' : ' . $response['erros'][0]['mensagem'] . ', campo: ' . $response['erros'][0]['campo'];

            if ($msg == 'Erro ') {
                $msg .= htmlentities($body);
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
        $response = $instance->enviar(null, $arr, 'POST');

        return  $response->getContent();
    }

    /**
     * Consulta todas as empresas
     * @return array
     */
    public static function listar($offset = null): array
    {
        $instance = new self;
        $response = $instance->enviar(0, [], 'GET', $offset);

        return  $response->getContent();
    }

    /**
     * 	Consulta uma a empresa a partir do seu identificador
     * @return array
     */
    public static function visualizar($id): array
    {
        $instance = new self;
        $response = $instance->enviar($id, [], 'GET');

        return  $response->getContent();
    }

    /**
     * 	Altera os dados de uma empresa específica
     * @return array
     */
    public static function editar($id, $arr): array
    {
        $instance = new self;
        $response = $instance->enviar($id, $arr, 'PUT');

        return  $response->getContent();
    }

    /**
     * Exclui uma empresa
     * @return array
     */
    public static function excluir($id): array
    {
        $instance = new self;
        $response = $instance->enviar($id, [], 'DELETE');

        return  $response->getContent();
    }
}
