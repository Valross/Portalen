<?php
loadTitleForBrowser('Statistik');

function loadAllTools()
{
	echo '<a href="?page=statsList" class="list-group-item">Statistiklista</a>';
	echo '<a href="?page=statsUser" class="list-group-item">Din statistik</a>';
	if(checkAdminAccess())
	{
		
	}
}

?>