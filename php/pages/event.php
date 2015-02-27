<?php
include_once('php/DBQuery.php');

if(isset($_POST['submit'])) {
	$p_start_time = $_POST['start_h'];
	$p_end_time = $_POST['end_h'];
	$p_start_date = $_POST['start_d'];
	$p_end_date = $_POST['end_d'];
	$p_points = $_POST['points'];
	$p_wage = $_POST['wage'];
	$p_work_slot_id = $_POST['work_slot_id'];

	$slotCounter = count($p_work_slot_id);

    for($i=0; $i < $slotCounter; $i++)
    {
    	$start_time = $p_start_time[$i];
    	$end_time = $p_end_time[$i];
    	$start_date = $p_start_date[$i];
    	$end_date = $p_end_date[$i];
    	$points = $p_points[$i];
    	$wage = $p_wage[$i];
    	$work_slot_id = $p_work_slot_id[$i];

    	$start = $start_date.' '.$start_time.':00';
    	$end = $end_date.' '.$end_time.':00';

        DBQuery::sql("UPDATE work_slot
			  SET start_time = '$start', end_time = '$end',
			  		points = '$points', wage = '$wage'
			  WHERE id='$work_slot_id'");
    }
}

if(isset($_POST['submitComment']))
{
	$comment = $_POST['comment'];
	$event_id = $_GET['id'];
	
	if($comment != '')
	{
		DBQuery::sql("INSERT INTO event_comments (user_id, event_id, comment, date_written)
						VALUES ('$_SESSION[user_id]', '$event_id', '$comment', '$date')");
		?>
		<script>
			window.location = <?php echo '?page=event&id='.$event_id; ?>;
		</script>
		<?php
	}
}

if(isset($_POST['addSlot']) && checkAdminAccess())
{
	$group_id = $_POST['group'];
	$amount = $_POST['amount'];
	$event_id = $_GET['id'];

	$event = DBQuery::sql("SELECT id, start_time, end_time FROM event
							WHERE id = '$event_id'");
	
	$start_time = $event[0]['start_time'];
	$end_time = $event[0]['end_time'];

	if($group_id != '')
	{
		for($i = 0; $i < $amount; ++$i)
		{
			DBQuery::sql("INSERT INTO work_slot (group_id, event_id, points, wage, start_time, end_time)
							VALUES ('$group_id', '$event_id', '0', '0', '$start_time', '$end_time')");
		}
		?>
		<script>
			window.location = <?php echo '?page=event&id='.$event_id; ?>;
		</script>
		<?php
	}
}

function loadEventName()
{
	$event_id = $_GET['id'];
	$user_id = $_SESSION['user_id'];

	$event_name = DBQuery::sql("SELECT name FROM event
							WHERE id = '$event_id'");

	$adminAccess = DBQuery::sql("SELECT access_id, group_id FROM group_access
						WHERE (access_id = 1 OR access_id = 2 OR access_id = 4) AND
						group_id IN
							(SELECT group_id FROM group_member
							WHERE user_id = '$user_id' AND (group_id = 1 OR group_id = 7))");

	if(count($event_name) > 0)
		echo $event_name[0]['name'];
	else
		echo "Nu har du kommit lite fel!";

	$da_note = DBQuery::sql("SELECT event_id FROM da_note
							WHERE event_id = '$event_id'");

	if(count($da_note) > 0 && count($adminAccess) > 0)
	{
		echo ' - <a href="?page=DANote&id='.$da_note[0]['event_id'].'">DA-lapp</a>';
	}
}


function loadEventDescription()
{
	$event_id = $_GET['id'];
	$event_info = DBQuery::sql("SELECT info, start_time, end_time, event_type_id FROM event 
						WHERE id = '$event_id'");

	$eventStart = new DateTime($event_info[0]['start_time']);
	$eventEnd = new DateTime($event_info[0]['end_time']);
	$start = $eventStart->format('Y-m-d H:i');
	$end = $eventEnd->format('Y-m-d H:i');

	if(count($event_info) > 0 && $event_info[0]['event_type_id'] == 5)
	{
		echo "<tr><td><strong>Börjar</strong></td><td>".$start."</td></tr>";
		echo "<tr><td><strong>Slutar</strong></td><td>".$end."</td></tr>";
		echo "<tr><td><strong>Information</td><td>".$event_info[0]['info']."</td></tr>";
	}
	else
	{
		echo "<tr><td><strong>Öppnar</strong></td><td>".$start."</td></tr>";
		echo "<tr><td><strong>Stänger</strong></td><td>".$end."</td></tr>";
		echo "<tr><td><strong>Information</strong></td><td>".$event_info[0]['info']."</td></tr>";
	}
}

function loadGroups()
{
	$groups = DBQuery::sql("SELECT id, name FROM work_group ORDER BY name");
	for($i = 0; $i < count($groups); ++$i)
	{
		?>
			<option value="<?php echo $groups[$i]['id']; ?>" name="group[]"><?php echo $groups[$i]['name']; ?></option>
		<?php
	}
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

	if(checkAdminAccess())
	{
		echo '<form action="" method="post">';
	}
	for($i = 0; $i < count($groups); ++$i)
	{
		$number = 0;
		echo '<li class="list-group-item"><a href="?page=group&id='.$groups[$i]['id'].'"><strong>'.$groups[$i]['name'].'</strong></a></li>';
		for($j = 0; $j < count($slots); ++$j)
		{
			$work_slot_id = $slots[$j]['id'];

			$availableSlot = DBQuery::sql("SELECT id FROM work_slot 
										WHERE id NOT IN
											(SELECT work_slot_id FROM user_work)
										AND id = '$work_slot_id'");
			
			if($slots[$j]['group_id'] == $groups[$i]['id'])
			{
				$slotStart = new DateTime($slots[$j]['start_time']);
				$slotEnd = new DateTime($slots[$j]['end_time']);
				$start_h = $slotStart->format('H:i');
				$end_h = $slotEnd->format('H:i');
				$start_d = $slotStart->format('Y-m-d');
				$end_d = $slotEnd->format('Y-m-d');
				$number++;

				$bookedSlot = DBQuery::sql("SELECT work_slot_id, user_id FROM user_work 
						WHERE work_slot_id IN
							(SELECT id FROM work_slot 
							WHERE event_id = '$event_id')
						AND work_slot_id = '$work_slot_id'");

				if(checkAdminAccess())
				{
					echo '<li class="list-group-item">'.$number.'. ';
					echo '<input type="text" class="input-book-long" name="start_d[]" id="start_d[]" value="'.$start_d.'">';
					echo '<input type="text" class="input-book" name="start_h[]" id="start_h[]" value="'.$start_h.'"> ';
					echo '<input type="text" class="input-book-long" name="end_d[]" id="end_d[]" value="'.$end_d.'">';
					echo '<input type="text" class="input-book" name="end_h[]" id="end_h[]" value="'.$end_h.'"> ';
					echo '<input type="text" class="input-book" name="wage[]" id="wage[]" value="'.$slots[$j]['wage'].'"> kr/h ';
					if(count($bookedSlot) > 0)
					{
						echo '<a href="?page=userProfile&id='.$bookedSlot[0]['user_id'].'"> '.loadNameFromUser($bookedSlot[0]['user_id']).' ';
						echo loadAvatarFromUser($bookedSlot[0]['user_id'], 25).'</a>';
					}
					else
					{
						echo '<a href=?page=eventRemoveWorkSlot&event_id='.$event_id.'&user_id='.$user_id.'&work_slot_id='.$slots[$j]['id'].
							' class="list-group-item-text-book-remove"><span class="fa fa-remove fa-fw fa-lg"></span></a>';
					}

					echo '<input type="text" class="input-book" name="points[]" id="points[]" value="'.$slots[$j]['points'].'">p';
					echo '<input type="hidden" name="work_slot_id[]" id="work_slot_id[]" value="'.$slots[$j]['id'].'">';

					if(count($bookedSlot) == 0)
					{
						echo '<a href=?page=eventBookWorkSlotFor&event_id='.$event_id.'&work_slot_id='.$slots[$j]['id'].
							' class="list-group-item-text-book"><span class="fa fa-user-plus fa-fw fa-lg"></span></a></li>';
					}
					else
					{
						echo '<a href=?page=eventUnBookWorkSlot&event_id='.$event_id.'&user_id='.$user_id.'&work_slot_id='.$slots[$j]['id'].
							' class="list-group-item-text-book"><span class="fa fa-remove fa-fw fa-lg"></span></a></li>';
					}
				}
				else
				{
					$slotStart = new DateTime($slots[$j]['start_time']);
					$slotEnd = new DateTime($slots[$j]['end_time']);
					$start_h = $slotStart->format('H:i -');
					$end_h = $slotEnd->format(' H:i');

					$localUserBookedThisSlot = DBQuery::sql("SELECT work_slot_id, user_id FROM user_work 
						WHERE user_id = '$user_id' AND work_slot_id = '$work_slot_id'");

					if(count($bookedSlot) > 0)
					{
						echo '<li class="list-group-item-text">'.$number.'. '.$start_h.$end_h;
						echo '<a href="?page=userProfile&id='.$bookedSlot[0]['user_id'].'"> '.loadNameFromUser($bookedSlot[0]['user_id']).' ';
						echo loadAvatarFromUser($bookedSlot[0]['user_id'], 25).'</a>';
					}
					else
						echo '<li class="list-group-item-text">'.$number.'. '.$start_h.$end_h;

					if(checkAdminAccess() || count($localUserBookedThisEvent) > 0)
						echo " (".$slots[$j]['wage'].' kr/h)'; 

					echo " (".$slots[$j]['points'].'p)';

					if(count($localUserBookedThisEvent) == 0)
					{
						if(checkIfMemberOfGroup($user_id, $groups[$i]['id']) && count($availableSlot) > 0)
							echo '<a href=?page=eventBookWorkSlot&event_id='.$event_id.'&user_id='.$user_id.'&work_slot_id='.$slots[$j]['id'].
							' class="list-group-item-text-book"><span class="fa fa-plus fa-fw fa-lg"></span></a></li>';
						else
							echo '</li>';
					}
					else
					{
						if(count($localUserBookedThisSlot) > 0)
							echo '<a href=?page=eventUnBookWorkSlot&event_id='.$event_id.'&user_id='.$user_id.'&work_slot_id='.$slots[$j]['id'].
							' class="list-group-item-text-book"><span class="fa fa-remove fa-fw fa-lg"></span></a></li>';
						else
							echo '</a></li>';
					}
				}
			}
		}
	}
	if(checkAdminAccess() && count($groups) > 0)
	{
		echo '<input type="submit" name="submit" value="Spara">';
		echo '</form>';
	}
}

function checkWhatGroup()
{
	return true;
}

function loadCommentAvatar($comment_id)
{
	$event_id = $_GET['id'];

	$user = DBQuery::sql("SELECT user_id FROM event_comments 
						WHERE event_id = '$event_id'
						AND id = '$comment_id'"); 
	if(count($user) > 0)
		$user_id = $user[0]['user_id'];

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

function loadComments()
{
	if(checkWhatGroup())
	{
		$event_id = $_GET['id'];

		$event_comments = DBQuery::sql("SELECT id, event_id, comment, date_written FROM event_comments 
								WHERE event_id = '$event_id'");

		if(count($event_comments) > 0)
		{
			echo '<div class="row">
						<div class="col-sm-12">
							<div class="white-box">';
			echo '<h1>Kommentarer</h1>';

			for($i = 0; $i < count($event_comments); ++$i)
			{
				echo '<div>';
				echo '<img src="'.loadCommentAvatar($event_comments[$i]['id']).'" width="100" height="100" class="page-header-img">';
				echo '<p>'.$event_comments[$i]['date_written'].'</p>';
				echo '<p>'.$event_comments[$i]['comment'].'</p>';
				echo '</div>';
			}
			echo '			</div>
						</div>
					</div>';
		}
	}
}

?>