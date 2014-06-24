<?php
// Get new instance of PDO object
$dbc = new PDO('mysql:host=127.0.0.1;dbname=todo_db', 'mallory', 'malmal');

//Tell PDO to throw exceptions on error
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo $dbc->getAttribute(PDO::ATTR_CONNECTION_STATUS) . "\n";

$query = 'CREATE TABLE todo_list (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT, 
	todo_item VARCHAR(240) NOT NULL,
	PRIMARY KEY (id)
)';

$dbc->exec($query);
