<?php
include_once('php/DBQuery.php');

if(isset($_GET['event_id']) && checkAdminAccess() <= 1)
{
	$event_id = $_GET['event_id'];

	DBQuery::sql("DELETE FROM event
        					WHERE '$event_id' = id");

	?>
		<script>
			window.location = "?page=book";
		</script>
	<?php
}
else
{
	?>
		<script>
			window.location = "?page=book";
			alert("Något gick fel!")
		</script>
	<?php
}

?>