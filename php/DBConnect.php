<?php

class DBConnect
{

	public static $mysql;

	public static function open()
	{
		// self::$mysql = mysqli_connect("localhost","trappandev","mae7aigooNgo","trappanBetaPortal") or die("Unable to connect to MySQL");
		self::$mysql = mysqli_connect("localhost","portalen","portalen","portalen") or die("Unable to connect to MySQL");
		mysqli_set_charset(self::$mysql,'utf8');
	}
	
	public static function close()
	{
		mysqli_close(self::$mysql);
	}

} 
?> 