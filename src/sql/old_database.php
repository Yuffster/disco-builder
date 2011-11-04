<?php

class Database {

	private static $connection;
	
	private static $prefix = '';

	private static function connect() {
		$server   = self::$config['server'];
		$user     = self::$config['user'];
		$password = self::$config['password'];
		$database = self::$config['database'];
		if (!self::$connection) {
			self::$connection = mysql_connect($server, $user, $password);
			mysql_select_db($database);
		} return self::$connection;
	}

	private static function doQuery($sql) {
		$link = self::connect();
		if (!$link) { throw new Exception("Couldn't connect to database."); }
		$result = mysql_query($sql);
		if (!$result) {
			throw new Exception("There was an error executing the query.");
		}
	}

	public static function config($arr) {
		self::$config = $arr;
		self::$prefix = $arr['table_prefix'];
	}

	public static function insert($table, $properties) {
		
		$sql  = "INSERT INTO $table ";
		$sql .= "('".array_keys($properties).join("','")."')";
		$sql .= " VALUES ";
		
		$escaped = Array();
		foreach(array_values($properties) as $v) {
			$escaped[] = mysql_real_escape_string($v);
		}
		$sql .= "('".$escaped.join("','")."')";

	}

}

?>
