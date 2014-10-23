<?php

include_once('DBConnect.php');

class DBQuery
{			

	public static $lastId;

	public static function sql($sql)
	{
		DBConnect::open();
		$result = mysqli_query(DBConnect::$mysql,$sql);
		self::$lastId = mysqli_insert_id(DBConnect::$mysql);
		DBConnect::close();
		$rows = array();
		if(strtolower(substr($sql,0,6)) == 'select')
		{
			while($row = mysqli_fetch_array($result))
			{
				array_push($rows,$row);
			}
			return $rows;
		}
	}
	
	public static function safeString($word)
	{
		DBConnect::open();
		$safeWord = mysqli_real_escape_string(DBConnect::$mysql,$word);
		DBConnect::close();
		return $safeWord;
	}
}

?>