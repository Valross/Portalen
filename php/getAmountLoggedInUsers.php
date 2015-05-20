<?php

session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/Portalen/php/general.php');

// get logged in users (30 sec window)
$users = DBQuery::sql("SELECT id, name, last_name, latest_session 
					   FROM user 
					   WHERE latest_session > '".date('Y-m-d H:i:s',strtotime('-30 sec'))."'");
echo count($users);

?>