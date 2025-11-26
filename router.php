<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');
$method = strtoupper($_SERVER['REQUEST_METHOD']);

// Routes URI should be in portuguese for readability sake
$get_routes = [
	'' => '../controllers/home.php',
];

$post_routes = [
	'service/create' => '../controllers/service/create.php',
];

switch($method)
{
	case 'GET':
		$routes = $get_routes;
		break;

	case 'POST':
		$routes = $post_routes;
		break;

	default:
		abort(405, 'Request method is not supported');
}

foreach($routes as $route => $action)
{
	if($route === $uri)
	{
		return require $action;
	}
}

abort(404, 'Page not found');

function abort(int $code, string $message)
{
	http_response_code($code);
	exit($message);
}
