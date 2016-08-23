Biblioteca PHP para a API UptimeRobot.com
==============

Para mais informações, acesse: https://uptimerobot.com/api

## Pre-requisitos
* Configure a variável $config['apiKey']
* Deve estar executando PHP >= 5.4
* O Formato será JSON ou não haverá JSON Callback

##Composer
Inclua isso no seu arquivo composer.json

```JSON
{
    "require": {
        "codemaxbr/api-uptimerobot": "@stable"
    }
}
```

## Exemplo

```PHP
<?php
//Requires composer install to work
require_once(__DIR__.'/vendor/autoload.php');

use UptimeRobot\API;

//Set configuration settings
$config = [
    'apiKey' => 'APIKEY',
    'url' => 'http://api.uptimerobot.com'
];

try {

    //Initalizes API with config options
    $api = new API($config);

    //Define parameters for our getMethod request
    $args = [
        'showTimezone' => 1
    ];

    //Makes request to the getMonitor Method
    $results = $api->request('/getMonitors', $args);

    //Output json_decoded contents
    var_dump($results);

} catch (Exception $e) {
    echo $e->getMessage();
    //Output various debug information
    var_dump($api->debug);
}

```
