<?php

function loadTop10()
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
			<td><?php loadAchievementPoints($users[$j]['id']); ?></td>
		</tr>
		<?php
	}
}

function loadAchievementPoints($user_id)
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

?>