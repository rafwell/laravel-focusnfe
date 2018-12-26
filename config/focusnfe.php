<?php
return [
	'sandbox'=>env('APP_ENV')!='production' ? true : false, //true = homologação, false = produção
    'ref'=>env('FOCUSNFE_REF'),
    'login'=>env('FOCUSNFE_LOGIN'),
    'password'=>env('FOCUSNFE_PASSWORD'),
];