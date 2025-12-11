<?php

require_once '../models/model.php';

class Geral
{
	private Model $model;

	public function __construct()
	{
		$this->model = new Model('services');
	}

	public function index()
	{
		$services = $this->model->index();
		
		// Order: novo, reutilizado, retirado
		$router_summary = [0, 0, 0];
		$onu_summary = [0, 0, 0];
		$cable = 0;

		foreach($services as $service)
		{
			// if($service['creation_date'] >= date("1.n.Y") && $service['creation_date'] <= date("t.n.Y"))
			// {
			// 	$servicesOfMonth[] = $service;
			// }
			empty($service[8]) || $cable + $service[8];

			$router_summary[] = match($service[5])
			{
				'Novo' => $router_summary[0]++,
				'Reutilizado' =>$router_summary[1]++,
				'Retirada' =>$router_summary[2]++,
				default => null,
			};

			$onu_summary[] = match($service[7])
			{
				'Novo' => $onu_summary[0]++,
				'Reutilizado' =>$onu_summary[1]++,
				'Retirada' =>$onu_summary[2]++,
				default => null,
			};
		}

		return require view('home');
	}
}