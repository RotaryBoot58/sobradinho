<?php

class Router
{
	private array $get_routes;
	private array $post_routes;

	public function get(string $path, string $class, string $method): void
	{
		$this->get_routes[$path]['class'] = $class;
		$this->get_routes[$path]['method'] = $method;
	}

	public function post(string $path, string $class, string $method): void
	{
		$this->post_routes[$path]['class'] = $class;
		$this->post_routes[$path]['method'] = $method;
	}

	public function route()
	{
		$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		$uri = rtrim($uri, '/');
		$method = strtolower($_SERVER['REQUEST_METHOD']);

		$routes = match($method)
		{
			'get' => $this->get_routes,
			'post' => $this->post_routes,
			default => $this->abort(405, 'Method not supported.')
		};

		foreach($routes as $path => $columns)
		{
			if($path === $uri)
			{
				require 'controllers/' . $columns['class'] . ".php";
				
				$class = new $columns['class'];
				$tmp = $columns['method'];
				return $class->$tmp();
				// call_user_func([$class, $columns['method']]);
			}
		}

		$this->abort(404, 'Page not found.');
	}

	private function abort(int $code, string $message): void
	{
		http_response_code($code);
		exit($message);
	}
}
