<?php

class Database
{
	private PDO $connection;
	private string $path = 'sqlite:'.__DIR__.'/database.sqlite';
	private array $options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

	public function __construct()
	{
		try
		{
			$this->connection = new PDO($this->path, '', '', $this->options);
		}
		catch(PDOexception $error)
		{
			die('Error' . $error->getMessage());
		}
	}

	public function query(string $query, array $parameters = [])
	{
		$statement = $this->connection->prepare($query);
		$statement->execute($parameters);

		return $statement;
	}

	public function drop(string $table)
	{
		$this->query("DROP TABLE {$table}");
	}
}
