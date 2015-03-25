<?php
loadTitleForBrowser('Personallista');

function loadList()
{
	$users = DBQuery::sql("SELECT name, last_name, id, mail FROM user 
							ORDER BY id");
	$howMany = count($users);
	for($i = 0; $i < $howMany; ++$i)
	{
		echo $users[$i]['mail'];
		echo '; ';
	}
}

?>