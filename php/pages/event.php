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
    	if($points < 0 || $points > 10)
    		$points = 0;
    	$wage = $p_wage[$i];
    	if($wage < 0 || $wage > 170)
    		$wage = 0;
    	$work_slot_id = $p_work_slot_id[$i];

    	$start = $start_date.' '.$start_time.':00';
    	$end = $end_date.' '.$end_time.':00';

        DBQuery::sql("UPDATE work_slot
			  SET start_time = '$start', end_time = '$end',
			  		points = '$points', wage = '$wage'
			  WHERE id='$work_slot_id'");
    }
}

if(isset($_POST['eventInfo'])) {
	$start_time = $_POST['start_h'];
	$end_time = $_POST['end_h'];
	$start_date = $_POST['start_d'];
	$end_date = $_POST['end_d'];
	$info = $_POST['info'];
	$event_id = $_GET['id'];

	$start = $start_date[0].' '.$start_time[0].':00';
	$end = $end_date[0].' '.$end_time[0].':00';

    DBQuery::sql("UPDATE event
		  SET start_time = '$start', end_time = '$end',
		  		info = '$info'
		  WHERE id='$event_id'");
}

if(isset($_POST['submitComment']))
{
	$comment = strip_tags($_POST['comment'], allowed_tags());
	$event_id = $_GET['id'];
	
	if($comment != '')
	{
		DBQuery::sql("INSERT INTO event_comments (user_id, event_id, comment, date_written)
						VALUES ('$_SESSION[user_id]', '$event_id', '$comment', '$date')");

		$comment = DBQuery::sql("SELECT id FROM event_comments 
						ORDER BY date_written DESC");

		$comment_id = $comment[0]['id'];

		$users = DBQuery::sql("SELECT id FROM user
							WHERE id IN
								(SELECT user_id FROM user_work
								WHERE work_slot_id IN
									(SELECT id FROM work_slot
									WHERE event_id = '$event_id'))");

		for($i = 0; $i < count($users); ++$i)
		{
			if($users[$i]['id'] != $_SESSION['user_id'])
				notify($users[$i]['id'], 8, $comment_id);
		}

		?>
		<script>
			window.location = <?php echo '?page=event&id='.$event_id; ?>;
		</script>
		<?php
	}
}

if(isset($_POST['addSlot']) && checkAdminAccess() <= 1)
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

function loadButtons()
{
	$event_id = $_GET['id'];

	$da_note = DBQuery::sql("SELECT event_id FROM da_note
								WHERE event_id = '$event_id'");

	$headwaiter_note = DBQuery::sql("SELECT event_id FROM headwaiter_note
							WHERE event_id = '$event_id'");

	$event_name = DBQuery::sql("SELECT name, event_type_id FROM event
							WHERE id = '$event_id'");

	if(checkAdminAccess() <= 1 && !isset($_GET['edit']))
		echo '<a href="?page=event&id='.$event_id.'&edit" class="btn btn-page-header"><span class="fa fa-wrench fa-fw fa-lg"></span>Redigeringsläge</a>';
	else if(checkAdminAccess() <= 1  && isset($_GET['edit']))
		echo '<a href="?page=event&id='.$event_id.'" class="btn btn-page-header"><span class="fa fa-wrench fa-fw fa-lg"></span>Snyggläge</a>';

	if(checkAdminAccess() <= 1 && $event_name[0]['event_type_id'] != 5)
		echo '<a href="?page=checkPasses&id='.$event_id.'" class="btn btn-page-header"><span class="fa fa-check-square-o fa-fw fa-lg"></span>Checka Pass</a>';

	if(count($da_note) > 0 && checkAdminAccess() <= 1)
		echo '<a href="?page=DANote&id='.$da_note[0]['event_id'].'" class="btn btn-page-header">DA-lapp</a>';

	if(count($headwaiter_note) > 0 && checkAdminAccess() <= 1)
		echo '<a href="?page=HeadwaiterNote&id='.$headwaiter_note[0]['event_id'].'" class="btn btn-page-header">Hovis-lapp</a>';
}

function loadEventName()
{
	$event_id = $_GET['id'];
	$user_id = $_SESSION['user_id'];

	$event_name = DBQuery::sql("SELECT name, event_type_id FROM event
							WHERE id = '$event_id'");

	if(count($event_name) > 0)
	{
		echo $event_name[0]['name'];
		loadTitleForBrowser($event_name[0]['name']);
	}
	else
		echo "Nu har du kommit lite fel!";

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

	$start_h = $eventStart->format('H:i');
	$end_h = $eventEnd->format('H:i');
	$start_d = $eventStart->format('Y-m-d');
	$end_d = $eventEnd->format('Y-m-d');

	if(checkAdminAccess() <= 1 && isset($_GET['edit']))
	{
		echo '<form action="" method="post">';
		if(count($event_info) > 0 && $event_info[0]['event_type_id'] == 5)
		{
			echo "<tr><td><strong>Börjar</strong></td><td>";
			echo '<input type="text" class="input-book-long" name="start_d" id="start_d" value="'.$start_d.'">';
			echo '<input type="text" class="input-book" name="start_h" id="start_h" value="'.$start_h.'"> ';
			echo "</td></tr>";

			echo "<tr><td><strong>Slutar</strong></td><td>";
			echo '<input type="text" class="input-book-long" name="end_d" id="end_d" value="'.$end_d.'">';
			echo '<input type="text" class="input-book" name="end_h" id="end_h" value="'.$end_h.'"> ';
			echo "</td></tr>";

			echo "<tr><td><strong>Information</strong></td><td>";
			echo '<textarea rows="4" name="info" id="info" class="bottom-border">'.$event_info[0]['info'].'</textarea>';
			echo "</td></tr>";
		}
		else
		{
			echo "<tr><td><strong>Öppnar</strong></td><td>";
			echo '<input type="text" class="input-book-long" name="start_d[]" id="start_d[]" value="'.$start_d.'">';
			echo '<input type="text" class="input-book" name="start_h[]" id="start_h[]" value="'.$start_h.'"> ';
			echo "</td></tr>";

			echo "<tr><td><strong>Stänger</strong></td><td>";
			echo '<input type="text" class="input-book-long" name="end_d[]" id="end_d[]" value="'.$end_d.'">';
			echo '<input type="text" class="input-book" name="end_h[]" id="end_h[]" value="'.$end_h.'"> ';
			echo "</td></tr>";

			echo "<tr><td><strong>Information</strong></td><td>";
			echo '<textarea rows="4" name="info" id="info" class="bottom-border">'.$event_info[0]['info'].'</textarea>';
			echo "</td></tr>";
		}
		echo '<tr><td><input type="submit" name="eventInfo" value="Spara"></td>';
		echo '<td><a href="?page=removeEvent&event_id='.$event_id.'" onclick="return confirm(\'Är du säker? Det går inte att ångra sig.\')">
			<span class="fa fa-remove fa-fw fa-lg"></span>Ta bort eventet</a></td>';
		echo '</tr>';
		echo '</form>';
	}
	else
	{
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
}

function loadGroups()
{
	$groups = DBQuery::sql("SELECT id, name FROM work_group ORDER BY name");
	for($i = 0; $i < count($groups); ++$i)
	{
		echo '<option value="'.$groups[$i]['id'].'" name="group[]">'.$groups[$i]['name'].'</option>';
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

	$groups = DBQuery::sql("SELECT id, name, main_group, sub_group, icon, hex FROM work_group 
							WHERE id IN 
							(SELECT group_id FROM work_slot WHERE event_id = '$event_id')
							ORDER BY name");

	if(checkAdminAccess() <= 1 && isset($_GET['edit']))
	{
		echo '<form action="" method="post">';
	}
	for($i = 0; $i < count($groups); ++$i)
	{
		$number = 0;
		if($groups[$i]['main_group'] == NULL)
		{
			echo '<li class="list-group-item with-thumbnail">';
			
			if($groups[$i]['icon'] != '')
				echo '<span class="'.$groups[$i]['icon'].' list-group-thumbnail group-badge webb"></span>';
			else
				echo '<span class="fa fa-code fa-fw list-group-thumbnail group-badge webb"></span>'; 
			echo '<a href="?page=group&id='.$groups[$i]['id'].'" class="black-link"><strong>'.$groups[$i]['name'].'</strong></a></li>';
		}
		for($j = 0; $j < count($slots); ++$j)
		{
			$work_slot_id = $slots[$j]['id'];

			$availableSlot = DBQuery::sql("SELECT id FROM work_slot 
										WHERE id NOT IN
											(SELECT work_slot_id FROM user_work)
										AND id = '$work_slot_id'");
			
			if(($slots[$j]['group_id'] == $groups[$i]['id'] || $slots[$j]['group_id'] == $groups[$i]['sub_group']) && $groups[$i]['main_group'] == 0)
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

				if(checkAdminAccess() <= 1 && isset($_GET['edit']))
				{
					if($slots[$j]['group_id'] == $groups[$i]['sub_group']) //if it's a newbuilder-pass
						echo '<li class="list-group-item">'.$number.'. ';
					else
						echo '<li class="list-group-item">'.$number.'. ';
					echo '<input type="text" class="input-book-long" name="start_d[]" id="start_d[]" value="'.$start_d.'">';
					echo '<input type="text" class="input-book" name="start_h[]" id="start_h[]" value="'.$start_h.'"> ';
					echo '<input type="text" class="input-book-long" name="end_d[]" id="end_d[]" value="'.$end_d.'">';
					echo '<input type="text" class="input-book" name="end_h[]" id="end_h[]" value="'.$end_h.'"> ';
					echo '<input type="text" class="input-book" name="wage[]" id="wage[]" value="'.$slots[$j]['wage'].'"> kr/h ';
					if(count($bookedSlot) > 0)
					{
						echo '<a href="?page=userProfile&id='.$bookedSlot[0]['user_id'].'" class="black-link">'.loadAvatarFromUser($bookedSlot[0]['user_id'], 20). loadNameFromUser($bookedSlot[0]['user_id']).'</a>';
					}
					else
					{
						if($slots[$j]['group_id'] == $groups[$i]['sub_group']) //if it's a newbuilder-pass
							echo '(Nybyggare)';
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
						echo '<li class="list-group-item">'.$number.'. '.$start_h.$end_h;
						echo '<a href="?page=userProfile&id='.$bookedSlot[0]['user_id'].'" class="work-slot-user black-link"> '.loadAvatarFromUser($bookedSlot[0]['user_id'], 20).loadNameFromUser($bookedSlot[0]['user_id']).'</a>';
					}
					else
						echo '<li class="list-group-item">'.$number.'. '.$start_h.$end_h;

					echo '<span class="badge">'.$slots[$j]['points'].'p</span>';

					if(checkAdminAccess() <= 1 || count($localUserBookedThisSlot) > 0)
						echo " (".$slots[$j]['wage'].' kr/h)'; 

					$alreadyHappend = DBQuery::sql("SELECT id, start_time, end_time FROM work_slot 
															WHERE start_time > '".date('Y-m-d H:i:s',strtotime('-0 day'))."'
															AND id = '$work_slot_id'");

					if(count($localUserBookedThisEvent) == 0)
					{
						if(checkIfMemberOfGroup($user_id, $groups[$i]['id']) && count($availableSlot) > 0 && count($alreadyHappend) != 0 && $groups[$i]['sub_group'] == 0)
							echo '<a href=?page=eventBookWorkSlot&event_id='.$event_id.'&user_id='.$user_id.'&work_slot_id='.$slots[$j]['id'].
							' class="work-slot-user"><span class="fa fa-user-plus fa-fw fa-lg"></span>Ledigt pass</a></li>';
						else if(checkIfMemberOfGroup($user_id, $groups[$i]['id']) && count($availableSlot) > 0 && count($alreadyHappend) != 0 && $slots[$j]['group_id'] != $groups[$i]['sub_group'])
							echo '<a href=?page=eventBookWorkSlot&event_id='.$event_id.'&user_id='.$user_id.'&work_slot_id='.$slots[$j]['id'].
							' class="work-slot-user"><span class="fa fa-user-plus fa-fw fa-lg"></span>Ledigt pass (Ordinarie)</a></li>';
						else if(checkIfMemberOfGroup($user_id, $groups[$i]['sub_group']) && count($availableSlot) > 0 && $slots[$j]['group_id'] == $groups[$i]['sub_group'] && count($alreadyHappend) != 0)
							echo '<a href=?page=eventBookWorkSlot&event_id='.$event_id.'&user_id='.$user_id.'&work_slot_id='.$slots[$j]['id'].
							' class="work-slot-user"><span class="fa fa-user-plus fa-fw fa-lg"></span>Ledigt pass (Nybyggare)</a></li>';
						else if(checkIfMemberOfGroup($user_id, $groups[$i]['sub_group']) && !checkIfMemberOfGroup($user_id, $groups[$i]['id']) && count($availableSlot) > 0 && count($alreadyHappend) != 0)
							echo '<a href="" class="work-slot-user black-link" data-toggle="tooltip" data-placement="bottom" title="Det här passet är endast för ordinarie."> 
									<span class="fa fa-user-plus fa-fw fa-lg"></span>Ledigt pass (Ordinarie)</a></li>';
						else if(count($availableSlot) == 0)
							echo '';
						else
							echo '<a href="" class="work-slot-user black-link" data-toggle="tooltip" data-placement="bottom" title="Du är inte med i det här laget."> 
									<span class="fa fa-user-plus fa-fw fa-lg"></span>Ledigt pass</a></li>';
					}
					else
					{
						$start_time_event = DBQuery::sql("SELECT id, start_time FROM work_slot 
															WHERE id = '$work_slot_id'");

						$five_days = new DateTime($start_time_event[0]['start_time']);
						date_sub($five_days, date_interval_create_from_date_string('5 days'));
						$today = new DateTime;

						if(count($localUserBookedThisSlot) > 0 && count($alreadyHappend) != 0)
						{
							if($five_days > $today)
								echo '<a href=?page=eventUnBookWorkSlot&event_id='.$event_id.'&user_id='.$user_id.'&work_slot_id='.$slots[$j]['id'].
									' class="list-group-item-text-book"><span class="fa fa-remove fa-fw fa-lg"></span></a></li>';
							else
								echo '<a href="" class="list-group-item-text-book black-link" data-toggle="tooltip" data-placement="bottom" title="Du kan inte boka av dig 5 dagar innan passet. Kontakta lagansvarig."> 
									<span class="fa fa-remove fa-fw fa-lg"></span></a></li>';
						}	
						else
							echo '</a></li>';
					}
				}
			}
		}
	}
	if(checkAdminAccess() <= 1 && count($groups) > 0 && isset($_GET['edit']))
	{
		echo '<input type="submit" name="submit" value="Spara">';
		echo '</form>';
	}
}

function checkWhatGroup() //not used at the moment
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
	if(checkWhatGroup() && !isset($_GET['edit']))
	{
		echo '<div class="row">
				<div class="col-sm-12">
					<div class="page-header">
						<h1><span class="fa fa-comments fa-fw fa-lg"></span> Kommentarer</h1>
					</div>
				</div>
			</div> <!-- .row -->

			<div class="row">';

		$event_id = $_GET['id'];

		$event_comments = DBQuery::sql("SELECT id, event_id, comment, date_written, user_id FROM event_comments 
								WHERE event_id = '$event_id'");

		if(count($event_comments) > 0)
		{
			echo '
						<div class="col-sm-7">
							<div class="white-box">';
			echo '<h3>Kommentarer ('.count($event_comments).')</h3>';

			for($i = 0; $i < count($event_comments); ++$i)
			{
				$user_id = $event_comments[$i]['user_id'];
				$my_user_id = $_SESSION['user_id'];
				$this_comment_id = $event_comments[$i]['id'];
				$commenter = DBQuery::sql("SELECT id, name, last_name FROM user 
								WHERE id = '$user_id'");

				$myComment = DBQuery::sql("SELECT id FROM event_comments 
								WHERE id = '$this_comment_id'
								AND user_id = '$my_user_id'");

				echo '<div class="comment">';
				echo '<img src="'.loadCommentAvatar($event_comments[$i]['id']).'" width="64" height="64" class="img-circle">';
				echo '<p><a href="?page=userProfile&id='.$user_id.'">'.$commenter[0]['name'].' '.$commenter[0]['last_name'].'</a> ';
				echo '<span class="time">- ' .$event_comments[$i]['date_written'].'</span><br />';
				echo $event_comments[$i]['comment'].'</p>';
				if(checkAdminAccess() <= 1 || count($myComment) > 0)
					echo '<a href=?page=removeEventComment&event_id='.$event_id.'&comment_id='.$event_comments[$i]['id'].
							' class="list-group-item-text-book"><span class="fa fa-remove fa-fw fa-lg"></span></a>';
				echo '</div>';
			}
			echo '			</div>
						</div>';
		}
		loadWriteComments();
		echo '</div> <!-- .row -->';
	}
}

function loadWriteComments()
{
	echo '<form action="" method="post">
		<div class="col-sm-5">
			<div class="white-box">
				<h3>Skriv kommentar</h3>
				<label for="comment">Kommentar</label>
				<textarea rows="6" cols="50" placeholder="Fan rätt schysst event asså!!" name="comment" id="comment" class="bottom-border"></textarea>

				<input type="submit" name="submitComment" value="Skicka kommentar">
			</div> <!-- .white-box -->
		</div>
		</form>';
}

?>