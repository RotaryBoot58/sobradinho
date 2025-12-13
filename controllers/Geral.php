<?php

require_once module('model', MODEL);

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

		$servicesOfMonth = [];
		foreach($services as $service)
		{
			if($service['creation_date'] >= date("1.n.Y") && $service['creation_date'] <= date("t.n.Y"))
			{
				$servicesOfMonth[] = $service;
			}
		}

		foreach($servicesOfMonth as $service)
		{
			empty($service['cable']) || $cable + $service['cable'];

			switch($service['router_usage'])
			{
				case 'Novo':
					$router_summary[0]++;
					break;

				case 'Reutilizado':
					$router_summary[1]++;
					break;

				case 'Retirada':
					$router_summary[2]++;
					break;

				default:
					break;
			}

			switch($service['onu_usage'])
			{
				case 'Novo':
					$onu_summary[0]++;
					break;

				case 'Reutilizado':
					$onu_summary[1]++;
					break;

				case 'Retirada':
					$onu_summary[2]++;
					break;

				default:
					break;
			}
		}

		return require module('home', VIEW);
	}
}