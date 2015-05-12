<?php

// get logged in users
$users = DBQuery::sql("SELECT id, name, latest_session 
					   FROM user 
					   WHERE latest_session > '".date('Y-m-d H:i:s',strtotime('-2 min'))."'");

// echo date('Y-m-d',strtotime('-2 min'));

for ($i=0; $i < count($users); ++$i) { 
	echo $users[$i]["name"];
}

?>