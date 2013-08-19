<?php

db::$instance = new db();

class db {
	private static $host 		= "NULL";
	private static $user 		= "NULL";
	private static $password	= "NULL";
	private static $name 		= "NULL";
	public static $instance;

	public $conn;

	public function connect() {
		self::$instance->conn = new mysqli(self::$host, self::$user, self::$password, self::$name);
	}

	public static function query($query) {
		$args = func_get_args();
		if(count($args)>1) {
			array_shift($args); //remove first element, query
			$query = vsprintf($query, $args);
		}
		return self::$instance->conn->query($query);
	}
}

?>
