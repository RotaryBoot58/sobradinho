<?php

try
{
	$database = new PDO('sqlite:database.sqlite');
	$database->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
}
catch(PDOexception $error)
{
	exit('Error: ' . $error->getMessage());
}
