<?php

class Validator
{
	public array $errors;
	private array $rules;
	private array $data;
	private array $messages;

	public function __construct(array $data, array $rules)
	{
		$this->data = $data;
		$this->rules = $rules;
		$this->messages = require 'enums/validation_messages.php';
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

			$this->validateRules($field, $rules, $value);
		}

		return empty($this->errors);
	}

	private function validateRules(string $field, array $rules, mixed $value): void
	{
		foreach($rules as $rule)
		{
			$rule_parts = explode(':', $rule);
			$parameter = $rule_parts[1] ?? null;

			switch($rule_parts[0])
			{
				case 'required':
					empty($value) && $this->addError($field, $this->messages['required']);
					break;

				case 'text':
					preg_match("/^[a-zA-ZáÁàÀâÂãÃéÉêÊíÍóÓôÔõÕúÚçÇ\s',-_\".]+$/u", $value) || $this->addError($field, $this->messages['text']);
					break;

				case 'alpha_numerical':
					preg_match("/^[0-9a-zA-ZáÁàÀâÂãÃéÉêÊíÍóÓôÔõÕúÚçÇ\s',-_\".]+$/u", $value) || $this->addError($field, $this->messages['alpha_numerical']);
					break;

				case 'number':
					preg_match("/^\d+$/", $value) || $this->addError($field, $this->messages['number']);
					break;

				case 'min':
					strlen($value) < $parameter && $this->addError($field, "O campo deve conter ao menos {$parameter} caracteres");
					break;

				case 'max':
					strlen($value) > $parameter && $this->addError($field, "O campo deve conter no máximo {$parameter} caracteres");
					break;

				case 'size':
					strlen($value) !== $parameter && $this->addError($field, "O campo deve conter exatamente {$parameter} caracteres");
					break;

				case 'email':
					filter_var($value, FILTER_VALIDATE_EMAIL) || $this->addError($field, $this->messages['email']);
					break;

				case 'exists':
					if(empty($this->errors))
					{
						require_once module('model', MODEL);
						$model = new Model('services');

						$model->checkExistence($value) || $this->addError($field, $this->messages['exists']);
					}
					break;

				case 'in_array':
					$types = require_once "enums/{$parameter}.php";

					in_array($value, $types) || $this->addError($field, $this->messages['in_array']);
					break;

				case 'required_with':
					empty($this->data[$parameter]) && $this->addError($field, "O campo precisa que o campo $field esteja preenchido.");
					break;
			}
		}
	}

	private function addError(string $field, string $message)
	{
		$this->errors[$field][] = $message;
	}

	public function getErrors(?string $field = null): array
	{
		if($field)
		{
			return $this->errors[$field] ?? [];
		}

		return $this->errors;
	}
}
