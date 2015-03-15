<?php

function loadAchievement()
{
	$achievement_id = $_GET['id'];
	$achievements = DBQuery::sql("SELECT id, name, description, points, icon FROM achievement
								WHERE id = '$achievement_id'");
	?>
		<h1>
			<i class="<?php echo $achievements[0]['icon'];?>"></i>
			<?php echo $achievements[0]['name'];?> - <span class="fa fa-diamond fa-fw fa-lg"></span><?php echo $achievements[0]['points'];?>
		</h1>
		<p>
			<?php echo $achievements[0]['description'];?>
		</p>
	<?php
}

function loadAchievementPoints($user_id)
{
	$achievementPoints = DBQuery::sql("SELECT achievement_points FROM user
	 								WHERE id = '$user_id'");

	echo $achievementPoints[0]['achievement_points'];
}

function anyoneUnlockedThisAchievement()
{
	$achievement_id = $_GET['id'];
	$users = DBQuery::sql("SELECT id, name, last_name FROM user
								WHERE id IN
									(SELECT user_id FROM achievement_unlocked
									WHERE achievement_id = '$achievement_id')");
	if(count($users) > 0)
		return true;
	return false;
}

function loadPeopleWhoUnlockedThisAchievement()
{
	$achievement_id = $_GET['id'];
	$users = DBQuery::sql("SELECT id, name, last_name FROM user
								WHERE id IN
									(SELECT user_id FROM achievement_unlocked
									WHERE achievement_id = '$achievement_id')");

	for($j = 0; $j < count($users); ++$j)
	{
		$user_id = $users[$j]['id'];
		$date_unlocked = DBQuery::sql("SELECT date_unlocked FROM achievement_unlocked
									WHERE achievement_id = '$achievement_id'
									AND user_id = '$user_id'");
		?>
		<tr>
			<td><?php echo $j+1;?></td>
			<td><?php echo '<a href=?page=userProfile&id='.$users[$j]['id'].'>'.$users[$j]['name'].' '.$users[$j]['last_name'].'</td>'; ?>
			<td>(<?php echo $date_unlocked[0]['date_unlocked']; ?>)</td>
		</tr>
		<?php
	}
}
?>