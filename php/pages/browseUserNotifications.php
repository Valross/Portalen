<?php

function loadNotificationsDebug()
{
	$user_id = $_GET['user_id'];
	$notifications = DBQuery::sql("SELECT id, user_id, notification_type, info, seen, date FROM notification
										WHERE user_id = '$user_id'
										ORDER BY date DESC");

	for($i = 0; $i < count($notifications); ++$i)
	{
		$notification_id = $notifications[$i]['id'];
		
		echo '<tr>';
		echo '<td>'.$notification_id.'</td>';
		echo '<td>'.$notifications[$i]['user_id'].'</td>';
		echo '<td>'.$notifications[$i]['notification_type'].'</td>';
		echo '<td>'.$notifications[$i]['info'].'</td>';
		echo '<td>'.$notifications[$i]['seen'].'</td>';
		echo '<td>'.$notifications[$i]['date'].'</td>';
		echo '</tr>';		
	}
}

function loadNotifications()
{
	$user_id = $_GET['user_id'];
	$notifications = DBQuery::sql("SELECT id, user_id, notification_type, info, seen, date FROM notification
										WHERE user_id = '$user_id'
										ORDER BY date DESC");

	for($i = 0; $i < count($notifications); ++$i)
	{
		$info = $notifications[$i]['info'];
		$type_id = $notifications[$i]['notification_type'];
		$notification_type = DBQuery::sql("SELECT type FROM notification_type
										WHERE id = '$type_id'");

		if($notification_type[0]['type'] == 'Achievement')
			$achievement = DBQuery::sql("SELECT id, name, description, points, icon FROM achievement
									WHERE id = '$info'");

		echo '<div class="col-sm-7">
				<div class="white-box">';
					echo '<h2>'.$notification_type[0]['type'].'</h2>';
					echo '<div class="news-info"><span>';
					
					if($notification_type[0]['type'] == 'Achievement')
					{
						echo $achievement[0]['name'];
					}
					
					echo '</span> <span class="time">- '.$notifications[$i]['date'].'</span></div>';
					if($notification_type[0]['type'] == 'Achievement')
					{
						echo '<p>Du låste upp ';
						echo '<a href="?page=achievement&id='.$achievement[$i]['id'].'" ';
						echo 'class="black-link" data-toggle="tooltip" 
									data-placement="bottom" title="'.$achievement[$i]['description'].'">';
						echo '<i class="'.$achievement[$i]['icon'].'"></i>';
						echo '<span class="badge on-top-of-element">'.$achievement[$i]['points'].'</span>'.
								$achievement[$i]['name'].'</a>.';
					}
		echo    '</div>
			 </div>';
	}

	$unseen_notifications = DBQuery::sql("SELECT id FROM notification
										WHERE user_id = '$user_id' AND seen IS NULL");

	for($i = 0; $i < count($unseen_notifications); ++$i)
	{
		$id = $unseen_notifications[$i]['id'];
		DBQuery::sql("UPDATE notification
			  SET seen = 1
			  WHERE id='$id'");
	}
}

function loadName()
{
	$user_id = $_GET['user_id'];

	$user_name = DBQuery::sql("SELECT name, last_name FROM user  
							WHERE id = '$user_id'");

	if(isset($user_name[0]['name'])) 
	{
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
	$user_id = $_GET['user_id'];

	$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$user_id' AND avatar IS NOT NULL");
	if(count($results) == 0)
	{
		return 'img/avatars/no_face_small.png';
	}
	return 'img/avatars/'.$results[0]['avatar'];
}

?>