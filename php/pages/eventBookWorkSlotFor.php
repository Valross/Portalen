<?php
include_once('php/DBQuery.php');

function loadPeople()
{
	if(isset($_GET['event_id']) && isset($_GET['work_slot_id']))
	{
		$event_id = $_GET['event_id'];
		$work_slot_id = $_GET['work_slot_id'];

		$users = DBQuery::sql("SELECT name, last_name, id FROM user 
							ORDER BY last_name");
		$howMany = count($users);
		for($j = 0; $j < $howMany; ++$j)
		{
			?>
			<tr>
				<td><?php echo $j+1;?></td>
				<td><?php echo '<a href=?page=eventBookWorkSlot&event_id='.$event_id.'&user_id='.$users[$j]['id'].'&work_slot_id='.$work_slot_id.'>'
					.$users[$j]['name'].' '.$users[$j]['last_name'].'</td>'; ?>
				<td><?php loadMemberSince($users[$j]['id']); ?></td>
				<td><?php loadLastWorked($users[$j]['id']); ?></td>
			</tr>
			<?php
		}
	}
}

function loadMemberSince($user_id)
{
	$memberSince = DBQuery::sql("SELECT date_created FROM user 
									WHERE id = '$user_id'");
	if(count($memberSince) > 0)
		echo $memberSince[0]['date_created'];
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
		echo '<a href=?page=event&id='.$lastWorked[0]['id'].'>'.$lastWorked[0]['name'].' ('.$lastWorked[0]['start_time'].')'.'</a>';
	else
		echo 'Har ej jobbat';
}

?>