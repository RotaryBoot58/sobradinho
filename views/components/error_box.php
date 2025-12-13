<h2>Erro</h2>
<ul id="error">
	<?php
	$field_labels = [
		'numero' => 'Número',
		'rua' => 'Rua',
		'bairro' => 'Bairro',
		'cidade' => 'Cidade',
		'cep' => 'CEP',
		'code' => 'Código',
		'technic' => 'Técnico',
		'onu_usage' => 'Uso de onu',
		'database' => 'Banco de dados'
	];

	foreach($item as $field => $messages)
	{
		if(!is_array($messages))
		{
			$label = $field_labels[$field] ?? $field; 
			$formatted_field = htmlspecialchars($label);
			$formatted_message = htmlspecialchars($message);
			
			echo <<<HTML
				<li>
					<strong>$formatted_field</strong>: $formatted_message
				</li>
			HTML;
		}
	
		foreach($messages as $message)
		{
			$label = $field_labels[$field] ?? $field; 
			$formatted_field = htmlspecialchars($label);
			$formatted_message = htmlspecialchars($message);
			
			echo <<<HTML
				<li>
					<strong>$formatted_field</strong>: $formatted_message
				</li>
			HTML;
		}
	}
	?>
</ul>