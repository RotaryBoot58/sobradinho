<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/css/service/index.css">
	<title>Sobradinho | Serviços</title>
</head>
<body>
	<aside>
		<?php require component('nav.html', NO_EXT); ?>

		<h2>Filtros</h2>
		<form method="GET" action="/services">
			<label for="type">Tipo:</label>
			<select name="type" id="type">
				<option value="">Selecionar tipo</option>
				<option value="Instalação">Instalação</option>
				<option value="Manutenção">Manutenção</option>
				<option value="Retirada">Retirada</option>
				<option value="Upgrade">Upgrade</option>
				<option value="Troca de endereço">Troca de endereço</option>
			</select>

			<br>

			<label for="technic">Técnico:</label>
			<select name="technic" id="technic">
				<option value="">Selecionar tipo</option>
				<option value="Marcelo">Marcelo</option>
			</select>

			<fieldset>
				<legend>Data</legend>

				<label for="start_date">De:</label>
				<input type="date" name="start_date" id="start_date">

				<br>

				<label for="end_date">Até:</label>
				<input type="date" name="end_date" id="end_date">
			</fieldset>

			<button type="submit">Filtrar</button>
		</form>
	</aside>

	<main>
		<h1>Serviços</h1>

		<?php
			session_start();
			isset($_SESSION['success']) && renderSuccessBox($_SESSION['success']);
			isset($_SESSION['error']) && renderErrorBox($_SESSION['error']);
			session_destroy();
		?>

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
					<th scope="col">Opções</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($services as $service): ?>
				<tr>
					<td><?=$service[2]?></td>
					<td><?=$service[1]?></td>
					<td><?=$service[3]?></td>
					<td><?="$service[4] - $service[5]"?></td>
					<td><?="$service[6] - $service[7]"?></td>
					<td><?=$service[8]?></td>
					<td><?="$service[9] - $service[10]"?></td>
					<td>
						<a href=<?="/service/update?id=$service[0]"?>>Editar</a>
						<form method="post" action="service/delete">
							<input type="hidden" name="id" value=<?=$service[0]?>>
							<button type="submit">Apagar</button>
						</form>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</main>
</body>
</html>
