<?php

// get logged in users
$users = DBQuery::sql("SELECT id, name, latest_activity FROM user WHERE latest_activity > '".date('Y-m-d',strtotime('-2 min'))." 00:00:00'");  //id='$_SESSION[user_id]'

for ($i=0; $i < count($users); ++$i) { 
	echo $users[$i]["name"];
}

?>