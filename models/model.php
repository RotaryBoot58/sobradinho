<?php

class Model
{
	private string $table;
	private PDO $database;
	private string $error;

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
		$fields = array_keys($data);

		$columns = implode(', ', $fields);
		$placeholders = ':' . implode(', :', $fields);
		
		$sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";

		try
		{
			$statement = $this->database->prepare($sql);
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

	public function update()
	{}

	public function delete(int $id): bool
	{
		try
		{
			$statement = $this->database->prepare("DELETE FROM {$this->table} WHERE id = ?");
			$statement->execute([$id]);
		}
		catch(PDOexception $exception)
		{
			$this->error = $exception->getMessage();
			return false;
		}

		if($statement->rowCount() === 0)
		{
			$this->error = 'Nothing to delete.';
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
tu }
