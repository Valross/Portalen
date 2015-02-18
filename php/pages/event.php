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
	$event_info = DBQuery::sql("SELECT info, start_time, end_time FROM event 
						WHERE id = '$event_id'");

	if(count($event_info) > 0)
	{
		echo "<p>Start: ".$event_info[0]['start_time']."</p>";
		echo "<p>Slut: ".$event_info[0]['end_time']."</p>";
		echo "<p>".$event_info[0]['info']."</p>";
	}

}

function checkIfMemberOfGroup($user_id, $group_id)
{
	if($user_id < 0)
	{
		return false;
	}
	return true;
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

	$groups = DBQuery::sql("SELECT id, name FROM work_group 
							WHERE id IN 
							(SELECT group_id FROM work_slot WHERE event_id = '$event_id')
							ORDER BY name");

	for($i = 0; $i < count($groups); ++$i)
	{
		echo '<p>'.$groups[$i]['name'].'</p>';
		for($j = 0; $j < count($slots); ++$j)
		{
			if($slots[$j]['group_id'] == $groups[$i]['id'])
			{
				echo '<p>'.$slots[$j]['id']." | GROUP_ID: ".$slots[$j]['group_id'];
				echo " BOOKED: ".count($bookedSlots);
				if(count($bookedSlots) > $j)
				{
					echo " USER_ID: ".$bookedSlots[$j]['user_id'];
					echo loadAvatarFromUser(($bookedSlots[$j]['user_id'])).'</p>';
				}
				if(checkIfMemberOfGroup($_SESSION['user_id'], $groups[$i]['id']))
				{
					echo '<button type="button">Boka</button>';
				}
			}
		}
	}
}

function loadAvatarFromUser($user_id)
{
	$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$user_id' AND avatar IS NOT NULL");
	if(count($results) == 0)
	{
		return '<img src="img/avatars/no_face_small.png" width="20" height="20" class="img-circle">';
	}
	return '<img src="img/avatars/'.$results[0]['avatar'].'" width="20" height="20" class="img-circle">';

}

?>