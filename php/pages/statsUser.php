<?php

function loadStats()
{
	$user_id = $_SESSION['user_id'];
	$user = DBQuery::sql("SELECT name, last_name, id, number_of_sessions FROM user 
						WHERE id = '$user_id'");

	echo '<p>'.loadActivePeople().'</p>';
	echo '<p>'.loadAllPeople().'</p>';
	echo '<p>Antal inlogg: '.$user[0]['number_of_sessions'].'</p>';
	echo '<p>Antal kommentarer på event: '.loadEventComments($user_id).'</p>';
	echo '<p>Antal kommentarer på DA-lappar: '.loadDANoteComments($user_id).'</p>';
}

function loadUserName()
{
	$user_id = $_SESSION['user_id'];
	$user = DBQuery::sql("SELECT name, last_name, id FROM user 
						WHERE id = '$user_id'");
	echo '<a href="?page=userProfile&id='.$user[0]['id'].'">';
	echo $user[0]['name'].' '.$user[0]['last_name'];
	echo '</a>';
}

function loadActivePeople()
{
	$user_id = $_SESSION['user_id'];
	$activeUsers = DBQuery::sql("SELECT name, last_name, id FROM user
							INNER JOIN user_work ON user_work.user_id = user.id
							WHERE work_slot_id IN
								(SELECT id FROM work_slot
								WHERE start_time > '".date('Y-m-d',strtotime('-8 week'))." 00:00:00')
							AND user_work.checked = 1
							GROUP BY user.id
							");

	$users = DBQuery::sql("SELECT name, last_name, id FROM user");
	$work_counter = 0;

	for($j = 0; $j < count($users); ++$j)
	{
		$users_id = $users[$j]['id'];
		if($user_id != $users_id)
		{
			$workedSameEvent = DBQuery::sql("SELECT id FROM event 
										WHERE id IN
											(SELECT event_id FROM work_slot 
											WHERE id IN
												(SELECT work_slot_id FROM user_work
												WHERE user_id = '$users_id'))");

			$workedEvents = DBQuery::sql("SELECT id FROM event 
										WHERE id IN
											(SELECT event_id FROM work_slot 
											WHERE id IN
												(SELECT work_slot_id FROM user_work
												WHERE user_id = '$user_id'))");
			
			$workedSameEventCounter = 0;
			for($i = 0; $i < count($workedSameEvent); ++$i)
			{
				for($k = 0; $k < count($workedEvents); ++$k)
				{
					if($workedSameEvent[$i]['id'] == $workedEvents[$k]['id'])
						$workedSameEventCounter++;
				}
			}

			if($workedSameEventCounter > 0)
				$work_counter++;
		}
	}

	return 'Du har arbetat med '.round(($work_counter/count($activeUsers))*100).'% 
		('.$work_counter.'/'.count($activeUsers).') av alla aktiva (pass senaste 8 veckorna)';
}

function loadAllPeople()
{
	$user_id = $_SESSION['user_id'];
	$allWorkingUsers = DBQuery::sql("SELECT name, last_name, id FROM user
							INNER JOIN user_work ON user_work.user_id = user.id
							WHERE work_slot_id IN
								(SELECT id FROM work_slot)
							AND user_work.checked = 1
							GROUP BY user.id
							");

	$users = DBQuery::sql("SELECT name, last_name, id FROM user");
	$work_counter = 0;

	for($j = 0; $j < count($users); ++$j)
	{
		$users_id = $users[$j]['id'];
		if($user_id != $users_id)
		{
			$workedSameEvent = DBQuery::sql("SELECT id FROM event 
										WHERE id IN
											(SELECT event_id FROM work_slot 
											WHERE id IN
												(SELECT work_slot_id FROM user_work
												WHERE user_id = '$users_id'))");

			$workedEvents = DBQuery::sql("SELECT id FROM event 
										WHERE id IN
											(SELECT event_id FROM work_slot 
											WHERE id IN
												(SELECT work_slot_id FROM user_work
												WHERE user_id = '$user_id'))");
			
			$workedSameEventCounter = 0;
			for($i = 0; $i < count($workedSameEvent); ++$i)
			{
				for($k = 0; $k < count($workedEvents); ++$k)
				{
					if($workedSameEvent[$i]['id'] == $workedEvents[$k]['id'])
						$workedSameEventCounter++;
				}
			}

			if($workedSameEventCounter > 0)
				$work_counter++;
		}
	}

	return 'Du har arbetat med '.round(($work_counter/count($allWorkingUsers))*100).'% 
		('.$work_counter.'/'.count($allWorkingUsers).') av alla som någonsin jobbat ett pass';
}

function loadEventComments($user_id)
{
	$amountOfComments = DBQuery::sql("SELECT id FROM event_comments
									WHERE user_id = '$user_id'");
	return count($amountOfComments);
}

function loadDANoteComments($user_id)
{
	$amountOfComments = DBQuery::sql("SELECT id FROM da_note_comments
									WHERE user_id = '$user_id'");
	return count($amountOfComments);
}

function loadColleagueStats()
{
	$user_id = $_SESSION['user_id'];
	$users = DBQuery::sql("SELECT name, last_name, id FROM user");

	for($j = 0; $j < count($users); ++$j)
	{
		$users_id = $users[$j]['id'];
		if($user_id != $users_id)
		{
			$workedSameEvent = DBQuery::sql("SELECT id FROM event 
										WHERE id IN
											(SELECT event_id FROM work_slot 
											WHERE id IN
												(SELECT work_slot_id FROM user_work
												WHERE user_id = '$users_id'))");

			$workedEvents = DBQuery::sql("SELECT id FROM event 
										WHERE id IN
											(SELECT event_id FROM work_slot 
											WHERE id IN
												(SELECT work_slot_id FROM user_work
												WHERE user_id = '$user_id'))");
			
			$workedSameEventCounter = 0;
			for($i = 0; $i < count($workedSameEvent); ++$i)
			{
				for($k = 0; $k < count($workedEvents); ++$k)
				{
					if($workedSameEvent[$i]['id'] == $workedEvents[$k]['id'])
						$workedSameEventCounter++;
				}
			}
			
			?>
			<tr>
				<td><?php echo '<a href=?page=statsUserCompareWork&user_id='.$users[$j]['id'].'>'.$users[$j]['name'].' '.$users[$j]['last_name'].'</td>'; ?>
				<td><?php echo $workedSameEventCounter ?></td>
			</tr>
			<?php
		}
	}
}

?>