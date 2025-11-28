<?php

require_once module('database');

abstract class Model
{
	protected Database $database;
	protected string $table_name;

	abstract public function create(array $data): bool;

	public function __construct(string $table_name)
	{
		$this->database = new Database();
		$this->table_name = $table_name;
	}

	public function index(array $fields = ['*']): array
	{
		$fields = implode(', ', $fields);
		return $this->database->query("SELECT {$fields} FROM {$this->table_name}")->fetchAll();
	}

	public function query(array $fields = ['*']): array
	{
		$fields = implode(', ', $fields);
		return $this->database->query("SELECT {$fields} FROM {$this->table_name}")->fetch();
	}

	public function update(int $id, array $data)
	{
		$fields = [];
		$values = [];
		foreach($data as $key => $value)
		{
			$fields[] = "$key = :$key";
			$values[$key] = $value;
		}
	
		$values['id'] = $id;
		$fields = implode(', ',$fields);

		$this->database->execute("UPDATE {$this->table_name} SET {$fields} WHERE id = :id", $values);
	}

	public function read(array $fields = ['*'], int $id): array|false
	{
		$fields = implode(', ', $fields);
		return $this->database->query("SELECT {$fields} FROM {$this->table_name} WHERE id = :id", ['id' => $id])->fetch();
	}

	public function delete(int $id): bool
	{
		return $this->database->execute("DELETE FROM {$this->table_name} WHERE id = :id", ['id' => $id]);
	}

	public function checkExistence(int $id): bool
	{
		$query = "SELECT EXISTS(SELECT 1 FROM {$this->table_name} WHERE id = :id)";

		$item = $this->database->query($query, ['id' => $id])->fetch();
		$item = array_values($item)[0];

		return $item > 0 ? true : false;
	}
}
