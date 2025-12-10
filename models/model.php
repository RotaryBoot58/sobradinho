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

		if(empty($parameters))
		{
			$query = $this->query($sql);
			return $query ? $query->fetchAll() : false;
		}

		$bindings = '';
		$first = true;
		foreach($parameters as $key => $value)
		{
			$first || $bindings .= ' AND ';

			switch($key)
			{
				case 'start_date':
					$bindings .= "creation_date >= :$key";
					break;

				case 'end_date':
					$bindings .= "creation_date <= :$key";
					break;

				default:
					$bindings .= "$key = :$key";
			}

			$first = false;
		}

		$sql .= " WHERE {$bindings}";

		$query = $this->query($sql, $parameters);

		return $query ? $query->fetchAll() : false;
	}

	public function create(array $data): bool
	{
		$data['creation_date'] = date('Y-m-d');
		$data['creation_time'] = date('H:i');
		$data['update_date'] = date('Y-m-d');
		$data['update_time'] = date('H:i');

		$first = true;
		$columns = '';
		$fields = '';
		foreach($data as $key => $value)
		{
			if(!$first)
			{
				$columns .= ', ';
				$fields .= ', ';
			}

			$columns .= "$key";
			$fields .= ":$key";

			$first = false;
		}

		$sql = "INSERT INTO {$this->table} ($columns) VALUES ($fields)";
		$query = $this->query($sql, $data);

		return $query ? true : false;
	}

	public function read(int $id, array $fields = ['*']): array|false
	{
		$fields = implode(', ', $fields);

		$query = $this->query("SELECT {$fields} FROM {$this->table} WHERE id = ?", [$id]);

		return $query ? $query->fetch() : false;
	}

	public function update(array $data): bool
	{
		$data['update_date'] = date('Y-m-d');
		$data['update_time'] = date('H:i');

		$first = true;
		$fields = '';
		foreach($data as $field => $value)
		{
			if($field === 'id')
			{
				continue;
			}

			$first || $fields .= ', ';

			$fields .= "$field = :$field";
			$first = false;
		}

		$query = $this->query("UPDATE {$this->table} SET {$fields} WHERE id = :id", $data);

		return $query ? true : false;
	}

	public function delete(int $id): bool
	{
		$query = $this->query("DELETE FROM {$this->table} WHERE id = :id", [$id]);

		if($query->rowCount() === 0)
		{
			$this->error = 'Nada foi apagado. O item desejado não existe.';
			return false;
		}

		return true;
	}

	public function query(string $query, array $parameters = []): PDOStatement|false
	{
		try
		{
			$statement = $this->database->prepare($query);
			$statement->execute($parameters);
		}
		catch(PDOexception $exception)
		{
			$this->error = $exception->getMessage();
			return false;
		}

		return $statement;
	}
}
