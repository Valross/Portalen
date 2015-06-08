<?php
loadTitleForBrowser('DC-verktyg');

function loadAllTools()
{
	if(checkAdminAccess() <= 1)
	{
		echo '<a href="?page=wages" class="list-group-item"><span class="fa fa-money fa-fw fa-lg"></span>Löner</a>';
		echo '<a href="?page=createGroup" class="list-group-item"><span class="fa fa-group fa-fw fa-lg"></span>Skapa grupp</a>';
		echo '<a href="?page=manageGroup" class="list-group-item"><span class="fa fa-group fa-fw fa-lg"></span>Hantera grupp</a>';
		echo '<a href="?page=manageGroupLeader" class="list-group-item"><span class="fa fa-trophy fa-fw fa-lg"></span>Hantera gruppledare</a>';
		echo '<a href="?page=manageAccess" class="list-group-item"><span class="fa fa-wheelchair fa-fw fa-lg"></span>Hantera Access</a>';
	}
	else
	{
		?>
			<script>
				window.location = "?page=start";
				alert("Sluta försöka hacka sidan!")
			</script>
		<?php
	}	
}

?>