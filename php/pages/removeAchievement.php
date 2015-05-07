<?php
include_once('php/DBQuery.php');

if(isset($_GET['achievement_id']) && checkAdminAccess() == -1)
{
	$achievement_id = $_GET['achievement_id'];

	DBQuery::sql("DELETE FROM achievement
        					WHERE '$achievement_id' = id");

	?>
		<script>
			window.location = "?page=createAchievement";
			//alert("Uppbokad!")
		</script>
	<?php
}
else
{
	?>
		<script>
			window.location = "?page=start";
			alert("Något gick fel!")
		</script>
	<?php
}

?>