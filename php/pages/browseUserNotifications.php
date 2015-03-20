<?php

function loadNotificationsDebug()
{
	$user_id = $_GET['user_id'];
	$notifications = DBQuery::sql("SELECT id, user_id, notification_type, info, seen, date FROM notification
										WHERE user_id = '$user_id'
										ORDER BY date DESC");

	for($i = 0; $i < count($notifications) && $i < 5; ++$i)
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

	$unseen_notifications = DBQuery::sql("SELECT id FROM notification
										WHERE user_id = '$user_id' AND seen IS NULL");

	for($i = 0; $i < count($unseen_notifications); ++$i)
	{
		$id = $unseen_notifications[$i]['id'];
		DBQuery::sql("UPDATE notification
			  SET seen = 1
			  WHERE id='$id'");
	}

	for($i = 0; $i < count($notifications) && $i < 20; ++$i)
	{
		$info = $notifications[$i]['info'];
		$type_id = $notifications[$i]['notification_type'];
		$notification_type = DBQuery::sql("SELECT type FROM notification_type
										WHERE id = '$type_id'");

		$notification_id = $notifications[$i]['id'];
		$unseen_notification = DBQuery::sql("SELECT id FROM notification
										WHERE user_id = '$user_id' AND seen IS NULL
										AND id = '$notification_id'");
		echo '<div class="col-sm-7">';
		if(count($unseen_notification) == 0)
			echo 	'<div class="white-box">';
		else
			echo 	'<div class="white-box red">';
		echo '<h2>'.$notification_type[0]['type'].'</h2>';
		echo '<div class="news-info">';

		if($notification_type[0]['type'] == 'Achievement')
		{
			$achievement = DBQuery::sql("SELECT id, name, description, points, icon FROM achievement
									WHERE id = '$info'");
			if(count($slot) > 0)
			{			
				echo '<span>';
				echo $achievement[0]['name'];
				echo '</span>';

				echo '<span class="time"> - '.$notifications[$i]['date'].'</span></div>';
				echo '<p>Du låste upp ';
				echo '<a href="?page=achievement&id='.$achievement[0]['id'].'" ';
				echo 'class="black-link" data-toggle="tooltip" 
							data-placement="bottom" title="'.$achievement[0]['description'].'">';
				echo '<i class="'.$achievement[0]['icon'].'"></i>';
				echo '<span class="badge on-top-of-element">'.$achievement[0]['points'].'</span>'.
						$achievement[0]['name'].'</a></p>.';
			}
			else
			{
				echo '<p><i>Det verkar som att det här inlägget är borttaget.</i></p>';
				echo '</div>';
			}
		}
		else if($notification_type[0]['type'] == 'Avbokning')
		{
			$slot = DBQuery::sql("SELECT event_id, group_id, start_time FROM work_slot
									WHERE id = '$info'");

			if(count($slot) > 0)
			{
				$info_user_id = strchr($info," "); //Gives second part of the string
				$event_id = $slot[0]['event_id'];
				$group_id = $slot[0]['group_id'];
				$group = DBQuery::sql("SELECT name FROM work_group
										WHERE id = '$group_id'");
				
				$event = DBQuery::sql("SELECT id, name FROM event
										WHERE id = '$event_id'");

				$user = DBQuery::sql("SELECT id, name, last_name FROM user
										WHERE id = '$info_user_id'");
							
				echo '<span>';
				echo $event[0]['name'];
				echo '</span>';
				
				echo '<span class="time"> - '.$notifications[$i]['date'].'</span></div>';
				echo '<p>Avbokning på ';
				echo '<a href="?page=event&id='.$event[0]['id'].'" ';
				echo 'class="">'.$event[0]['name'].'</a>';
				echo ' från <a href="?page=group&id='.$group_id.'">'.$group[0]['name'].'</a>';
				echo ' av <a href="?page=userProfile&id='.$info_user_id.'">'.$user[0]['name'].' '.$user[0]['last_name'].'</a></p>';
			}
			else
			{
				echo '<p><i>Det verkar som att det här inlägget är borttaget.</i></p>';
				echo '</div>';
			}
		}
		else if($notification_type[0]['type'] == 'Punkt')
		{
			$dot = DBQuery::sql("SELECT comment, group_id, user_id FROM dot
									WHERE id = '$info'");

			if(count($dot) > 0)
			{
				$comment = $dot[0]['comment'];
				$group_id = $dot[0]['group_id'];
				$user_id = $dot[0]['user_id'];
				$group = DBQuery::sql("SELECT name FROM work_group
										WHERE id = '$group_id'");

				$user = DBQuery::sql("SELECT id, name, last_name FROM user
										WHERE id = '$user_id'");
				
				echo '<span class="time">'.$notifications[$i]['date'].'</span></div>';
				echo '<p><a href="?page=userProfile&id='.$user_id.'">'.$user[0]['name'].' '.$user[0]['last_name'].'</a>';
				echo ' har skrivit en punkt i ';
				echo '<a href="?page=dot&id='.$info.'&group_id='.$group_id.'" ';
				echo 'class="">'.$group[0]['name'].'</a>';
				echo ' för <a href="?page=group&id='.$group_id.'">'.$group[0]['name'].'</a></p>';
			}
			else
			{
				echo '<p><i>Det verkar som att det här inlägget är borttaget.</i></p>';
				echo '</div>';
			}
		}
		else if($notification_type[0]['type'] == 'Protokoll')
		{
			$protocol = DBQuery::sql("SELECT group_id, title, user_id FROM protocol
									WHERE id = '$info'");

			if(count($protocol) > 0)
			{
				$title = $protocol[0]['title'];
				$group_id = $protocol[0]['group_id'];
				$user_id = $protocol[0]['user_id'];
				$group = DBQuery::sql("SELECT name FROM work_group
										WHERE id = '$group_id'");

				$user = DBQuery::sql("SELECT id, name, last_name FROM user
										WHERE id = '$user_id'");
							
				echo '<span>';
				echo $title;
				echo '</span>';
				
				echo '<span class="time"> - '.$notifications[$i]['date'].'</span></div>';
				echo '<p>Nytt protokoll ';
				echo '<a href="?page=protocol&id='.$info.'&group_id='.$group_id.'" ';
				echo 'class="">'.$title.'</a>';
				echo ' i <a href="?page=group&id='.$group_id.'">'.$group[0]['name'].'</a>';
				echo ' av <a href="?page=userProfile&id='.$user_id.'">'.$user[0]['name'].' '.$user[0]['last_name'].'</a></p>';
			}
			else
			{
				echo '<p><i>Det verkar som att det här inlägget är borttaget.</i></p>';
				echo '</div>';
			}
		}
		else
			echo '</div>';

		echo    '</div>
			 </div>';
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