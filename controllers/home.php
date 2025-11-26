<?php

session_start();
require_once model('service');

$service_model = new Service;
$servicesAll = $service_model->index();
$summary = [
	'router_comprados' => 0,
	'router_reutilizados' => 0,
	'router_retirados' => 0,
	'onu_comprados' => 0,
	'onu_reutilizados' => 0,
	'onu_retirados' => 0,
	'cable' => 0
];

$services = [];
foreach($servicesAll as $service)
{
	if($service['creation_date'] >= date("1.n.Y") && $service['creation_date'] <= date("t.n.Y"))
	{
		$services[] = $service;
	}
}
unset($service);

foreach($services as $service)
{
	// Roteadores
	if($service['router'])
	{
		// $totalComprados++;
		switch($service['router_usage'])
		{
			case 'comprado':
				$summary['router_comprados']++;
				break;

			case 'reutilizado':
				$summary['router_reutilizados']++;
				break;

			case 'retirado':
				$summary['router_retirados']++;
				break;
		}
	}

	// ONUs
	if($service['onu'])
	{
		// $totalComprados++;
		switch($service['onu_usage'])
		{
			case 'comprado':
				$summary['onu_comprados']++;
				break;

			case 'reutilizado':
				$summary['onu_reutilizados']++;
				break;

			case 'retirado':
				$summary['onu_retirados']++;
				break;
		}
	}

	// Cabo
	if($service['cable'])
	{
		$summary['cable']++;
	}
}

require view('home');
