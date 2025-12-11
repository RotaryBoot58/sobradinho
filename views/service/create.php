<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/css/service/create.css">
	<title>Sobradinho | Criar serviço</title>
</head>
<body>
	<aside>
		<?php require component('nav.html', NO_EXT); ?>
		
		<?php
			session_start();
			isset($_SESSION['success']) && renderSuccessBox($_SESSION['success']);
			isset($_SESSION['error']) && renderErrorBox($_SESSION['error']);
			session_destroy();
		?>
	</aside>

	<main>
		<h1>Criar serviço</h1>
		
		<form method="POST" action="/service/create">
			<div>
				<label for="code">Código:</label>
				<input type="number" name="code" id="code" min="0" autocomplete="off" required>
			</div>

			<div>
				<label for="type">Tipo:</label>
				<select name="type" id="type" required>
					<option value="">Selecionar tipo</option>
					<option value="Instalação">Instalação</option>
					<option value="Manutenção">Manutenção</option>
					<option value="Retirada">Retirada</option>
					<option value="Upgrade">Upgrade</option>
					<option value="Troca de endereço">Troca de endereço</option>
				</select>
			</div>

			<div>
				<label for="technic">Técnico:</label>
				<select name="technic" id="technic" required>
					<option value="">Selecionar técnico</option>
					<option value="Marcelo">Marcelo</option>
					<option value="Rudnei">Rudnei</option>
				</select>
			</div>

			<fieldset>
				<legend>Equipamento</legend>

				<div>
					<label for="onu">Roteador utilizado:</label>
					<input type="text" name="onu" id="onu" autocomplete="off">
				</div>

				<div>
					<label for="onu_usage">Uso do roteador:</label>
					<select name="onu_usage" id="onu_usage">
						<option value="">Selecionar uso</option>
						<option value="Retirada">Retirada</option>
						<option value="Novo">Novo</option>
						<option value="Reutilizado">Reutilizado</option>
					</select>
				</div>

				<div>
					<label for="router">ONU utilizada:</label>
					<input type="text" name="router" id="router" autocomplete="off">
				</div>

				<div>
					<label for="router_usage">Uso da ONU:</label>
					<select name="router_usage" id="router_usage">
						<option value="">Selecionar uso</option>
						<option value="Retirada">Retirada</option>
						<option value="Novo">Novo</option>
						<option value="Reutilizado">Reutilizado</option>
					</select>
				</div>
			</fieldset>

			<div id="textarea">
				<label>Descrição</label>
				<textarea rows=10 autocomplete="off"></textarea>
			</div>

			<button type="submit">Criar</button>
		</form>
	</main>
</body>
</html>
