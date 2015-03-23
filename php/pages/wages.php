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
		$users = DBQuery::sql("SELECT name, last_name, id FROM user
							WHERE id IN
								(SELECT user_id FROM user_work
								WHERE work_slot_id IN
									(SELECT id FROM work_slot
									WHERE wage > 0)
								AND checked = 1)
								ORDER BY id");

		$howMany = count($users);
		for($j = 0; $j < $howMany; ++$j)
		{
			?>
			<tr>
				<td><?php echo $j+1;?></td>
				<td><?php echo '<a href=?page=userProfile&id='.$users[$j]['id'].'>'.$users[$j]['name'].' '.$users[$j]['last_name'].'</td>'; ?>
				<td><?php loadBankNumber($users[$j]['id'], $start, $end); ?></td>
				<td><?php loadHoursOnPayroll($users[$j]['id'], $start, $end); ?></td>
				<td>Nope</td>
				<td><?php loadWorkSlotWage($users[$j]['id'], $start, $end); ?></td>
			</tr>
			<?php
		}
	}
	else
		echo 'Välj datum';
}

function loadUser($user_id, $start, $end)
{
	$workSlotHours = DBQuery::sql("SELECT start_time, end_time FROM work_slot 
									WHERE id IN
										(SELECT work_slot_id FROM user_work WHERE user_id = '$user_id' AND checked = '1')
									AND start_time > '$start' AND end_time < '$end' AND wage > 0
									");

	$users = DBQuery::sql("SELECT name, last_name, id FROM user
							WHERE id IN
								(SELECT user_id FROM user_work
								WHERE work_slot_id IN
									(SELECT id FROM work_slot
									WHERE wage > 0)
								AND user_id = '$user_id')
								ORDER BY id");

	$totalHours = 0;
	for($i = 0; $i < count($users); ++$i)
	{
		if(count($workSlotHours) > 0)
			echo '<td><a href=?page=userProfile&id='.$users[$i]['id'].'>'.$users[$i]['name'].' '.$users[$i]['last_name'].'</td>';
	}
}

function loadBankNumber($user_id, $start, $end)
{
	$bankNumber = DBQuery::sql("SELECT bank_account FROM user
								WHERE id = $user_id");
	echo $bankNumber[0]['bank_account'];
}

function loadHoursOnPayroll($user_id, $start, $end)
{
	$workSlotHours = DBQuery::sql("SELECT start_time, end_time FROM work_slot 
									WHERE id IN
										(SELECT work_slot_id FROM user_work WHERE user_id = '$user_id' AND checked = '1')
									AND start_time > '$start' AND end_time < '$end' AND wage > 0
									");

	$totalHours = 0;
	for($i = 0; $i < count($workSlotHours); ++$i)
	{
		$eventStart = new DateTime($workSlotHours[$i]['start_time']);
		$eventEnd = new DateTime($workSlotHours[$i]['end_time']);
		$interval = $eventStart->diff($eventEnd);
		$totalHours = $totalHours + $interval->format('%h') + ($interval->format('%i')/60);
	}
	echo $totalHours;
}

function loadWorkSlotWage($user_id, $start, $end)
{
	$workSlotHours = DBQuery::sql("SELECT start_time, end_time, wage FROM work_slot 
									WHERE id IN
										(SELECT work_slot_id FROM user_work WHERE user_id = '$user_id' AND checked = '1')
									AND start_time > '$start' AND end_time < '$end' AND wage > 0
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

	echo $totalWage.'kr';
}

?>