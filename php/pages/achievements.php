<?php

function loadTop10()
{
	$users = DBQuery::sql("SELECT name, last_name, id, achievement_points FROM user 
						ORDER BY achievement_points");
	$howMany = count($users);
	for($j = 0; $j < $howMany; ++$j)
	{
		?>
		<tr>
			<td><?php echo $j+1;?></td>
			<td><?php echo '<a href=?page=userProfile&id='.$users[$j]['id'].'>'.$users[$j]['name'].' '.$users[$j]['last_name'].'</td>'; ?>
			<td><span class="fa fa-diamond fa-fw fa-lg"></span><?php echo $users[$j]['achievement_points']; ?></td>
		</tr>
		<?php
	}
}

function loadAchievements()
{
	$achievements = DBQuery::sql("SELECT id, name, description, points, icon FROM achievement
						ORDER BY id");
	$howMany = count($achievements);
	for($i = 0; $i < $howMany; ++$i)
	{
		?>
		<tr>
			<td>
				<a href="?page=achievement&id=<?php echo $achievements[$i]['id'];?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo $achievements[$i]['description'];?>"> 
					<i class="<?php echo $achievements[$i]['icon'];?>"></i>
				    <span class="badge on-top-of-element"><?php echo $achievements[$i]['points'];?></span>
				</a>
				<?php echo $achievements[$i]['name'];?>
			</td>
		</tr>
		<?php
	}
}

function loadAchievementPoints($user_id)
{
	$achievementPoints = DBQuery::sql("SELECT achievement_points FROM user
	 								WHERE id = '$user_id'");

	echo $achievementPoints[0]['achievement_points'];
}

?>