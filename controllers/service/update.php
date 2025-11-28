<?php

if(!$_POST)
{
	exit('No data received');
}

if(count($_POST) > 10)
{
	exit('Too much data');
}

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
if(!$id)
{
	exit('Invalid or missing service id');
}

require_once model('service');
require_once module('validator');

$service_model = new Service;
$service = $service_model->read(
	[
		'type',
		'code',
		'technic',
		'onu',
		'onu_usage',
		'router',
		'router_usage',
		'cable'
	],
	$id
);

if(!$service)
{
	exit("Failed to retrieve service. Maybe the given id does not exists.");
}

$data = array_intersect_key($_POST, $service);

// Validation
$rules = [
	'type' => ['text', 'in_array:service-type'],
	'code' => ['number'],
	'technic' => ['text'],
	'onu' => ['alpha_numerical'],
	'onu_usage' => ['alpha_numerical'],
	'router' => ['alpha_numerical'],
	'router_usage' => ['alpha_numerical'],
	'cable' => ['number']
];
$validator = new Validator($data, $rules);

if(!$validator->validate())
{
	session_start();
	$_SESSION['services-create_errors'] = $validator->errors;
	redirect('');
}

$data['update_date'] = date('j.n.Y');
$data['update_time'] = date('H:i');

$service_model->update($id, $data);
redirect(''); 
