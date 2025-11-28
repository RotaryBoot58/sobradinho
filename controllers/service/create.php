<?php

if(!$_POST)
{
	exit('No data received');
}

require_once model('service');
require_once module('validator');

$service_model = new Service;

// Validation
if(!$_POST['onu'] || !$_POST['onu_usage'])
{
	$_POST['onu'] = null;
	$_POST['onu_usage'] = null;
}

if(!$_POST['router'] || !$_POST['router_usage'])
{
	$_POST['router'] = null;
	$_POST['router_usage'] = null;
}

$rules = [
	'type' => ['required', 'text', 'in_array:service-type'],
	'code' => ['required'],
	'technic' => ['required'],
	'onu' => ['alpha_numerical'],
	'onu_usage' => ['alpha_numerical'],
	'router' => ['alpha_numerical'],
	'router_usage' => ['alpha_numerical'],
	'cable' => ['number']
];

$validator = new Validator($_POST, $rules);

if(!$validator->validate())
{
	session_start();
	$_SESSION['services-create_errors'] = $validator->errors;
	redirect('');
}

$data = $_POST;
$data['creation_date'] = date('j.n.Y');
$data['creation_time'] = date('H:i');
$data['update_date'] = date('j.n.Y');
$data['update_time'] = date('H:i');

$service_model->create($data);
redirect(''); 
