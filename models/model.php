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

	public function index(array $fields = ['*'], array $parameters = []): array|false
	{
		$fields = implode(', ', $fields);
		$sql = "SELECT {$fields} FROM {$this->table}";
		
		$sql_parameters = '';
		foreach($parameters as $field => $value)
		{
			switch($field)
			{
				case 'start_date':
					$sql_parameters .= " creation_date >= :$field AND";
					break;

				case 'end_date':
					$sql_parameters .= " creation_date <= :$field AND";
					break;

				default:
					$sql_parameters .= " $field = :$field AND";
			}
		}

		if(!empty($sql_parameters))
		{
			$sql_parameters = rtrim($sql_parameters, 'AND');
			$sql .= " WHERE {$sql_parameters}";
		}

		try
		{
			$statement = $this->database->prepare($sql);
			$statement->execute($parameters);
		}
		catch(PDOexception $exception)
		{
			$this->error = $exception->getMessage();
			return false;
		}

		return $statement->fetchAll();
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
			$statement = $this->database->prepare("SELECT {$fields} FROM {$this->table} WHERE id = ?");
			$statement->execute([$id]);
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
}
