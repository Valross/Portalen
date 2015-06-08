<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('');

if(isset($_GET['event_id']) && isset($_GET['user_id']) && isset($_GET['work_slot_id']))
{
	$event_id = $_GET['event_id'];
	$user_id = $_GET['user_id'];
	$work_slot_id = $_GET['work_slot_id'];

	$group_id = DBQuery::sql("SELECT group_id FROM work_slot
									WHERE id = '$work_slot_id'");

	if((checkIfMemberOfGroup($user_id, $group_id[0]['group_id']) || checkAdminAccess() <= 1) && ($user_id == $_SESSION['user_id'] || checkAdminAccess()))
	{
		DBQuery::sql("INSERT INTO user_work (work_slot_id, user_id, checked)
                                  VALUES ('$work_slot_id', '$user_id', '0')");
		?>
		<script>
			window.location = "?page=event&id=<?php echo $event_id; ?>";
		</script>
	<?php
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