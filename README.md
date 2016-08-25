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
//Exec "composer install" ou "composer update" para trabalhar
require_once(__DIR__.'/vendor/autoload.php');

use UptimeRobot\UptimeRobot;

//Definindo as configurações
$upRobot = new UptimeRobot('u956-afus321g565fghr519'); //<-- sua chave

print_r($upRobot->getMonitors());

```
