<?php
include_once('php/DBQuery.php');

if(isset($_GET['group_id']) && checkAdminAccess() == -1)
{
	$group_id = $_GET['group_id'];

	DBQuery::sql("DELETE FROM work_group
        					WHERE '$group_id' = id");

	?>
		<script>
			window.location = "?page=manageGroup";
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