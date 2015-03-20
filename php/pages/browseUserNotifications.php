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

	for($i = 0; $i < count($notifications) && $i < 20; ++$i)
	{
		$info = $notifications[$i]['info'];
		$type_id = $notifications[$i]['notification_type'];
		$notification_type = DBQuery::sql("SELECT type FROM notification_type
										WHERE id = '$type_id'");

		echo '<div class="col-sm-7">
					<div class="white-box">';
		echo '<h2>'.$notification_type[0]['type'].'</h2>';
		echo '<div class="news-info"><span>';

		if($notification_type[0]['type'] == 'Achievement')
		{
			$achievement = DBQuery::sql("SELECT id, name, description, points, icon FROM achievement
									WHERE id = '$info'");
						
			echo $achievement[0]['name'];
			
			echo '</span><span class="time"> - '.$notifications[$i]['date'].'</span></div>';
			echo '<p>Du låste upp ';
			echo '<a href="?page=achievement&id='.$achievement[0]['id'].'" ';
			echo 'class="black-link" data-toggle="tooltip" 
						data-placement="bottom" title="'.$achievement[0]['description'].'">';
			echo '<i class="'.$achievement[0]['icon'].'"></i>';
			echo '<span class="badge on-top-of-element">'.$achievement[0]['points'].'</span>'.
					$achievement[0]['name'].'</a>.';
		}
		else if($notification_type[0]['type'] == 'Avbokning')
		{
			$slot = DBQuery::sql("SELECT event_id, group_id, start_time FROM work_slot
									WHERE id = '$info'");

			$info_user_id = strchr($info," "); //Gives second part of the string
			$event_id = $slot[0]['event_id'];
			$group_id = $slot[0]['group_id'];
			$group = DBQuery::sql("SELECT name FROM work_group
									WHERE id = '$group_id'");
			
			$event = DBQuery::sql("SELECT id, name FROM event
									WHERE id = '$event_id'");

			$user = DBQuery::sql("SELECT id, name, last_name FROM user
									WHERE id = '$info_user_id'");
						
			echo $event[0]['name'];
			
			echo '</span><span class="time"> - '.$notifications[$i]['date'].'</span></div>';
			echo '<p>Avbokning på ';
			echo '<a href="?page=event&id='.$event[0]['id'].'" ';
			echo 'class="">'.$event[0]['name'].'</a>';
			echo ' från <a href="?page=group&id='.$group_id.'">'.$group[0]['name'].'</a>';
			echo ' av <a href="?page=userProfile&id='.$info_user_id.'">'.$user[0]['name'].' '.$user[0]['last_name'].'</a>';
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