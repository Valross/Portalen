<?php
include_once('php/DBQuery.php');

if(isset($_GET['period_id']) && checkAdminAccess() <= 1)
{
	$period_id = $_GET['period_id'];

	DBQuery::sql("DELETE FROM period
        					WHERE '$period_id' = id");

	?>
		<script>
			window.location = "?page=managePeriod";
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