<?php

// $dataInicio = new DateTime("2024-01-01");
// $dataFim = new DateTime("2024-03-31");
// 
// $filtrados = array_filter($clientes, function ($cliente) use ($dataInicio, $dataFim) {
//     $dataCliente = new DateTime($cliente["data"]);
//     return $dataCliente >= $dataInicio && $dataCliente <= $dataFim;
// });
// 
// print_r($filtrados);

require_once model('service');

$service_model = new Service;

$summary = [
	'router_comprados' => 0,
	'router_reutilizados' => 0,
	'router_retirados' => 0,
	'onu_comprados' => 0,
	'onu_reutilizados' => 0,
	'onu_retirados' => 0,
	'cable' => 0,
];

$services = $service_model->index();
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

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/css/home.css">
	<title>Sobradinho | Início</title>
</head>
<body>
	<main>
		<h1>Criar serviço</h1>
		<form method="POST" action="/service/create">
			<fieldset>
				<legend>Detalhes</legend>
				
				<label>
					Código:
					<input type="number" name="code">
				</label>

				<label>
					Tipo:
					<input type="text" name="type">
				</label>

				<label>
					Técnico:
					<input type="text" name="technic">
				</label>

				<label>
					Cabo:
					<input type="number" name="cable">
				</label>
			</fieldset>

			<fieldset id="a1">
				<legend>ONU</legend>

				<label>
					ONU:
					<input type="text" name="onu">
				</label>

				<label>
					Uso:
					<input type="text" name="onu_usage">
				</label>
			</fieldset>


			<fieldset id="a2">
				<legend>Roteador</legend>

				<label>
					Roteador:
					<input type="text" name="router">
				</label>

				<label>
					Uso:
					<input type="text" name="router_usage">
				</label>
			</fieldset>

			<button type="submit">Criar</button>
		</form>

		<h1>Resumo de estoque</h1>

		<h2>Total</h2>
		<table>
			<thead>
				<tr>
					<th>Roteadores e ONUs comprados</th>
					<th>Roteadores e ONUs reutilizados</th>
					<th>Roteadores e ONUs retirados</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><?= $summary['router_comprados'] + $summary['onu_comprados'] ?></td>
					<td><?= $summary['router_reutilizados'] + $summary['onu_reutilizados'] ?></td>
					<td><?= $summary['router_retirados'] + $summary['onu_retirados'] ?></td>
				</tr>
			</tbody>
		</table>

		<h2>Roteadores</h2>
		<table>
			<thead>
				<tr>
					<th>Roteadores comprados</th>
					<th>Roteadores reutilizados</th>
					<th>Roteadores retirados</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><?= $summary['router_comprados'] ?></td>
					<td><?= $summary['router_reutilizados'] ?></td>
					<td><?= $summary['router_retirados'] ?></td>
				</tr>
			</tbody>
		</table>

		<h2>ONUs</h2>
		<table>
			<thead>
				<tr>
					<th>ONUs compradas</th>
					<th>ONUs reutilizadas</th>
					<th>ONUs retiradas</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<td><?= $summary['onu_comprados'] ?></td>
					<td><?= $summary['onu_reutilizados'] ?></td>
					<td><?= $summary['onu_retirados'] ?></td>
				</tr>
			</tbody>
		</table>

		<h2>Lista de serviços</h2>
		<table>
			<thead>
				<tr>
					<th scope="col">Nº</th>
					<th scope="col">Tipo</th>
					<th scope="col">Técnico</th>
					<th scope="col">ONU - Uso</th>
					<th scope="col">Roteador - Uso</th>
					<th scope="col">Cabo</th>
					<th scope="col">Data de abertura</th>
				</tr>
			</thead>

			<tbody>
				<?php
					foreach($services as $service)
					{
						echo <<<ITEM
							<tr>
								<td>$service[code]</td>
								<td>$service[type]</td>
								<td>$service[technic]</td>
								<td>$service[onu] - $service[onu_usage]</td>
								<td>$service[router] - $service[router_usage]</td>
								<td>$service[cable]</td>
								<td>$service[creation_time] - $service[creation_date]</td>
							</tr>
						ITEM;
					}
					unset($service);
				?>
			</tbody>
		</table>
	</main>
</body>
</html>
