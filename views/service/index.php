<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/css/home.css">
	<title>Sobradinho | Serviços</title>
</head>
<body>
	<?php
		session_start();
		isset($_SESSION['success']) && renderSuccessBox($_SESSION['success']);
		isset($_SESSION['error']) && renderErrorBox($_SESSION['error']);
		session_destroy();
	?>
	<main>
		<h1>Serviços</h1>

		<h2>Filtros</h2>
		<form method="GET" action="/services">
			<label>
				Tipo:
				<select name="type">
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
				<select name="technic">
					<option value="">Selecionar tipo</option>
					<option value="Marcelo">Marcelo</option>
				</select>
			</label>

			<fieldset>
				<legend>Data</legend>
				
				<span>De</span>
				<input type="date" name="start_date">
				
				<span>Até</span>
				<input type="date" name="end_date" value=<?= date('Y-m-d'); ?>>
			</fieldset>

			<button type="submit">Filtrar</button>
		</form>
		
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
				<?php
					foreach($services as $service)
					{
						echo <<<HTML
							<tr>
								<td>$service[1]</td>
								<td>$service[2]</td>
								<td>$service[3]</td>
								<td>$service[4] - $service[5]</td>
								<td>$service[6] - $service[7]</td>
								<td>$service[8]</td>
								<td>$service[9] - $service[10]</td>
								<td>
									<a href="/service/update?id=$service[0]">Editar</a>

									<form method="post" action="service/delete">
										<input type="hidden" name="id" value="$service[0]">
										<button type="submit">Apagar</button>
									</form>
								</td>
							</tr>
						HTML;
					}
				?>
			</tbody>
		</table>
	</main>
</body>
</html>
