<?php

session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/Portalen/php/general.php');

// get logged in users (2 min window)
$users = DBQuery::sql("SELECT id, name, latest_session 
					   FROM user 
					   WHERE latest_session > '".date('Y-m-d H:i:s',strtotime('-2 min'))."'");

for ($i=0; $i < count($users); ++$i) { 
	$id = $users[$i]["id"];
	$name = $users[$i]["name"];

	echo "<p> <a href=\"?page=userProfile&id=$id\">" . loadAvatarFromUser($id, 32) . $users[$i]["name"] . "</a></p>";
}


?>