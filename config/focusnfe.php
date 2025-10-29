<?php
return [
    'sandbox' => env('APP_ENV') != 'production' ? true : false, //true = homologação, false = produção
    'login' => env('FOCUSNFE_LOGIN'),
    'login_sandbox' => env('FOCUSNFE_LOGIN_SANDBOX'),
    'password' => env('FOCUSNFE_PASSWORD'),
    'webhook_authorization' => env('FOCUSNFE_WEBHOOK_AUTHORIZATION'),
    'ambiente' => env('FOCUSNFE_AMBIENTE', 'municipal'), //municipal ou nacional
];
