<?php

session_start();
include_once('DBQuery.php');

$user_id = $_SESSION['user_id'];
$notifications = DBQuery::sql("SELECT id, user_id, notification_type, info, seen, date FROM notification
									WHERE user_id = '$user_id'
									ORDER BY date DESC");

for($i = 0; $i < count($notifications) && $i < 6; ++$i)
{
	$info = $notifications[$i]['info'];
	$type_id = $notifications[$i]['notification_type'];
	$notification_type = DBQuery::sql("SELECT type FROM notification_type
									WHERE id = '$type_id'");

	$notification_id = $notifications[$i]['id'];
	$unseen_notification = DBQuery::sql("SELECT id FROM notification
									WHERE seen IS NULL
									AND id = '$notification_id'");

	if($notification_type[0]['type'] == 'Achievement')
	{
		$achievement = DBQuery::sql("SELECT id, name, description, points, icon FROM achievement
								WHERE id = '$info'");
		if(count($achievement) > 0)
		{
			echo '<a href="?page=achievement&id='.$info.'"class="list-group-item with-thumbnail black-link';
			if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			
			echo 'Du låste upp ';
			echo '<i class="'.$achievement[0]['icon'].'"></i>';
			echo '<span class="badge on-top-of-element">'.$achievement[0]['points'].'</span>';
			echo $achievement[0]['name'].'.';

			echo '</br><span class="time">'.$notifications[$i]['date'].'</span>';
			echo '</a>';
		}
		else
		{
			echo '<a class="list-group-item with-thumbnail black-link">
				<i>Det verkar som att det här inlägget är borttaget.</i></a>';
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
			
			echo '<a href="?page=event&id='.$event_id.'"class="list-group-item with-thumbnail black-link';
			if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			echo loadAvatarFromUser($user[0]['id'], 25).$user[0]['name'].' '.$user[0]['last_name'];
			echo ' har avbokat sig från sitt ';
			echo $group[0]['name'].'-pass';

			echo ' i ';
			echo $event[0]['name'].'.';

			echo '</br><span class="time">'.$notifications[$i]['date'].'</span>';
			echo '</a>';
		}
		else
		{
			echo '<a class="list-group-item with-thumbnail black-link">
				<i>Det verkar som att det här inlägget är borttaget.</i></a>';
		}
	}
	else if($notification_type[0]['type'] == 'DA-lapp')
	{
		$da_note = DBQuery::sql("SELECT user_id, event_id FROM da_note
								WHERE id = '$info'");

		if(count($da_note) > 0)
		{
			$event_id = $da_note[0]['event_id'];
			$user_id = $da_note[0]['user_id'];
			$event = DBQuery::sql("SELECT name FROM event
									WHERE id = '$event_id'");

			$user = DBQuery::sql("SELECT id, name, last_name FROM user
									WHERE id = '$user_id'");

			echo '<a href="?page=DANote&id='.$event_id.'"class="list-group-item with-thumbnail black-link';
			if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			echo loadAvatarFromUser($user[0]['id'], 25).$user[0]['name'].' '.$user[0]['last_name'];
			echo ' har skrivit en ';
			echo '<span class="fa fa-key fa-fw fa-lg"></span>';
			echo 'DA-lapp.';

			echo '</br><span class="time">'.$notifications[$i]['date'].'</span>';
			echo '</a>';
		}
		else
		{
			echo '<a class="list-group-item with-thumbnail black-link">
				<i>Det verkar som att det här inlägget är borttaget.</i></a>';
		}
	}
	else if($notification_type[0]['type'] == 'Hovis-lapp')
	{
		$headwaiter_note = DBQuery::sql("SELECT user_id, event_id FROM headwaiter_note
								WHERE id = '$info'");

		if(count($headwaiter_note) > 0)
		{
			$event_id = $headwaiter_note[0]['event_id'];
			$user_id = $headwaiter_note[0]['user_id'];
			$event = DBQuery::sql("SELECT name FROM event
									WHERE id = '$event_id'");

			$user = DBQuery::sql("SELECT id, name, last_name FROM user
									WHERE id = '$user_id'");

			echo '<a href="?page=HeadwaiterNote&id='.$event_id.'"class="list-group-item with-thumbnail black-link';
			if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			echo loadAvatarFromUser($user[0]['id'], 25).$user[0]['name'].' '.$user[0]['last_name'];
			echo ' har skrivit en ';
			echo '<span class="fa fa-female fa-fw fa-lg"></span>';
			echo 'Hovis-lapp.';

			echo '</br><span class="time">'.$notifications[$i]['date'].'</span>';
			echo '</a>';
		}
		else
		{
			echo '<a class="list-group-item with-thumbnail black-link">
				<i>Det verkar som att det här inlägget är borttaget.</i></a>';
		}
	}
	else if($notification_type[0]['type'] == 'Uppgradering')
	{
		$group_id = $info;
		$group = DBQuery::sql("SELECT name, icon FROM work_group
								WHERE id = '$group_id'");

		echo '<a href="?page=group&id='.$info.'&group_id='.$group_id.'"class="list-group-item with-thumbnail black-link';
		if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
		echo 'Din ansökan om att gå med i ';

		if($group[0]['icon'] != '')
			echo '<span class="'.$group[0]['icon'].' list-group-thumbnail group-badge webb"></span>';

		echo $group[0]['name'];
		echo ' har blivit godkänd, grattis!';
		echo '</br><span class="time">'.$notifications[$i]['date'].'</span>';
		echo '</a>';
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
			$group = DBQuery::sql("SELECT name, icon FROM work_group
									WHERE id = '$group_id'");

			$user = DBQuery::sql("SELECT id, name, last_name FROM user
									WHERE id = '$user_id'");
			
			echo '<a href="?page=browseDots&id='.$info.'&group_id='.$group_id.'"class="list-group-item with-thumbnail black-link';
			if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			echo loadAvatarFromUser($user[0]['id'], 25).$user[0]['name'].' '.$user[0]['last_name'];
			echo ' har skrivit en punkt i ';

			if($group[0]['icon'] != '')
				echo '<span class="'.$group[0]['icon'].' list-group-thumbnail group-badge webb"></span>';

			echo $group[0]['name'];
			echo '</br><span class="time">'.$notifications[$i]['date'].'</span>';
			echo '</a>';
		}
		else
		{
			echo '<a class="list-group-item with-thumbnail black-link">
				<i>Det verkar som att det här inlägget är borttaget.</i></a>';
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
			$group = DBQuery::sql("SELECT name, icon FROM work_group
									WHERE id = '$group_id'");

			$user = DBQuery::sql("SELECT id, name, last_name FROM user
									WHERE id = '$user_id'");

			echo '<a href="?page=protocol&id='.$info.'&group_id='.$group_id.'"class="list-group-item with-thumbnail black-link';
			if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			echo loadAvatarFromUser($user[0]['id'], 25).$user[0]['name'].' '.$user[0]['last_name'];
			echo ' har skrivit ett protokoll i ';

			if($group[0]['icon'] != '')
				echo '<span class="'.$group[0]['icon'].' list-group-thumbnail group-badge webb"></span>';

			echo $group[0]['name'];
			echo '</br><span class="time">'.$notifications[$i]['date'].'</span>';
			echo '</a>';
		}
		else
		{
			echo '<a class="list-group-item with-thumbnail black-link">
				<i>Det verkar som att det här inlägget är borttaget.</i></a>';
		}
	}
	else if($notification_type[0]['type'] == 'Kommentar - Event')
	{
		$comment = DBQuery::sql("SELECT event_id, user_id FROM event_comments
								WHERE id = '$info'");

		if(count($comment) > 0)
		{
			$event_id = $comment[0]['event_id'];
			$user_id = $comment[0]['user_id'];
			$event = DBQuery::sql("SELECT id, name FROM event
									WHERE id = '$event_id'");

			$user = DBQuery::sql("SELECT id, name, last_name FROM user
									WHERE id = '$user_id'");

			echo '<a href="?page=event&id='.$event_id.'"class="list-group-item with-thumbnail black-link';
			if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			echo loadAvatarFromUser($user[0]['id'], 25).$user[0]['name'].' '.$user[0]['last_name'];
			echo ' har kommenterat i evenemanget ';

			echo $event[0]['name'];
			echo '</br><span class="time">'.$notifications[$i]['date'].'</span>';
			echo '</a>';
		}
		else
		{
			echo '<a class="list-group-item with-thumbnail black-link">
				<i>Det verkar som att det här inlägget är borttaget.</i></a>';
		}
	}
	else if($notification_type[0]['type'] == 'Ansökan - Portalen')
	{
		echo '<a href="?page=reviseApplications"class="list-group-item with-thumbnail black-link';
		if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
		echo loadAvatarFromUser(-1, 25).$info;
		echo ' har gjort en ansökan till portalen.';

		echo '</br><span class="time">'.$notifications[$i]['date'].'</span>';
		echo '</a>';
	}
	else if($notification_type[0]['type'] == 'Ansökan - Lag')
	{
		$application = DBQuery::sql("SELECT id, group_id, user_id FROM group_application
										WHERE id = '$info'");
		if(count($application) > 0)
		{
			$group_id = $application[0]['group_id'];
			$group = DBQuery::sql("SELECT name, icon FROM work_group
										WHERE id = '$group_id'");

			$user_id = $application[0]['user_id'];
			$user = DBQuery::sql("SELECT id, name, last_name FROM user
										WHERE id = '$user_id'");

			echo '<a href="?page=group&id='.$group_id.'" class="list-group-item with-thumbnail black-link';
			if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			echo loadAvatarFromUser($user[0]['id'], 25).$user[0]['name'].' '.$user[0]['last_name'];
			echo ' har sökt till ditt lag ';

			if($group[0]['icon'] != '')
				echo '<span class="'.$group[0]['icon'].' list-group-thumbnail group-badge webb"></span>';

			echo $group[0]['name'];
			echo '</br><span class="time">'.$notifications[$i]['date'].'</span>';
			echo '</a>';
		}
		else
		{
			echo '<a class="list-group-item with-thumbnail black-link">
				<i>Det verkar som att det här inlägget är borttaget.</i></a>';
		}
	}
	else if($notification_type[0]['type'] == 'Kommentar - DA-lapp')
	{
		$da_note_comments = DBQuery::sql("SELECT user_id, da_note_id FROM da_note_comments
								WHERE id = '$info'");

		if(count($da_note_comments) > 0)
		{
			$da_note_id = $da_note_comments[0]['da_note_id'];
			$user_id = $da_note_comments[0]['user_id'];
			$da_note = DBQuery::sql("SELECT user_id, event_id FROM da_note
								WHERE id = '$da_note_id'");

			$event_id = $da_note[0]['event_id'];
			$event = DBQuery::sql("SELECT id, name FROM event
									WHERE id = '$event_id'");

			$user = DBQuery::sql("SELECT id, name, last_name FROM user
									WHERE id = '$user_id'");

			echo '<a href="?page=DANote&id='.$event_id.'"class="list-group-item with-thumbnail black-link';
			if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			echo loadAvatarFromUser($user[0]['id'], 25).$user[0]['name'].' '.$user[0]['last_name'];
			echo ' har kommenterat i ';
			echo '<span class="fa fa-key fa-fw fa-lg"></span>';
			echo 'DA-lappen ';

			echo $event[0]['name'];
			echo '</br><span class="time">'.$notifications[$i]['date'].'</span>';
			echo '</a>';
		}
		else
		{
			echo '<a class="list-group-item with-thumbnail black-link">
				<i>Det verkar som att det här inlägget är borttaget.</i></a>';
		}
	}
	else if($notification_type[0]['type'] == 'Kommentar - Hovis-lapp')
	{
		$headwaiter_comment = DBQuery::sql("SELECT user_id, headwaiter_note_id FROM headwaiter_note_comments
								WHERE id = '$info'");

		if(count($headwaiter_comment) > 0)
		{
			$headwaiter_note_id = $headwaiter_comment[0]['headwaiter_note_id'];
			$user_id = $headwaiter_comment[0]['user_id'];
			$headwaiter_note = DBQuery::sql("SELECT user_id, event_id FROM headwaiter_note
								WHERE id = '$headwaiter_note_id'");

			$event_id = $headwaiter_note[0]['event_id'];
			$event = DBQuery::sql("SELECT id, name FROM event
									WHERE id = '$event_id'");

			$user = DBQuery::sql("SELECT id, name, last_name FROM user
									WHERE id = '$user_id'");

			echo '<a href="?page=headwaiterNote&id='.$event_id.'"class="list-group-item with-thumbnail black-link';
			if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			echo loadAvatarFromUser($user[0]['id'], 25).$user[0]['name'].' '.$user[0]['last_name'];
			echo ' har kommenterat i ';
			echo '<span class="fa fa-female fa-fw fa-lg"></span>';
			echo 'Hovis-lappen ';

			echo $event[0]['name'];
			echo '</br><span class="time">'.$notifications[$i]['date'].'</span>';
			echo '</a>';
		}
		else
		{
			echo '<a class="list-group-item with-thumbnail black-link">
				<i>Det verkar som att det här inlägget är borttaget.</i></a>';
		}
	}
	// DBQuery::sql("UPDATE notification
	// 	SET seen = 1
	// 	WHERE id='$notification_id'");
}
echo '<li role="presentation"><a role="menuitem" href="?page=browseUserNotifications&user_id='.$_SESSION['user_id'].'"><span class="fa fa-globe fa-fw"></span> Alla händelser</a></li>';

//general.php
function loadAvatarFromUser($user_id, $size)
{
	$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$user_id' AND avatar IS NOT NULL");
	if(count($results) == 0)
	{
		return '<img src="img/avatars/no_face_small.png" width="'.$size.'" height="'.$size.'" class="img-circle">';
	}
	return '<img src="img/avatars/'.$results[0]['avatar'].'" width="'.$size.'" height="'.$size.'" class="img-circle">';
}

?>