<?php

function module(string $module): string
{
	return "../{$module}.php";
}

function model(string $model): string
{
	return "../models/{$model}.php";
}

function component(string $component): string
{
	return "../views/components/{$component}.php";
}

function view(string $view): string
{
	return "../views/{$view}.php";
}

function redirect(string $route, string $data_name = null, array $data = null)
{
	if($data)
	{
		session_start();
		$_SESSION[$data_name] = $data;
	}
	
	header("Location: http://localhost:8000/{$route}");
	exit();
}

function redirectErrorPage(int $code)
{
	return require "../views/{$code}.php";
}

function printr(...$array)
{
	echo "<pre>";
	foreach($array as $item)
	{
		print_r($item);
	}
	echo "</pre>";
}
