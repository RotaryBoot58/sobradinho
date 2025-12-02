<?php

require_once module('database');

class Validator
{
	public array $errors;
	private array $rules;
	private array $data;

	public function __construct(array $data, array $rules)
	{
		$this->data = $data;
		$this->rules = $rules;
	}

	public function validate(): bool
	{
		foreach($this->rules as $field => $rules)
		{
			$value = $this->data[$field] ?? null;

			if($rules[0] !== 'required' && empty($value))
			{
				continue;
			}

			foreach($rules as $rule)
			{
				$rule_parts = explode(':', $rule); 
				$rule_name = $rule_parts[0];
				$rule_parameter = $rule_parts[1] ?? null;

				switch($rule_name)
				{
					case 'required':
						if($value === NULL || empty($value))
						{
							$this->addError($field, "O campo é obrigatório");
						}
						break;
						
					case 'text':
						if(!preg_match("/^[a-zA-ZáÁàÀâÂãÃéÉêÊíÍóÓôÔõÕúÚçÇ\s]+$/u", $value))
						{
							$this->addError($field, "O campo não deve conter números ou caracteres especiais");
						}
						break;

					case 'alpha_numerical':
						if(!ctype_alnum($value))
						{
							$this->addError($field, 'O campo só deve conter números e letras');
						}
						break;

					case 'number':
						if(!ctype_digit($value))
						{
							$this->addError($field, 'O campo só deve conter números');
						}
						break;

					case 'min':
						if(!strlen($value) >= $rule_parameter)
						{
							$this->addError($field, "O campo deve conter ao menos {$rule_parameter} caracteres");
						}
						break;

					case 'max':
						if(!strlen($value) <= $rule_parameter)
						{
							$this->addError($field, "O campo deve conter no máximo {$rule_parameter} caracteres");
						}
						break;

					case 'size':
						if(!strlen($value) === $rule_parameter)
						{
							$this->addError($field, "O campo deve conter exatamente {$rule_parameter} caracteres");
						}
						break;

					case 'email':
						if(!filter_var($value, FILTER_VALIDATE_EMAIL))
						{
							$this->addError($field, 'O campo deve ser um email válido');
						}
						break;

					case 'exists':
						if(empty($this->errors))
						{
							$this->checkExistence($value, $rule_parameter, $field);
						}
						break;

					case 'in_array':
						$list = require_once module("enums/service-type");
						if(!in_array($value, $list))
						{
							$this->addError($field, 'O campo não tem um valor válido');
						}
						break;
				}
			}
		}

		return empty($this->errors);
	}

	private function checkExistence(mixed $value, string $rule_parameter, string $field)
	{
		require_once model('model');

		if(!$model->checkExistence($value))
		{
			$this->addError($field, "O item não existe no banco de dados");
		}
	}

	public function addError(string $field, string $message)
	{
		$this->errors[$field][] = $message;
	}

	public function getErrors(string $field = null): array
	{
		if($field)
		{
			return $this->errors[$field] ?? [];
		}

		return $this->errors;
	}
}
