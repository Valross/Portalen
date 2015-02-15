<?php
include_once('php/DBQuery.php');

function loadEventName()
{
	$event_id = $_GET['id'];
	$event_name = DBQuery::sql("SELECT name FROM event
							WHERE id = '$event_id'");

	if(count($event_name) > 0)
		echo $event_name[0]['name'];
	else
		echo "Nu har du kommit lite fel!";
}


function loadEventDescription()
{
	$event_id = $_GET['id'];
	$event_info = DBQuery::sql("SELECT start_time, end_time FROM event 
						WHERE id = '$event_id'");

	if(count($event_info) > 0)
	{
		echo "<p>Start: ".$event_info[0]['start_time']."</p>";
		echo "<p>Slut: ".$event_info[0]['end_time']."</p>";
	}

}

function loadWorkSlots()
{
	$event_id = $_GET['id'];
	$slots = DBQuery::sql("SELECT id, points, event_id, start_time, end_time, group_id FROM work_slot 
						WHERE event_id = '$event_id'
						ORDER BY id");

	$bookedSlots = DBQuery::sql("SELECT work_slot_id, user_id FROM user_work 
						WHERE work_slot_id IN
						(SELECT id FROM work_slot 
						WHERE event_id = '$event_id')
						ORDER BY work_slot_id");

	$bookedSlotss = DBQuery::sql("SELECT work_slot_id, user_id FROM user_work
						INNER JOIN work_slot ON user_work.work_slot_id = work_slot.id
						ORDER BY work_slot_id");
	// echo count($slots);
	for($i = 0; $i < count($slots); ++$i)
	{
		?>
			<p><?php echo $slots[$i]['id']." | GROUP_ID: ".$slots[$i]['group_id']; ?>
		<?php
		echo "BOOKED: ".count($bookedSlots);
		if(count($bookedSlots) > $i)
		{
			echo "USER_ID: ".$bookedSlots[$i]['user_id'];
			echo loadAvatarFromUser(($bookedSlots[$i]['user_id'])) 
			?>
			</p>
			<?php
		}
	}
}


function loadAvatarFromUser($user_id)
{
	$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$user_id' AND avatar IS NOT NULL");
	if(count($results) == 0)
	{
		return '<img src="img/avatars/no_face_small.png" width="20" height="20" class="page-header-img">';
	}
	return '<img src="img/avatars/'.$results[0]['avatar'].'" width="20" height="20" class="page-header-img">';

}

?>