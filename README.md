# laravel-focusnfe
Integração Laravel com a api focus nfe para emissão de documentos fiscais.

## Isenção de responsabilidade
Ao usar este pacote você se responsabiliza pelos documentos fiscais emitidos. Não temos controle nenhum sobre a veracidade das informações ou cálculos de impostos, ou validações quaisquer. Este pacote é apenas uma abstração da documentação https://focusnfe.com.br/doc para utilização em framework Laravel. Se você não concorda com isso, por favor não utilize este pacote.

## Desenvolvimento necessário
Aceitamos PR que venham a incluir mais abstrações como a NFe, Manifestação da NFe, NFCe, etc.
Caso encontre algum problema, abra um issue para discussão.

# Instalação
Execute `composer require rafwell/laravel-focusnfe^1.0`

Caso esteja usando laravel 5.5 nosso pacote será automaticamente descoberto. Caso contrário, adicione nosso provider ao seu config/app.php `Rafwell\Focusnfe\FocusnfeServiceProvider::class`

Em seguida, publique nosso arquivo de configuração com:
```
php artisan vendor:publish --provider='Rafwell\Focusnfe\FocusnfeServiceProvider'
```

Configure o seu arquivo .env com as informaçes passadas pela Focusnfe:

```
FOCUSNFE_LOGIN='seu token de produção'
FOCUSNFE_LOGIN_SANDBOX='seu token de homologação'
FOCUSNFE_PASSWORD='sua senha'
```
Tudo pronto para começar.

# Exemplo NFSe
Adicione a dependência ao seu controller ou repositório `use Rafwell\Focusnfe\NFSe;`

### Emitir
Siga a documentação do focusnfe para montar o seu array `$data`.

```
$NFSe = new NFSe;

$res = $NFSe->enviar($ref, $data);
if($res->status == 'processando_autorizacao'){
    //Nota enviada com sucesso
}
```

### Consultar

```
$res = $NFSe->consultar($ref);
if($res->status == 'autorizado'){
    //Nota autorizada pela prefeitura
}
```

### Cancelar

```

$justificativa = 'Exemplo';

$res = $NFSe->cancelar($ref, $justificativa);
if($res->status == 'cancelado'){
    //Nota cancelada pela prefeitura
}
```

### Enviar por e-mail

```

$emails = ['email1@teste.com', 'email2@teste.com'];
$NFSe->email($ref, $emails);
```

