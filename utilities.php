<?php

const MODEL = 1;
const VIEW = 2;
const COMPONENT = 4;
const NO_EXT = 8;

function module(string $name, int $flag = 0, int $ext_flag = 0): string
{
	$module = '../';

	if($flag & MODEL)
	{
		$module .= "models/$name";
	}
	elseif($flag & VIEW)
	{
		$module .= "views/$name";
	}
	elseif($flag & COMPONENT)
	{
		$module .= "views/components/$name";
	}
	else
	{
		$module .= $name;
	}
	
	if($ext_flag & NO_EXT)
	{
		$module .= '';
	}
	else
	{
		$module .= '.php';
	}

	return $module;
}

function redirect(string $route, ?string $data_name = null, ?array $data = null)
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
	session_destroy();
	exit();
}

function renderErrorBox($item)
{
	return require '../views/components/error_box.php';
	session_destroy();
	exit();
}
