<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('');

if(isset($_GET['event_id']) && isset($_GET['user_id']) && isset($_GET['work_slot_id']))
{
	$event_id = $_GET['event_id'];
	$user_id = $_GET['user_id'];
	$work_slot_id = $_GET['work_slot_id'];

	$localUserBookedThisSlot = DBQuery::sql("SELECT work_slot_id, user_id FROM user_work 
						WHERE user_id = '$user_id' AND work_slot_id = '$work_slot_id'");

	$start_time_event = DBQuery::sql("SELECT id, start_time FROM work_slot 
						WHERE id = '$work_slot_id'");

	$five_days = new DateTime($start_time_event[0]['start_time']);
	date_sub($five_days, date_interval_create_from_date_string('5 days'));
	$today = new DateTime;

	if((count($localUserBookedThisSlot) > 0 && $five_days > $today) || checkAdminAccess() <= 1)
	{
		DBQuery::sql("DELETE FROM user_work
        					WHERE '$work_slot_id' = work_slot_id");

		if(checkAdminAccess() == 4)
		{
			$event = DBQuery::sql("SELECT event_type_id FROM event 
							WHERE id = '$event_id'");

			if($event[0]['event_type_id'] != 5)
			{
				$group_leader = DBQuery::sql("SELECT user_id FROM work_group_leaders
								WHERE work_group_id IN
									(SELECT group_id FROM work_slot
									WHERE id = '$work_slot_id')");

				$info = $work_slot_id.' '.$user_id;

				for($i = 0; $i < count($group_leader); ++$i)
					notify($group_leader[$i]['user_id'], 2, $info);
			}
		}
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