<?php
loadTitleForBrowser('Personallista');

function loadStats()
{
	$users = DBQuery::sql("SELECT name, last_name, id FROM user 
							ORDER BY id");
	$howMany = count($users);
	for($j = 0; $j < $howMany; ++$j)
	{
		echo '<tr>';
			echo '<td>'.($j+1).'</td>';
			echo '<td><a href=?page=userProfile&id='.$users[$j]['id'].'>'.$users[$j]['name'].' '.$users[$j]['last_name'].'</a></td>';
			echo '<td>'.loadMemberSince($users[$j]['id']).'</td>';
			echo '<td>'.loadLatestSession($users[$j]['id']).'</td>';
			echo '<td>'.loadLastWorked($users[$j]['id']).'</td>';
		echo '</tr>';
	}
}

function loadMemberSince($user_id)
{
	$memberSince = DBQuery::sql("SELECT date_created FROM user 
									WHERE id = '$user_id'");
	if(count($memberSince) > 0)
		return $memberSince[0]['date_created'];
}

function loadLatestSession($user_id)
{
	$latestSession = DBQuery::sql("SELECT latest_session FROM user 
									WHERE id = '$user_id'");
	if(count($latestSession) > 0)
		return $latestSession[0]['latest_session'];
}

function loadLastWorked($user_id)
{
	$lastWorked = DBQuery::sql("SELECT id, name, start_time FROM event
								WHERE id IN
									(SELECT event_id FROM work_slot
									WHERE id IN
										(SELECT work_slot_id FROM user_work
										WHERE user_id = '$user_id' AND checked = 1))
								ORDER BY start_time DESC");
	if(count($lastWorked) > 0)
		return '<a href=?page=event&id='.$lastWorked[0]['id'].'>'.$lastWorked[0]['name'].' ('.$lastWorked[0]['start_time'].')'.'</a>';
	else
		return 'Har ej jobbat';
}

?>