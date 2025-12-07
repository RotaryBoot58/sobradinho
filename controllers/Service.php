<?php

require_once '../models/model.php';
require_once '../validator.php';

class Service
{
	private Model $model;

	public function __construct()
	{
		$this->model = new Model('services');
	}

	public function index()
	{
		$filters = ['type', 'technic'];
		$data = [];

		foreach($filters as $filter)
		{
			empty($_GET[$filter]) || $data[$filter] = $_GET[$filter];
		}

		if($_GET['start_date'] && $_GET['end_date'])
		{
			$data['start_date'] = $_GET['start_date'];
			$data['end_date'] = $_GET['end_date'];
		}

		empty($data) && $services = $this->model->index();
		$services = $this->model->index(['*'], $data);
		
		require view('service/index');
	}


	public function create()
	{
		$_POST || redirectErrorPage(400);

		$rules = [
			'type' => ['required', 'in_array:service-type'],
			'code' => ['required', 'number'],
			'technic' => ['required', 'text'],
			'onu' => ['alpha_numerical', 'required_with:onu_usage'],
			'onu_usage' => ['alpha_numerical', 'required_with:onu'],
			'router' => ['alpha_numerical', 'required_with:router_usage'],
			'router_usage' => ['alpha_numerical', 'required_with:router'],
			'cable' => ['number']
		];

		$validator = new Validator($_POST, $rules);

		$validator->validate() || redirect('service/create', 'error', $validator->errors);

		$this->model->create($_POST) || redirect('service/create', 'error', ['O banco de dados falhou em registrar o serviço.']);
		redirect('service/create', 'success', ['Serviço criado com sucesso.']);
	}

	public function read()
	{
		$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
		$id || redirectErrorPage(422);
		
		$service = $this->model->read($id);
		// This must be implemented
		// $service || redirect

		require view('service/update');
	}

	public function update()
	{
		$_POST || redirectErrorPage(400);

		$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
		$id || redirectErrorPage(422);

		$rules = [
			'type' => ['required', 'in_array:service-type'],
			'code' => ['number'],
			'technic' => ['text'],
			'onu' => ['alpha_numerical'],
			'onu_usage' => ['alpha_numerical'],
			'router' => ['alpha_numerical'],
			'router_usage' => ['alpha_numerical'],
			'cable' => ['number']
		];

		$validator = new Validator($_POST, $rules);

		$validator->validate() || redirect('service/update', 'error', $validator->errors);

		$this->model->update($id, $_POST) || redirect('service/create', 'error', ['O banco de dados falhou em atualizar o serviço.']);
		redirect('service/update', 'success', [$id, 'Serviço atualizado com sucesso.']);
	}

	public function delete()
	{
		$_POST || redirectErrorPage(400);

		$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
		$id || redirectErrorPage(422);

		if(!$this->model->delete($id))
		{
			redirectErrorPage(500);
		}

		redirect('services', 'success', ['Serviço apagado com sucesso.']);
	}

	public function viewCreate()
	{
		require view('service/create');
	}
}
