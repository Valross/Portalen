<?php

function loadAllTools()
{
	if(checkAdminAccess())
	{
		echo '<a href="?page=wages" class="list-group-item">Löner</a>';
		echo '<a href="?page=manageGroup" class="list-group-item">Hantera grupp</a>';
		echo '<a href="?page=createGroup" class="list-group-item">Skapa grupp</a>';
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