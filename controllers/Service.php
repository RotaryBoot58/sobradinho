<?php

require_once module('model', MODEL);
require_once module('validator');

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

		$services = $this->model->index(['*'], $data);
		
		return require module('service/index', VIEW);
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
			'cable' => ['number'],
			'description' => ['alpha_numerical'],
			'status' => ['required', 'text', 'in_array:service_status'],
			'numero' => ['required', 'number'],
			'rua' => ['required', 'text'],
			'bairro' => ['required', 'text'],
			'cidade' => ['required', 'text'],
			'cep' => ['required', 'number']
		];

		$validator = new Validator($_POST, $rules);
		
		$validator->validate() || redirect('service/create', 'error', $validator->errors);

		empty($_POST['onu']) && $_POST['onu'] = '';
		empty($_POST['onu_usage']) && $_POST['onu_usage'] = '';
		empty($_POST['router']) && $_POST['router'] = '';
		empty($_POST['router_usage']) && $_POST['router_usage'] = '';
		
		$this->model->create($_POST) || redirect('service/create', 'error', ['database' => $this->model->error]);
		redirect('service/create', 'success', ['Serviço criado com sucesso.']);
	}

	public function read()
	{
		$_GET['id'] = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
		$_GET['id'] || redirectErrorPage(422);

		$service = $this->model->read($_GET['id']);

		$service || redirectErrorPage(500);
		return require module('service/read', VIEW);
	}

	public function update()
	{
		$_POST || redirectErrorPage(400);

		$_POST['id'] = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
		$_POST['id'] || redirectErrorPage(422);

		$rules = [
			'type' => ['required', 'in_array:service-type'],
			'code' => ['number'],
			'technic' => ['text'],
			'onu' => ['alpha_numerical'],
			'onu_usage' => ['alpha_numerical'],
			'router' => ['alpha_numerical'],
			'router_usage' => ['alpha_numerical'],
			'cable' => ['number'],
			'description' => ['text'],
			'status' => ['text', 'in_array:service_status'],
			'numero' => ['number'],
			'rua' => ['text'],
			'bairro' => ['text'],
			'cidade' => ['text'],
			'cep' => ['number']
		];

		$validator = new Validator($_POST, $rules);

		$validator->validate() || redirect('service/update', 'error', $validator->errors);

		$this->model->update($_POST['id'], $_POST) || redirect('service/create', 'error', ['O banco de dados falhou em atualizar o serviço.']);
		redirect('service/update', 'success', [$id, 'Serviço atualizado com sucesso.']);
	}

	public function delete()
	{
		$_POST || redirectErrorPage(400);

		$_POST['id'] = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
		$_POST['id'] || redirectErrorPage(422);

		$this->model->delete($_POST['id']) || redirectErrorPage(500);

		redirect('services', 'success', ['Serviço apagado com sucesso.']);
	}

	public function viewCreate()
	{
		return require module('service/create', VIEW);
	}

	public function viewUpdate()
	{
		$_GET || redirectErrorPage(400);

		$_GET['id'] = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
		$_GET['id'] || redirectErrorPage(422);

		$service = $this->model->read($_GET['id']);

		return require module('service/update', VIEW);
	}
}
