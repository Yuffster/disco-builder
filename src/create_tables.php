<?php

$p = $_POST;

$required = Array('server', 'user', 'password', 'database');
foreach ($required as $v) {
	if (!$p[$v]) {
		throw new Exception(
			"We don't know how to connect to your database. ".
			"All fields are required."
		);
	}
}

$link = mysql_connect($p['host'], $p['user'], $p['password']);

if (!$link) {
	throw new Exception(
		"Couldn't connect to database. ".
		"Please double-check your database information. "
	);
}

//Save the configuration file.
$config = file_get_contents('src/config.example.php');
foreach ($p as $k=>$v) $config = str_replace("<$k>", $v, $config);
file_put_contents('src/config.php', $config);

include("app.php");

$roomDef = Array(

	'id'=>'int(11) NOT NULL AUTO_INCREMENT',
	'area_id'=>'int(11) NOT NULL',

	'x'=>'int(11) NOT NULL',
	'y'=>'int(11) NOT NULL',
	'z'=>'int(11) NOT NULL',

	'short' => 'text',
	'long'  => 'text',
	'type'  => 'int(11)',

	'exit_n'  => 'int(11) NOT NULL DEFAULT 0',
	'exit_s'  => 'int(11) NOT NULL DEFAULT 0',
	'exit_w'  => 'int(11) NOT NULL DEFAULT 0',
	'exit_e'  => 'int(11) NOT NULL DEFAULT 0',
	'exit_ne' => 'int(11) NOT NULL DEFAULT 0',
	'exit_nw' => 'int(11) NOT NULL DEFAULT 0',
	'exit_se' => 'int(11) NOT NULL DEFAULT 0',
	'exit_sw' => 'int(11) NOT NULL DEFAULT 0',
	'exit_d'  => 'int(11) NOT NULL DEFAULT 0',
	'exit_u'  => 'int(11) NOT NULL DEFAULT 0',

);

$areaDef = Array(

	'id'=>'int(11) NOT NULL AUTO_INCREMENT',
	'name'=>'VARCHAR(150)',
	'size_x'=>'INT(11)',
	'size_y'=>'INT(11)'

);

$tables = Array('room'=>$roomDef, 'area'=>$areaDef);

$db = Database::init();

foreach ($tables as $name=>$data) {
	try {
		$db->createTable($name, $data);
	} catch (DatabaseException $e) {
		if (strpos($e->getMessage(), 'already exists')) {
			throw new Exception(
				"The tables we need to create already exist &mdash; ".
				"have you already installed this application? ".
				"To reinstall, delete the tables $p[prefix]room ".
				"and $p[prefix]area, or use another table prefix."
			);
		} else {
			throw new Exception($e->getMessage());
		}
	}
}

$db->doQuery("ALTER TABLE ".$p['prefix']."room ADD UNIQUE KEY(`area_id`, `x`, `y`, `z`)");
?>
