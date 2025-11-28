<?php

require_once model('model');

class Service extends Model
{
	public function __construct()
	{
		parent::__construct('services');
	}

	public function create(array $data): bool
	{
		return $this->database->execute(
			"INSERT INTO {$this->table_name}
			(type, code, technic, onu, onu_usage, router, router_usage, cable, creation_date, creation_time, update_date, update_time)
			VALUES
			(:type, :code, :technic, :onu, :onu_usage, :router, :router_usage, :cable, :creation_date, :creation_time, :update_date, :update_time)",
			[
				'type' => $data['type'],
				'code' => $data['code'],
				'technic' => $data['technic'],
				'onu' => $data['onu'],
				'onu_usage' => $data['onu_usage'],
				'router' => $data['router'],
				'router_usage' => $data['router_usage'],
				'cable' => $data['cable'],
				'creation_date' => $data['creation_date'],
				'creation_time' => $data['creation_time'],
				'update_date' => $data['update_date'],
				'update_time' => $data['update_time']
			]
		);
	}

	public function migrate()
	{
		$this->database->query("
			CREATE TABLE {$this->table_name}
			(
				id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
				type TEXT,
				code INTEGER,
				technic TEXT,
				onu TEXT,
				onu_usage TEXT,
				router TEXT,
				router_usage TEXT,
				cable INTEGER,
				creation_date TEXT NOT NULL,
				creation_time TEXT NOT NULL,
				update_date TEXT NOT NULL,
				update_time TEXT NOT NULL
			);
		");
	}
}
