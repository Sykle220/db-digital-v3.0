<?php
/**
 * @var string $message
 */
$controller = new \App\Controllers\Front\ErrorsController();
$controller->initController(
    service('request'),
    service('response'),
    service('logger'),
);

echo $controller->render404($message ?? null);
