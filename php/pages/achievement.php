<?php

function loadAchievement()
{
	$achievement_id = $_GET['id'];
	$achievements = DBQuery::sql("SELECT id, name, description, points, icon FROM achievement
								WHERE id = '$achievement_id'");
	?>
		<h1>
			<a href="" data-toggle="tooltip" data-placement="bottom" title="<?php echo $achievements[0]['description'];?>"> 
				<i class="<?php echo $achievements[0]['icon'];?>"></i>
			</a>
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

?>