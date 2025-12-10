<!doctype html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/css/service/create.css">
	<title>Sobradinho | Criar serviço</title>
</head>
<body>
	<main>
		<h1>Criar serviço</h1>
		
		<form method="POST" action="/service/create">
			<fieldset>
				<legend>Detalhes</legend>
				
				<label>
					Código
					<input type="number" name="code" autocomplete="off" required>
				</label>

				<label>
					Tipo
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
					Técnico
					<input type="text" name="technic" autocomplete="off" required>
				</label>
			</fieldset>

			<h2>Equipamento</h2>
			<fieldset>
				<legend>ONU</legend>

				<label>
					Modelo
					<input type="text" name="onu" autocomplete="off">
				</label>

				<label>
					Uso
					<select name="onu_usage">
						<option value="">Selecionar uso</option>
						<option value="Retirada">Retirada</option>
						<option value="Novo">Novo</option>
						<option value="Reutilizado">Reutilizado</option>
					</select>
				</label>
			</fieldset>

			<fieldset>
				<legend>Roteador</legend>

				<label>
					Modelo
					<input type="text" name="router" autocomplete="off">
				</label>

				<label>
					Uso
					<select name="router_usage">
						<option value="">Selecionar uso</option>
						<option value="Retirada">Retirada</option>
						<option value="Novo">Novo</option>
						<option value="Reutilizado">Reutilizado</option>
					</select>
				</label>
			</fieldset>

			<button type="submit">Criar</button>
		</form>

		<section id="error-box">
			<?php
				session_start();
				isset($_SESSION['success']) && renderSuccessBox($_SESSION['success']);
				isset($_SESSION['error']) && renderErrorBox($_SESSION['error']);
				session_destroy();
			?>
		</section>
	</main>
</body>
</html>
