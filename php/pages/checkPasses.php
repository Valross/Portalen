<?php
include_once('php/DBQuery.php');

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
			?>
				<a class="list-group-item" href=<?php echo '"?page=checkPasses&id='.$events[$i]['id'].'"'; ?>><?php echo $events[$i]['name']; ?></a>
			<?php
		}
	}
}

function loadEventName($event_id)
{
	$event_name = DBQuery::sql("SELECT name FROM event
							WHERE id = '$event_id'");

	if(count($event_name) > 0)
		echo $event_name[0]['name'];
	else
		echo "Något gick fel!";
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

function loadNameFromUser($user_id)
{
	$results = DBQuery::sql("SELECT name, last_name FROM user WHERE id = '$user_id'");
	if(count($results) == 0)
	{
		return '';
	}
	return $results[0]['name'].' '.$results[0]['last_name'];
}

function loadWorkSlots()
{
	if(isset($_GET['id']))
	{
		echo '<div class="row">
				<div class="col-sm-6">
					<div class="white-box">';
		$event_id = $_GET['id'];
		$user_id = $_SESSION['user_id'];
		$slots = DBQuery::sql("SELECT id, points, event_id, start_time, end_time, group_id FROM work_slot 
							WHERE event_id = '$event_id'
							");

		$bookedSlots = DBQuery::sql("SELECT work_slot_id, user_id FROM user_work 
							WHERE work_slot_id IN
								(SELECT id FROM work_slot 
								WHERE event_id = '$event_id')
							AND user_id = '$user_id'");

		$groups = DBQuery::sql("SELECT id, name FROM work_group 
								WHERE id IN 
								(SELECT group_id FROM work_slot WHERE event_id = '$event_id')
								");


		if(count($groups) > 0)
		{
			echo '<h3>Checka pass för '.loadEventName($event_id).'</h3>';
			echo '<form action="" method="post">';

			for($i = 0; $i < count($groups); ++$i)
			{
				echo '<p>'.$groups[$i]['name'].'</p>';
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
							echo '<a class="list-group-item">';
							echo '<input type="checkbox" name="slot[]" id="'.$slots[$j]['id'].'" value="'.$slots[$j]['id'].'">';
							echo $start.$end;
							echo ' '.loadNameFromUser($bookedSlot[0]['user_id']).' ';
							echo " (".$slots[$j]['points'].' poäng)';
							echo loadAvatarFromUser($bookedSlot[0]['user_id']);
							echo '</a>';
						}
					}
				}
			}
			echo '<input type="submit" name="submit" value="Check">';
			echo '</form>';
		}
		echo '</div> <!-- .white-box -->
			</div>
		</div>';
	}
}

?>