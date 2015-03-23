<?php

function loadUserName()
{
	$user_id = $_GET['user_id'];
	$user = DBQuery::sql("SELECT name, last_name, id FROM user 
						WHERE id = '$user_id'");
	echo '<a href="?page=userProfile&id='.$user[0]['id'].'">';
	echo loadAvatarFromUser($user_id, 100);
	echo $user[0]['name'].' '.$user[0]['last_name'];
	echo '</a>';
}

function loadColleagueStats()
{
	$user_id = $_GET['user_id'];
	$local_user_id = $_SESSION['user_id'];
	$user = DBQuery::sql("SELECT name, last_name FROM user
						WHERE id = '$user_id'");

	if($local_user_id != $user_id)
	{
		$workedSameEvent = DBQuery::sql("SELECT id FROM event 
									WHERE id IN
										(SELECT event_id FROM work_slot 
										WHERE id IN
											(SELECT work_slot_id FROM user_work
											WHERE user_id = '$user_id'))");

		$workedEvents = DBQuery::sql("SELECT id, name, start_time FROM event 
									WHERE id IN
										(SELECT event_id FROM work_slot 
										WHERE id IN
											(SELECT work_slot_id FROM user_work
											WHERE user_id = '$local_user_id'))");
		
		$workedSameEventCounter = 0;
		for($i = 0; $i < count($workedSameEvent); ++$i)
		{
			for($k = 0; $k < count($workedEvents); ++$k)
			{
				if($workedSameEvent[$i]['id'] == $workedEvents[$k]['id'])
					$workedSameEventCounter++;
			}
		}
		
		for($i = 0; $i < $workedSameEventCounter; ++$i)
		{
			echo '<tr>';
			echo '<td>';
			echo '<a href=?page=event&id='.$workedEvents[$i]['id'].' >'.$workedEvents[$i]['name'].'</a>';
			echo '</td>';

			echo '<td>';
			echo $workedEvents[$i]['start_time'];
			echo '</td>';
			echo '</tr>';
		}
	}
}

?>