<?php

// get logged in users											//where latest_activity >= ...
$users = DBQuery::sql("SELECT id, name, latest_activity FROM user WHERE id='$_SESSION[user_id]'");

for ($i=0; $i < count($users); ++$i) { 
	echo $users[$i]["name"];
}

?>