<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('');

if(isset($_GET['event_template_id']) && isset($_GET['work_slot_id']) && checkAdminAccess())
{
	$event_template_id = $_GET['event_template_id'];
	$work_slot_id = $_GET['work_slot_id'];

	DBQuery::sql("DELETE FROM event_template_group
        					WHERE '$work_slot_id' = id");

	?>
		<script>
			window.location = "?page=manageEventTemplate&id=<?php echo $event_template_id; ?>";
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