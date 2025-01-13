<?php

use System\Bootstrap;

require __DIR__ . '/vendor/autoload.php';

try {
    $app = new Bootstrap();
}
catch (InvalidArgumentException $ex) {
    $app = new Bootstrap([
        'controller' => 'Erro',
        'action' => 'notfound',
        'params' => ['message' => $ex->getMessage()]
    ]);
}

$app->run();
