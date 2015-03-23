<?php
loadTitleForBrowser('Achievements');

function updateAchievementPoints()
{
	$users = DBQuery::sql("SELECT name, last_name, id, achievement_points FROM user");

	for($i = 0; $i < count($users); ++$i)
	{
		$total_achievement_points = 0;
		$user_id = $users[$i]['id'];
		$achievements_unlocked = DBQuery::sql("SELECT achievement_id, user_id FROM achievement_unlocked
										WHERE user_id = '$user_id'");

		for($j = 0; $j < count($achievements_unlocked); ++$j)
		{
			$achievement_id = $achievements_unlocked[$j]['achievement_id'];
			$achievement = DBQuery::sql("SELECT points FROM achievement
										WHERE id = '$achievement_id'");
			$total_achievement_points = $total_achievement_points + $achievement[0]['points'];
		}
		DBQuery::sql("UPDATE user
			  SET achievement_points = '$total_achievement_points'
			  WHERE id='$user_id'");
	}
}

function loadTop10()
{
	updateAchievementPoints();
	$users = DBQuery::sql("SELECT name, last_name, id, achievement_points FROM user 
						ORDER BY achievement_points DESC");
	$howMany = count($users);
	for($j = 0; $j < $howMany; ++$j)
	{
		?>
		<tr>
			<td><?php echo $j+1;?></td>
			<td><?php echo '<a href=?page=browseUserAchievements&id='.$users[$j]['id'].'>'.$users[$j]['name'].' '.$users[$j]['last_name'].'</td>'; ?>
			<td><span class="fa fa-diamond fa-fw fa-lg"></span> <?php echo $users[$j]['achievement_points']; ?></td>
		</tr>
		<?php
	}
}

function loadAchievements()
{
	$achievements = DBQuery::sql("SELECT id, name, description, points, icon FROM achievement
						ORDER BY name");
	$howMany = count($achievements);
	for($i = 0; $i < $howMany; ++$i)
	{
		?>
				<a href="?page=achievement&id=<?php echo $achievements[$i]['id'];?>" class="list-group-item black-link" data-toggle="tooltip" data-placement="bottom" title="<?php echo $achievements[$i]['description'];?>"> 
					<i class="<?php echo $achievements[$i]['icon'];?>"></i>
				    <span class="badge on-top-of-element"><?php echo $achievements[$i]['points'];?></span>
					<?php echo $achievements[$i]['name'];?>
				</a>
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