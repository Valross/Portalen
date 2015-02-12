<?php

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
			<td><?php echo $users[$j]['name'].' '.$users[$j]['last_name']; ?></td>
			<td><?php loadBookedPoints(); ?></td>
			<td><?php loadWorkedPoints($j); ?></td>
			<td><?php loadAmountOfPasses(); ?></td>
			<td><?php loadAmountOfMeetings(); ?></td>
		</tr>
		<?php
	}
}

function loadBookedPoints()
{
	$bookedPointsResult = DBQuery::sql	("SELECT points FROM work_slot WHERE event_id IN
										(SELECT id FROM event WHERE period_id IN 
											(SELECT id FROM period)
										) 
									AND id IN
										(SELECT work_slot_id FROM user_work WHERE user_id = '$_SESSION[user_id]' AND checked = '0')
									");
	$bookedPointsTotal = 0;
	if(count($bookedPointsResult) > 0)
	{
		for($i = 0; $i < count($bookedPointsResult); ++$i)
			$bookedPointsTotal = $bookedPointsTotal + $bookedPointsResult[$i]['points'];
	}
	echo $bookedPointsTotal;
}

function loadWorkedPoints($j)
{
	$workedPointsResult = DBQuery::sql	("SELECT points FROM work_slot WHERE event_id IN
										(SELECT id FROM event WHERE period_id IN 
											(SELECT id FROM period)
										) 
									AND id IN
										(SELECT work_slot_id FROM user_work WHERE user_id = '$_SESSION[user_id]' AND checked = '1')
									");
	if(count($workedPointsResult) > 0)
	{
		$workedPointsTotal = 0;

		for($i = 0; $i < count($workedPointsResult); ++$i)
			$workedPointsTotal = $workedPointsTotal + $workedPointsResult[$i]['points'];

		echo $workedPointsTotal;
	}
}

function loadAmountOfPasses()
{
	$amountOfPasses = DBQuery::sql 		("SELECT points FROM work_slot WHERE event_id IN
										(SELECT id FROM event WHERE period_id IN 
											(SELECT id FROM period)
										) 
									AND id IN
										(SELECT work_slot_id FROM user_work WHERE user_id = '$_SESSION[user_id]' AND points > 0)
									");
	echo count($amountOfPasses);
}

function loadAmountOfMeetings()
{
	$amountOfMeetings = DBQuery::sql 		("SELECT points FROM work_slot WHERE event_id IN
										(SELECT id FROM event WHERE period_id IN 
											(SELECT id FROM period)
										) 
									AND id IN
										(SELECT work_slot_id FROM user_work WHERE user_id = '$_SESSION[user_id]' AND points = 0)
									");
	echo count($amountOfMeetings);
}

?>