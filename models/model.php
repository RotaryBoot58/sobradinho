<?php

require_once module('database');

abstract class Model
{
	private Database $database;
	private string $table_name;

	public function __construct(string $table_name)
	{
		$this->database = new Database();
		$this->table_name = $table_name;
	}

	public function index(): array
	{
		return $this->database->query("SELECT * FROM {$this->table_name}")->fetchAll();
	}

	abstract public function create(array $data): bool;
	abstract public function read(int $id): array;
	abstract public function update(int $id): bool;
	abstract public function delete(int $id): bool;

	public function checkExistence(int $id): bool
	{
		$query = "SELECT EXISTS(SELECT 1 FROM {$this->table_name} WHERE id = :id)";

		$item = $this->database->query($query, ['id' => $id])->fetch();
		$item = array_values($item)[0];

		return $item > 0 ? true : false;
	}
}
