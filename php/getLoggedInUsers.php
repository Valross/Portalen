<?php

session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/Portalen/php/general.php');

// get logged in users (30 sec window)
$users = DBQuery::sql("SELECT id, name, last_name, latest_session 
					   FROM user 
					   WHERE latest_session > '".date('Y-m-d H:i:s',strtotime('-30 sec'))."'");

for ($i=0; $i < count($users); ++$i) { 
	$id = $users[$i]["id"];
	$name = $users[$i]["name"];

	echo "<p> <a href=\"?page=userProfile&id=$id\" class=\"list-group-item with-thumbnail\">" . loadAvatarFromUserAsNotification($id, 32) . $users[$i]["name"] ." " .$users[$i]["last_name"]. "</a></p>";
}


?>