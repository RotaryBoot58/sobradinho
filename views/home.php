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
					<input type="number" name="code" required  autocomplete="off">
				</label>

				<label>
					Tipo:
					<select name="type" required>
						<option value="">Selecionar tipo</option>
						<option value="Instalação">Instalação</option>
						<option value="Manutenção">Manutenção</option>
						<option value="Retirada">Retirada</option>
						<option value="Upgrade">Upgrade</option>
						<option value="Troca de endereço">Troca de endereço</option>
					</select>
				</label>

				<label>
					Técnico:
					<input type="text" name="technic" required  autocomplete="off">
				</label>
			</fieldset>

			<fieldset id="a1">
				<legend>ONU</legend>

				<label>
					Modelo:
					<input type="text" name="onu" autocomplete="off">
				</label>

				<label>
					Uso:
					<select name="onu_usage">
						<option value="">Selecionar uso</option>
						<option value="Comprado">Comprado</option>
						<option value="Utilizado">Retirado</option>
						<option value="Reutilizado">Reutilizado</option>
					</select>
				</label>
			</fieldset>

			<fieldset>
				<legend>Roteador</legend>

				<label>
					Modelo:
					<input type="text" name="router" autocomplete="off">
				</label>

				<label>
					Uso:
					<select name="router_usage">
						<option value="">Selecionar uso</option>
						<option value="Comprado">Comprado</option>
						<option value="Utilizado">Retirado</option>
						<option value="Reutilizado">Reutilizado</option>
					</select>
				</label>
			</fieldset>

			<button type="submit">Criar</button>
		</form>

		<section id="error-box">
			<?php
				printr($_SESSION['services-create_errors']);
				session_destroy(); 
			?>
		</section>
		
		<h1>Resumo de estoque</h1>

		<table>
			<thead>
				<tr>
					<th scope="col"></th>
					<th scope="col">Comprados</th>
					<th scope="col">Utilizados</th>
					<th scope="col">Reutilizados</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<th scope="row">Roteadores</th>
					<td><?= $summary['router_comprados'] ?></td>
					<td><?= $summary['router_reutilizados'] ?></td>
					<td><?= $summary['router_retirados'] ?></td>
				</tr>
				<tr>
					<th scope="row">ONUs</th>
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
