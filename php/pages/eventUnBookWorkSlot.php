<?php
include_once('php/DBQuery.php');

if(isset($_GET['event_id']) && isset($_GET['user_id']) && isset($_GET['work_slot_id']))
{
	$event_id = $_GET['event_id'];
	$user_id = $_GET['user_id'];
	$work_slot_id = $_GET['work_slot_id'];

	DBQuery::sql("DELETE FROM user_work
        					WHERE '$work_slot_id' = work_slot_id");

	?>
		<script>
			window.location = "?page=event&id=<?php echo $event_id; ?>";
			//alert("Uppbokad!")
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