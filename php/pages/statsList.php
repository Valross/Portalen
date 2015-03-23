<?php
loadTitleForBrowser('Statistiklista');

function loadStats()
{
	$users = DBQuery::sql("SELECT name, last_name, id FROM user 
						ORDER BY id");
	$howMany = count($users);
	for($j = 0; $j < $howMany; ++$j)
	{
		?>
		<tr>
			<td><?php echo $j+1;?></td>
			<td><?php echo '<a href=?page=userProfile&id='.$users[$j]['id'].'>'.$users[$j]['name'].' '.$users[$j]['last_name'].'</td>'; ?>
			<td><?php loadBookedPoints($users[$j]['id']); ?></td>
			<td><?php loadWorkedPoints($users[$j]['id']); ?></td>
			<td><?php loadAmountOfPasses($users[$j]['id']); ?></td>
			<td><?php loadAmountOfMeetings($users[$j]['id']); ?></td>
		</tr>
		<?php
	}
}

function loadBookedPoints($user_id)
{
	$bookedPointsResult = DBQuery::sql("SELECT points FROM work_slot 
									WHERE event_id IN
										(SELECT id FROM event WHERE period_id IN 
											(SELECT id FROM period)
										) 
									AND id IN
										(SELECT work_slot_id FROM user_work WHERE user_id = '$user_id')
									");
	$bookedPointsTotal = 0;
	if(count($bookedPointsResult) > 0)
	{
		for($i = 0; $i < count($bookedPointsResult); ++$i)
			$bookedPointsTotal = $bookedPointsTotal + $bookedPointsResult[$i]['points'];
	}
	echo $bookedPointsTotal;
}

function loadWorkedPoints($user_id)
{
	$workedPointsResult = DBQuery::sql("SELECT points FROM work_slot 
									WHERE event_id IN
										(SELECT id FROM event WHERE period_id IN 
											(SELECT id FROM period)
										) 
									AND id IN
										(SELECT work_slot_id FROM user_work WHERE user_id = '$user_id' AND checked = '1')
									");
	$workedPointsTotal = 0;
	if(count($workedPointsResult) > 0)
	{
		for($i = 0; $i < count($workedPointsResult); ++$i)
			$workedPointsTotal = $workedPointsTotal + $workedPointsResult[$i]['points'];
	}
	echo $workedPointsTotal;
}

function loadAmountOfPasses($user_id)
{
	$amountOfPasses = DBQuery::sql("SELECT event_type_id FROM event 
									WHERE id IN
										(SELECT event_id FROM work_slot 
										WHERE id IN 
											(SELECT work_slot_id FROM user_work
											WHERE user_id = '$user_id')) AND event_type_id != 5
									");
	echo count($amountOfPasses);
}

function loadAmountOfMeetings($user_id)
{
	$amountOfMeetings = DBQuery::sql("SELECT event_type_id FROM event 
									WHERE id IN
										(SELECT event_id FROM work_slot 
										WHERE id IN 
											(SELECT work_slot_id FROM user_work
											WHERE user_id = '$user_id')) AND event_type_id = 5
									");
	echo count($amountOfMeetings);
}

?>