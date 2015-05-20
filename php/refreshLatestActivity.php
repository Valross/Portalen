<?php
	session_start();
	include_once($_SERVER['DOCUMENT_ROOT'] . '/Portalen/php/general.php');

	DBQuery::sql("UPDATE user 
				  SET latest_session = '" . date("Y-m-d H:i:s") . "'
			  	  WHERE id='$_SESSION[user_id]'");

?>