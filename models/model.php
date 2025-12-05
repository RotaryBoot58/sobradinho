<?php

class Model
{
	private string $table;
	private PDO $database;
	public string $error;

	public function __construct(string $table)
	{
		$this->table = $table;
		$this->database = new PDO('sqlite:../database.sqlite');
		$this->database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_NUM);
	}

	public function index(array $fields = ['*']): array
	{
		$fields = implode(', ', $fields);
		
		return $this->database->query("SELECT {$fields} FROM {$this->table}")->fetchAll();
	}

	public function create(array $data): bool
	{
		$data['creation_date'] = date('Y-m-d');
		$data['creation_time'] = date('H:i');
		$data['update_date'] = date('Y-m-d');
		$data['update_time'] = date('H:i');

		$first = true;
		foreach($data as $field => $value)
		{
			$first || $fields .= ', ';

			$fields .= "$field = :$field";
			$first = false;
		}

		try
		{
			$statement = $this->database->prepare("INSERT INTO {$this->table} ($columns) VALUES ($placeholders)");
			$statement->execute($data);
		}
		catch(PDOexception $exception)
		{
			$this->error = $exception->getMessage();
			return false;
		}

		return true;
	}

	public function read(int $id, array $fields = ['*']): array|false
	{
		$fields = implode(', ', $fields);

		try
		{
			$statement = $database->prepare("SELECT {$fields} FROM {$table} WHERE id = ?");
			$statement->execute($id);
		}
		catch(PDOexception $exception)
		{
			$this->error = $exception->getMessage();
			return false;
		}
		
		return $statement->fetch();
	}

	public function update(array $data): bool
	{
		$data['update_date'] = date('Y-m-d');
		$data['update_time'] = date('H:i');
		
		$first = true;
		foreach($data as $field => $value)
		{
			if($field === 'id') continue;
			
			$first || $fields .= ', ';

			$fields .= "$field = :$field";
			$first = false;
		}

		try
		{
			$statement = $this->database->prepare("UPDATE {$this->table} SET {$fields} WHERE id = :id");
			$statement->execute($data);
		}
		catch(PDOexception $exception)
		{
			$this->error = $exception->getMessage();
			return false;
		}
		
		return true;
	}

	public function delete(int $id): bool
	{
		try
		{
			$statement = $this->database->query("DELETE FROM {$this->table} WHERE id = {$id}");
		}
		catch(PDOexception $exception)
		{
			$this->error = $exception->getMessage();
			return false;
		}

		if($statement->rowCount() === 0)
		{
			$this->error = 'Nada foi apagado. O item desejado não existe.';
			return false;
		}

		return true;
	}

	public function query(string $query, array $parameters = [])
	{
		$statement = $this->database->prepare($query);
		$statement->execute($parameters);

		return $statement;
	}
}
