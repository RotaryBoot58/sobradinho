<?php

require '../router.php';

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

function redirect(string $route)
{
	header("Location: http://localhost:8000/{$route}");
	exit();
}

function printr(...$array)
{
    echo "<pre>";
    foreach($array as $arra)
    {
    	print_r($array);
    }
    echo "</pre>";
}
