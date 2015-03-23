<?php
include_once('php/DBQuery.php');

loadTitleForBrowser('Checka pass');

$dates = new DateTime;
$dates->setTimezone(new DateTimeZone('Europe/Stockholm'));
$date = $dates->format('Y-m-d H:i:s');

if(isset($_POST['submit']) && checkAdminAccess())
{
	if(isset($_POST['slot'])){
	    $slots = $_POST['slot'];
	    $slotCounter = count($slots);

	    for($i=0; $i < $slotCounter; $i++)
	    {
	    	$slot = $slots[$i];
	        DBQuery::sql("UPDATE user_work
				  SET checked=1
				  WHERE work_slot_id='$slot'");	    
	        $user_id = DBQuery::sql("SELECT user_id FROM user_work
							WHERE work_slot_id = '$slot'");
	        checkIfAchievement($user_id[0]['user_id']);
	    }
	}
}

function loadMyDAEvents()
{
	$user_id = $_SESSION['user_id'];
	$events = DBQuery::sql("SELECT id, name, start_time, event_type_id FROM event 
							WHERE event_type_id != 5 AND id IN
								(SELECT event_id FROM work_slot
								WHERE group_id = 7 AND id IN
									(SELECT work_slot_id FROM user_work
									WHERE user_id = '$user_id'))
							ORDER BY start_time DESC"); 

	if(count($events) == 0)
		echo '<p>Du har fan inte jobbat DA</p>';
	else 
	{
		for($i = 0; $i < count($events); ++$i)
		{
			echo '<a class="list-group-item" href="?page=checkPasses&id='.$events[$i]['id'].'">'
				.$events[$i]['name'].' - '.$events[$i]['start_time'].'</a>';
		}
	}
}

function loadEventName($event_id)
{
	$event_name = DBQuery::sql("SELECT name FROM event
							WHERE id = '$event_id'");

	if(count($event_name) > 0)
		echo '<a href="?page=event&id='.$event_id.'">'.$event_name[0]['name'].'</a>';
	else
		echo "Något gick fel!";
}

function loadUserAvatar($user_id)
{
	$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$user_id' AND avatar IS NOT NULL");
	if(count($results) == 0)
	{
		return '<img src="img/avatars/no_face_small.png" width="20" height="20" class="img-circle">';
	}
	return '<img src="img/avatars/'.$results[0]['avatar'].'" width="20" height="20" class="img-circle">';
}

function loadWorkSlots()
{
	if(isset($_GET['id']))
	{
		echo '<div class="col-sm-6">
					<div class="white-box">';
		$event_id = $_GET['id'];
		$user_id = $_SESSION['user_id'];
		$slots = DBQuery::sql("SELECT id, points, event_id, start_time, end_time, group_id, wage FROM work_slot 
							WHERE event_id = '$event_id'");

		$bookedSlots = DBQuery::sql("SELECT work_slot_id, user_id FROM user_work 
							WHERE work_slot_id IN
								(SELECT id FROM work_slot 
								WHERE event_id = '$event_id')
							AND user_id = '$user_id'");

		$groups = DBQuery::sql("SELECT id, name FROM work_group 
								WHERE id IN 
									(SELECT group_id FROM work_slot 
									WHERE event_id = '$event_id'
									AND id IN
										(SELECT work_slot_id FROM user_work))");


		if(count($groups) > 0)
		{
			echo '<h3>Checka pass för ';
			echo loadEventName($event_id).'</h3>';
			echo '<form action="" method="post">';

			for($i = 0; $i < count($groups); ++$i)
			{
				echo '<p><strong>'.$groups[$i]['name'].'</strong></p>';
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
						$bookedSlot = DBQuery::sql("SELECT work_slot_id, user_id FROM user_work 
								WHERE work_slot_id IN
									(SELECT id FROM work_slot 
									WHERE event_id = '$event_id')
								AND work_slot_id = '$work_slot_id'");

						if(count($bookedSlot) > 0)
						{
							$bookedSlotIsChecked = DBQuery::sql("SELECT work_slot_id, user_id FROM user_work 
								WHERE work_slot_id IN
									(SELECT id FROM work_slot 
									WHERE event_id = '$event_id')
								AND work_slot_id = '$work_slot_id'
								AND checked = 1");

							echo '<li class="list-group-item">';
							if(count($bookedSlotIsChecked) > 0)
								echo '<input type="checkbox" name="slot[]" id="'.$slots[$j]['id'].'" value="'.$slots[$j]['id'].'" checked>';
							else
								echo '<input type="checkbox" name="slot[]" id="'.$slots[$j]['id'].'" value="'.$slots[$j]['id'].'">';
							echo $start.$end;
							echo '<a href="?page=userProfile&id='.$bookedSlot[0]['user_id'].'" class="work-slot-user black-link"> '.loadAvatarFromUser($bookedSlot[0]['user_id'], 20).loadNameFromUser($bookedSlot[0]['user_id']).'</a>';
							echo " (".$slots[$j]['points'].' poäng)';
							echo " (".$slots[$j]['wage'].' kr/h)';
						}
					}
				}
			}
			echo '<input type="submit" name="submit" value="Check">';
			echo '</form>';
		}
		echo '</div> <!-- .white-box -->
			</div>';
	}
}

?>