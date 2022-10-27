<?php

namespace Rafwell\Focusnfe;

use Illuminate\Support\Facades\Log;
use Rafwell\Focusnfe\Exceptions\FocusnfeInvalidRequest;

class Municipio{    
    use FocusnfeContract;
    protected $itensPorPagina = 100;
    protected function enviar($uriBase, $paginaAtual = 0):FocusnfeResponse{
        $ch = curl_init();

        if($paginaAtual>0){
            $uri = $uriBase.'?&offset='.$this->itensPorPagina*$paginaAtual;
        }else{
            $uri = $uriBase;
        }

        $url = $this->getServer().'/v2/municipios' . $uri;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        
        curl_setopt($ch, CURLOPT_USERPWD, $this->getLogin().':'.$this->getPassword());
        $body = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if($http_code!=200){
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

    
    /**
     * Consulta a lista de municipios e retorna uma pagina, iniciando com a página 0.
     * @return array
     */
    public static function listar($pagina = 0):array{
        $instance = new self;
        $response = $instance->enviar('/', $pagina);
        return  $response->getValues();
        
    }

    /**
     * Consulta a um municipio específico
     * @return array
     */
    public static function consultar($municipio_cod_ibge):array{
        $instance = new self;
        $response = $instance->enviar("/{$municipio_cod_ibge}");

        return  $response->getValues();
        
    }

    /**
     * Consulta a lista de itens de serviço de um municipio, iniciando com a página 0.
     * @return array
     */
    public static function itensListaServico($municipio_cod_ibge, $pagina = 0):array{
        $instance = new self;
        $response = $instance->enviar("/{$municipio_cod_ibge}/itens_lista_servico", $pagina);

        return  $response->getValues();
        
    }

    /**
     * Consulta a um item da lista de serviço
     * @return array
     */
    public static function consultarItemListaServico($municipio_cod_ibge, $codItemListaServico):array{
        $instance = new self;

        $uri = "/{$municipio_cod_ibge}/itens_lista_servico/{$codItemListaServico}";

        $response = $instance->enviar( $uri );

        return  $response->getValues();
        
    }

    /**
     * Consulta a lista de codigos tributários municipais, iniciando com a página 0.
     * @return array
     */
    public static function codigosTributarios($municipio_cod_ibge, $pagina = 0):array{
        $instance = new self;
        $response = $instance->enviar("/{$municipio_cod_ibge}/codigos_tributarios_municipio", $pagina);

        return  $response->getValues();
        
    }


    /**
     * Consulta a um código tributario
     * @return array
     */
    public static function consultarCodigoTributario($municipio_cod_ibge, $codTributario):array{
        $instance = new self;
        $response = $instance->enviar("/{$municipio_cod_ibge}/codigos_tributarios_municipio/{$codTributario}");

        return  $response->getValues();
        
    }
}
