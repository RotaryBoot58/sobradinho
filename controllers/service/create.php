<?php

if(!$_POST)
{
	exit('No data received');
}

require_once model('service');

$service = new Service;

// $_POST = [
// 	'code' => '54678'
// 	'type' => 'instalacao',
// 	'technic' => 'marcelo',
// 	'onu' => null,
// 	'onu_usage' => null,
// 	'router' => 'G5',
// 	'router_usage' => 'reutilizado',
// 	'cable' => 67,
// 	'creation_date' => date('d-m-Y'),
// 	'creation_time' => date('H:i'),
// 	'update_date' => date('d-m-Y'),
// 	'update_time' => date('H:i')
// ];

$service->create($_POST);
