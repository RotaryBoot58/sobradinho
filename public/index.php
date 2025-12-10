<?php

require '../utilities.php';
require '../router.php';

$router = new Router();

$router->get('', 'Geral', 'index');

$router->get('/services', 'Service', 'index');
$router->get('/service/create', 'Service', 'viewCreate');
$router->get('/service/read', 'Service', 'read');
$router->get('/service/update', 'Service', 'viewUpdate');

$router->post('/service/create', 'Service', 'create');
$router->post('/service/update', 'Service', 'update');
$router->post('/service/delete', 'Service', 'delete');

$router->route();
