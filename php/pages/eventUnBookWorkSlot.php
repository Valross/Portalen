<?php
include_once('php/DBQuery.php');

if(isset($_GET['event_id']) && isset($_GET['user_id']) && isset($_GET['work_slot_id']))
{
	$event_id = $_GET['event_id'];
	$user_id = $_GET['user_id'];
	$work_slot_id = $_GET['work_slot_id'];

	$localUserBookedThisSlot = DBQuery::sql("SELECT work_slot_id, user_id FROM user_work 
						WHERE user_id = '$user_id' AND work_slot_id = '$work_slot_id'");

	if(count($localUserBookedThisSlot) > 0 || checkAdminAccess())
	{
		DBQuery::sql("DELETE FROM user_work
        					WHERE '$work_slot_id' = work_slot_id");
	}
	else
	{
		?>
		<script>
			window.location = "?page=event&id=<?php echo $event_id; ?>";
			alert("Sluta försöka hacka sidan!")
		</script>
	<?php
	}

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