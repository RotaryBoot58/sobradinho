<h2>Erro</h2>
<ul id="error">
	<?php
	$field_labels = [
		'code' => 'Código',
		'technic' => 'Técnico',
		'onu_usage' => 'Uso de onu'
	];

	foreach($item as $field => $messages)
	{
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