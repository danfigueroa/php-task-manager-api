<?php
require_once __DIR__ . '/vendor/autoload.php';

use OpenApi\Generator;

// Gera a documentação a partir das anotações nos arquivos PHP
$openapi = Generator::scan(['src/Controllers', 'src/Docs']);

// Salva o arquivo na pasta public/
file_put_contents(__DIR__ . '/public/openapi.json', $openapi->toJson());
