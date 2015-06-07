<?php
include_once('php/DBQuery.php');

if(isset($_GET['da_note_id']) && isset($_GET['event_id']) && checkAdminAccess() <= 1)
{
	$da_note_id = $_GET['da_note_id'];
	$event_id = $_GET['event_id'];
	$user_id = $_SESSION['user_id'];

	$my_note = DBQuery::sql("SELECT id, name, start_time FROM event 
							WHERE event_type_id != 5 AND id IN
								(SELECT event_id FROM work_slot
								WHERE group_id = 7 AND id IN
									(SELECT work_slot_id FROM user_work
									WHERE user_id = '$user_id'))"); 

	if(count($my_note) > 0 || checkAdminAccess() < 1)
	{
		DBQuery::sql("DELETE FROM da_note
        					WHERE '$da_note_id' = id");
	}
	else
	{
		?>
			<script>
				window.location = "?page=book";
				alert("Antingen är det inte din lapp eller så har du inte tillräcklig access!")
			</script>
		<?php
	}
	?>
		<script>
			window.location = "?page=browseDANote";
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