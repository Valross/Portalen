<?php
loadTitleForBrowser('Statistik');

function loadAllTools()
{
	echo '<a href="?page=statsList" class="list-group-item"><span class="fa fa-list fa-fw fa-lg"></span>Statistiklista</a>';
	echo '<a href="?page=statsUser" class="list-group-item"><span class="fa fa-user fa-fw fa-lg"></span>Din statistik</a>';
}

?>