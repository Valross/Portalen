<?php

function loadAchievementsUnlocked()
{
	$user_id = $_GET['id'];
	$achievements_unlocked = DBQuery::sql("SELECT achievement_id, user_id, date_unlocked FROM achievement_unlocked
										WHERE user_id = '$user_id'
										ORDER BY date_unlocked DESC");

	for($i = 0; $i < count($achievements_unlocked); ++$i)
	{
		$achievement_id = $achievements_unlocked[$i]['achievement_id'];
		$achievements = DBQuery::sql("SELECT id, name, description, points, icon FROM achievement
									WHERE id = '$achievement_id'");
		?>
		<tr>
			<td>
				<a href="?page=achievement&id=<?php echo $achievements[0]['id'];?>" data-toggle="tooltip" class="black-link"
					data-placement="bottom" title="<?php echo $achievements[0]['description'];?>"> 
					<i class="<?php echo $achievements[0]['icon'];?>"></i>
				    <span class="badge on-top-of-element"><?php echo $achievements[0]['points'];?></span>
				</a>
				<?php echo $achievements[0]['name'].' ('.$achievements_unlocked[$i]['date_unlocked'].')';?>
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

function loadName()
{
	$user_id = $_GET['id'];

	$user_name = DBQuery::sql("SELECT name, last_name FROM user  
							WHERE id = '$user_id'");

	if(isset($user_name[0]['name'])) 
	{
		loadTitleForBrowser('Upplåsta Achievements - '.$user_name[0]['name']);
		?>
			<a href=<?php echo '?page=userProfile&id='.$user_id; ?>>
		<?php
			echo $user_name[0]['name'].' '.$user_name[0]['last_name'];
		?>
			</a>
		<?php
	}
	else
		echo 'John Doe';
}

function loadAvatarFromId()
{
	$user_id = $_GET['id'];

	$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$user_id' AND avatar IS NOT NULL");
	if(count($results) == 0)
	{
		return 'img/avatars/no_face_small.png';
	}
	return 'img/avatars/'.$results[0]['avatar'];
}

?>