<?php
loadTitleForBrowser('Löner');

function loadStats()
{
	$start = '';
	$end = '';

	if(isset($_POST['submit']))
	{
		if($_POST['start'] != '') 
		{
			$start = $_POST['start'];
		}
		if($_POST['end'] != '') 
		{
			$end = $_POST['end'];
		}
	}

	if(isset($_POST['submit']) && $_POST['start'] != '' && $_POST['end'] != '')
	{
		$users = DBQuery::sql("SELECT start_time, end_time, wage, user_id FROM work_slot 
							INNER JOIN user_work ON user_work.work_slot_id = work_slot.id
							WHERE id IN
								(SELECT work_slot_id FROM user_work WHERE checked = '1')
							AND start_time > '$start' AND end_time < '$end' AND wage > 0
							GROUP BY wage, user_id
							ORDER BY user_id
							");

		$howMany = count($users);
		for($j = 0; $j < $howMany; ++$j)
		{
			echo '<tr>';
				echo '<td>'.($j+1).'</td>';
				echo '<td><a href=?page=userProfile&id='.$users[$j]['user_id'].'>'.loadNameFromUser($users[$j]['user_id']).'</td>';
				echo '<td>'.loadBankNumber($users[$j]['user_id'], $start, $end).'</td>';
				echo '<td>'.loadHoursOnPayroll($users[$j]['user_id'], $start, $end, $users[$j]['wage']).'</td>';
				echo '<td>'.$users[$j]['wage'].'</td>';
				echo '<td>'.loadWorkSlotWage($users[$j]['user_id'], $start, $end, $users[$j]['wage']).'</td>';
			echo '</tr>';
		}
	}
	else
		echo 'Välj datum';
}

function loadBankNumber($user_id, $start, $end)
{
	$bankNumber = DBQuery::sql("SELECT bank_account FROM user
								WHERE id = $user_id");
	return $bankNumber[0]['bank_account'];
}

function loadHoursOnPayroll($user_id, $start, $end, $wage)
{
	$workSlotHours = DBQuery::sql("SELECT start_time, end_time FROM work_slot 
									WHERE id IN
										(SELECT work_slot_id FROM user_work WHERE user_id = '$user_id' AND checked = '1')
									AND start_time > '$start' AND end_time < '$end' AND wage = '$wage'
									");

	$totalHours = 0;
	for($i = 0; $i < count($workSlotHours); ++$i)
	{
		$eventStart = new DateTime($workSlotHours[$i]['start_time']);
		$eventEnd = new DateTime($workSlotHours[$i]['end_time']);
		$interval = $eventStart->diff($eventEnd);
		$totalHours = $totalHours + $interval->format('%h') + ($interval->format('%i')/60);
	}
	return $totalHours;
}

function loadWorkSlotWage($user_id, $start, $end, $wage)
{
	$workSlotHours = DBQuery::sql("SELECT start_time, end_time, wage FROM work_slot 
									WHERE id IN
										(SELECT work_slot_id FROM user_work WHERE user_id = '$user_id' AND checked = '1')
									AND start_time > '$start' AND end_time < '$end' AND wage = '$wage'
									GROUP BY wage
									");

	$totalHours = 0;
	$totalWage = 0;
	for($i = 0; $i < count($workSlotHours); ++$i)
	{
		$eventStart = new DateTime($workSlotHours[$i]['start_time']);
		$eventEnd = new DateTime($workSlotHours[$i]['end_time']);
		$interval = $eventStart->diff($eventEnd);
		$totalHours = $totalHours + $interval->format('%h') + ($interval->format('%i')/60);
		$totalWage = $totalWage + $workSlotHours[$i]['wage']*$interval->format('%h') + $workSlotHours[$i]['wage']*($interval->format('%i')/60);
	}

	return $totalWage.'kr';
}

?>