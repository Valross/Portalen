<?php
include_once('php/DBQuery.php');

if(isset($_GET['access_id']) && checkAdminAccess() == -1)
{
	$access_id = $_GET['access_id'];

	DBQuery::sql("DELETE FROM access
        					WHERE '$access_id' = id");

	?>
		<script>
			window.location = "?page=manageAccess";
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