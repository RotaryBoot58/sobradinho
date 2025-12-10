<?php

const NO_EXT = 1;

function module(string $module): string
{
	return "../{$module}.php";
}

function model(string $model): string
{
	return "../models/{$model}.php";
}

function component(string $component, int $flags = 0): string
{
	if($flags & NO_EXT)
	{
		return "../views/{$component}";
	}

	return "../views/{$component}.php";
}

function view(string $view, int $flags = 0): string
{
	if($flags & NO_EXT)
	{
		return "../views/{$view}";
	}

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
	require "../views/errors/{$code}.php";
	exit();
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

function renderSuccessBox($item)
{
	return require '../views/components/success_box.php';
}

function renderErrorBox($item)
{
	return require '../views/components/error_box.php';
}
