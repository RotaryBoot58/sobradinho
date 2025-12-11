<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/css/home.css">
	<title>Sobradinho | Início</title>
</head>
<body>
	<aside>
		<?php require component('nav.html', NO_EXT); ?>
	</aside>
	
	<main>
		<h1>Resumo de equipamentos</h1>

		<table>
			<thead>
				<tr>
					<th scope="col"></th>
					<th scope="col">Novos</th>
					<th scope="col">Utilizados</th>
					<th scope="col">Reutilizados</th>
				</tr>
			</thead>

			<tbody>
				<tr>
					<th scope="row">Roteadores</th>
					<td><?= $router_summary[0] ?></td>
					<td><?= $router_summary[1] ?></td>
					<td><?= $router_summary[2] ?></td>
				</tr>
				<tr>
					<th scope="row">ONUs</th>
					<td><?= $onu_summary[0] ?></td>
					<td><?= $onu_summary[1] ?></td>
					<td><?= $onu_summary[2] ?></td>
				</tr>
			</tbody>
		</table>
	</main>
</body>
</html>
