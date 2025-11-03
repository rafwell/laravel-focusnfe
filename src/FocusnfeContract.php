<?php

namespace Rafwell\Focusnfe;

trait FocusnfeContract
{

    protected $_config;

    protected $server =
    [
        'producao'    => 'https://api.focusnfe.com.br',
        'homologacao' => 'https://homologacao.focusnfe.com.br'
    ];

    protected $ambiente =
    [
        'municipal' => '/v2/nfse',
        'nacional'  => '/v2/nfsen'
    ];


    public function __construct($config = [])
    {
        //merge the configurations
        $this->_config = include __DIR__ . '/../config/focusnfe.php';
        $this->_config = array_merge($this->_config, config('focusnfe'));
        $this->_config = array_merge($this->_config, $config);

        return $this;
    }

    public function getServer(): string
    {

        $ambiente = $this->getNfseMunicipalNacional();

        if ($this->_config['sandbox'])
            return $this->server['homologacao'] . $ambiente;
        else
            return $this->server['producao'] . $ambiente;
    }

    public function getLogin()
    {
        if ($this->_config['sandbox'])
            return $this->_config['login_sandbox'];
        else
            return $this->_config['login'];
    }

    public function getPassword()
    {
        return $this->_config['password'];
    }

    public function getNfseMunicipalNacional(): string
    {

        if (!isset($this->_config['ambiente']))
            return $this->ambiente['municipal'];

        if ($this->_config['ambiente'] == 'nacional')
            return $this->ambiente['nacional'];
        else
            return $this->ambiente['municipal'];
    }
}
