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
	$user_id = $_SESSION['user_id'];

	$localUserBookedThisEvent = DBQuery::sql("SELECT work_slot_id, user_id FROM user_work 
						WHERE user_id = '$user_id' AND work_slot_id IN
							(SELECT id FROM work_slot
							WHERE event_id IN
								(SELECT id FROM event
								WHERE id = '$event_id'))");

	$adminAccess = DBQuery::sql("SELECT access_id, group_id FROM group_access
						WHERE (access_id = 1 OR access_id = 2 OR access_id = 4) AND
						group_id IN
							(SELECT group_id FROM group_member
							WHERE user_id = '$user_id' AND (group_id = 1 OR group_id = 7))");

	$slots = DBQuery::sql("SELECT id, points, event_id, start_time, end_time, group_id, wage FROM work_slot 
						WHERE event_id = '$event_id'");

	$bookedSlots = DBQuery::sql("SELECT work_slot_id, user_id FROM user_work 
						WHERE work_slot_id IN
							(SELECT id FROM work_slot 
							WHERE event_id = '$event_id')
						AND user_id = '$user_id'");

	$groups = DBQuery::sql("SELECT id, name FROM work_group 
							WHERE id IN 
							(SELECT group_id FROM work_slot WHERE event_id = '$event_id')");

	for($i = 0; $i < count($groups); ++$i)
	{
		$number = 0;
		echo '<a href="?page=group&id='.$groups[$i]['id'].'" class="list-group-item">'.$groups[$i]['name'].'</a>';
		for($j = 0; $j < count($slots); ++$j)
		{
			$work_slot_id = $slots[$j]['id'];

			$availableSlot = DBQuery::sql("SELECT id FROM work_slot 
										WHERE id NOT IN
											(SELECT work_slot_id FROM user_work)
										AND id = '$work_slot_id'");

			$slotStart = new DateTime($slots[$j]['start_time']);
			$slotEnd = new DateTime($slots[$j]['end_time']);
			$start = $slotStart->format('H:i -');
			$end = $slotEnd->format(' H:i');
			if($slots[$j]['group_id'] == $groups[$i]['id'])
			{
				$number++;

				$bookedSlot = DBQuery::sql("SELECT work_slot_id, user_id FROM user_work 
						WHERE work_slot_id IN
							(SELECT id FROM work_slot 
							WHERE event_id = '$event_id')
						AND work_slot_id = '$work_slot_id'");

				if(count($adminAccess) > 0)
				{
					if(count($bookedSlot) > 0)
					{
						echo '<p class="list-group-item-text">'.$number.'. '.$start.$end;
						echo '<a href="?page=userProfile&id='.$user_id.'"> '.loadNameFromUser($bookedSlot[0]['user_id']).' ';
						echo loadAvatarFromUser($bookedSlot[0]['user_id']).'</a>';
					}
					else
						echo '<p class="list-group-item-text">'.$number.'. '.$start.$end;

					if(count($adminAccess) > 0 || count($localUserBookedThisEvent) > 0)
						echo " (".$slots[$j]['wage'].' kr/h)'; 

					echo " (".$slots[$j]['points'].' poäng)';

					if(count($bookedSlot) == 0)
					{
						echo '<a href=?page=eventBookWorkSlotFor&event_id='.$event_id.'&work_slot_id='.$slots[$j]['id'].
							' class="list-group-item-text-book">Boka person</a></p>';
					}
					else
					{
						echo '<a href=?page=eventUnBookWorkSlot&event_id='.$event_id.'&user_id='.$user_id.'&work_slot_id='.$slots[$j]['id'].
							' class="list-group-item-text-book">Boka av</a></p>';
					}
				}
				else
				{
					$localUserBookedThisSlot = DBQuery::sql("SELECT work_slot_id, user_id FROM user_work 
						WHERE user_id = '$user_id' AND work_slot_id = '$work_slot_id'");

					if(count($bookedSlot) > 0)
					{
						echo '<p class="list-group-item-text">'.$number.'. '.$start.$end;
						echo '<a href="?page=userProfile&id='.$user_id.'"> '.loadNameFromUser($bookedSlot[0]['user_id']).' ';
						echo loadAvatarFromUser($bookedSlot[0]['user_id']).'</a>';
					}
					else
						echo '<p class="list-group-item-text">'.$number.'. '.$start.$end;

					if(count($adminAccess) > 0 || count($localUserBookedThisEvent) > 0)
						echo " (".$slots[$j]['wage'].' kr/h)'; 

					echo " (".$slots[$j]['points'].' poäng)';

					if(count($localUserBookedThisEvent) == 0)
					{
						if(checkIfMemberOfGroup($user_id, $groups[$i]['id']) && count($availableSlot) > 0)
							echo '<a href=?page=eventBookWorkSlot&event_id='.$event_id.'&user_id='.$user_id.'&work_slot_id='.$slots[$j]['id'].
							' class="list-group-item-text-book">Boka</a></p>';
						else
							echo '</p>';
					}
					else
					{
						if(count($localUserBookedThisSlot) > 0)
							echo '<a href=?page=eventUnBookWorkSlot&event_id='.$event_id.'&user_id='.$user_id.'&work_slot_id='.$slots[$j]['id'].
							' class="list-group-item-text-book">Boka av</a></p>';
						else
							echo '</a></p>';
					}
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
		return '<img src="img/avatars/no_face_small.png" width="25" height="25" class="img-circle">';
	}
	return '<img src="img/avatars/'.$results[0]['avatar'].'" width="25" height="25" class="img-circle">';
}

function loadNameFromUser($user_id)
{
	$results = DBQuery::sql("SELECT name, last_name FROM user WHERE id = '$user_id'");
	if(count($results) == 0)
	{
		return '';
	}
	
	return $results[0]['name'].' '.$results[0]['last_name'];
}

?>