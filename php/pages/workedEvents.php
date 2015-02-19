<?php

function loadStats()
{
	$user_id = $_SESSION['user_id'];

	$events = "SELECT id, name, start_time FROM event
								WHERE id IN
									(SELECT event_id FROM work_slot
									WHERE id IN
										(SELECT work_slot_id FROM user_work
										WHERE user_id = '$user_id' AND checked = 1))";

	$start = '';
	$end = '';

	if(isset($_POST['submit']))
	{
		if($_POST['start'] != '') 
		{
			$start = $_POST['start'];
			// $start = $start->format('Y-m-d');
			$events = $events." AND start_time > '$start'";
		}
		if($_POST['end'] != '') 
		{
			$end = $_POST['end'];
			// $end = $end->format('Y-m-d');
			$events = $events." AND end_time < '$end'";
		}
	} 

	$events = $events." ORDER BY start_time DESC";

	$events_query = DBQuery::sql("$events");

	$howMany = count($events_query);
	for($j = 0; $j < $howMany; ++$j)
	{
		if($start != '' && $end != '') 
		{
			echo '<h1>Visar mellan '.$_POST['start'].'  -  '.$_POST['end'].'</h1>';
		}
		?>
		<tr>
			<td><?php echo $j+1; ?></td>
			<td><?php echo '<a href=?page=event&id='.$events_query[$j]['id'].'>'.$events_query[$j]['name'].'</a>'; ?></td>
			<td><?php echo $events_query[$j]['start_time'] ?></td>
			<td><?php loadWorkSlotPoints($user_id, $events_query[$j]['id']); ?></td>
			<td><?php loadWorkSlotWage($user_id, $events_query[$j]['id']); ?></td>
		</tr>
		<?php
	}
}

function loadWorkSlotPoints($user_id, $event_id)
{
	$workSlotPoints = DBQuery::sql("SELECT points FROM work_slot 
									WHERE event_id = '$event_id'
									AND id IN
										(SELECT work_slot_id FROM user_work WHERE user_id = '$user_id' AND checked = '1')
									");

	echo $workSlotPoints[0]['points'];
}

function loadWorkSlotWage($user_id, $event_id)
{
	$workSlotWage = DBQuery::sql("SELECT wage FROM work_slot 
									WHERE event_id = '$event_id'
									AND id IN
										(SELECT work_slot_id FROM user_work WHERE user_id = '$user_id' AND checked = '1')
									");
	echo $workSlotWage[0]['wage'];
}

function loadUserName()
{
	$user_id = $_SESSION['user_id'];

	$user_name = DBQuery::sql("SELECT name, last_name FROM user  
							WHERE id = '$user_id'");

	if(isset($user_name[0]['name']))
		echo $user_name[0]['name'].' '.$user_name[0]['last_name'];
	else
		echo 'John Doe';
}

function loadUserAvatar()
{
	$user_id = $_SESSION['user_id'];

	if(isset($user_id))
	{
		$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$user_id' AND avatar IS NOT NULL");
		if(count($results) == 0)
		{
			return 'img/avatars/no_face_small.png';
		}
		return 'img/avatars/'.$results[0]['avatar'];
	}
}

?>