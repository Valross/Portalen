<?php
loadTitleForBrowser('Statistiklista');

function loadStats()
{
	$query = DBQuery::sql("SELECT SUM(work_slot.points) AS total_points, SUM(work_slot.points * (user_work.checked = 1)) AS worked_points,
			COUNT(user_work.user_id) AS total_passes,
			SUM(user_work.checked = 1) AS checked_passes,
			(SUM(work_slot.points * (user_work.checked = 1)) / SUM(user_work.checked = 1)) AS average_points,
			MAX(work_slot.points) AS highestPoint, user_work.user_id AS id
			FROM user_work
			  	JOIN work_slot ON user_work.work_slot_id = work_slot.id
			GROUP BY user_work.user_id
			ORDER BY total_points DESC"); 

	for($j = 0; $j < count($query); ++$j)
	{
		$user_id = $query[$j]['id'];
		$user = DBQuery::sql("SELECT name, last_name, id FROM user 
							WHERE id = '$user_id'");
		echo '<tr>';
			echo '<td>'.($j+1).'</td>';
			echo '<td><a href=?page=userProfile&id='.$user_id.'>'.$user[0]['name'].' '.$user[0]['last_name'].'</td>';
			echo '<td>'.$query[$j]['total_points'].'</td>';
			echo '<td>'.$query[$j]['worked_points'].'</td>';
			echo '<td>'.$query[$j]['checked_passes'].'</td>';
			echo '<td>'.$query[$j]['average_points'].'</td>';
		echo '</tr>';
	}
}

// function loadBookedPoints($user_id)
// {
// 	$bookedPointsResult = DBQuery::sql("SELECT points FROM work_slot 
// 									WHERE event_id IN
// 										(SELECT id FROM event WHERE period_id IN 
// 											(SELECT id FROM period)
// 										) 
// 									AND id IN
// 										(SELECT work_slot_id FROM user_work WHERE user_id = '$user_id')
// 									");

// 	$bookedPointsTotal = 0;
// 	if(count($bookedPointsResult) > 0)
// 	{
// 		for($i = 0; $i < count($bookedPointsResult); ++$i)
// 			$bookedPointsTotal = $bookedPointsTotal + $bookedPointsResult[$i]['points'];
// 	}
// 	echo $bookedPointsTotal;
// }

// function loadWorkedPoints($user_id)
// {
// 	$workedPointsResult = DBQuery::sql("SELECT points FROM work_slot 
// 									WHERE event_id IN
// 										(SELECT id FROM event WHERE period_id IN 
// 											(SELECT id FROM period)
// 										) 
// 									AND id IN
// 										(SELECT work_slot_id FROM user_work WHERE user_id = '$user_id' AND checked = '1')
// 									");
// 	$workedPointsTotal = 0;
// 	if(count($workedPointsResult) > 0)
// 	{
// 		for($i = 0; $i < count($workedPointsResult); ++$i)
// 			$workedPointsTotal = $workedPointsTotal + $workedPointsResult[$i]['points'];
// 	}
// 	echo $workedPointsTotal;
// }

// function loadAmountOfPasses($user_id)
// {
// 	$amountOfPasses = DBQuery::sql("SELECT event_type_id FROM event 
// 									WHERE id IN
// 										(SELECT event_id FROM work_slot 
// 										WHERE id IN 
// 											(SELECT work_slot_id FROM user_work
// 											WHERE user_id = '$user_id')) AND event_type_id != 5
// 									");
// 	echo count($amountOfPasses);
// }

// function loadAmountOfMeetings($user_id)
// {
// 	$amountOfMeetings = DBQuery::sql("SELECT event_type_id FROM event 
// 									WHERE id IN
// 										(SELECT event_id FROM work_slot 
// 										WHERE id IN 
// 											(SELECT work_slot_id FROM user_work
// 											WHERE user_id = '$user_id')) AND event_type_id = 5
// 									");
// 	echo count($amountOfMeetings);
// }

?>