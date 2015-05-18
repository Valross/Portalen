<?php

session_start();
include_once($_SERVER['DOCUMENT_ROOT'] . '/Portalen/php/general.php');

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
			
			// EJ KLAR WOOP
			
			echo '<a href="?page=achievement&id='.$info.'&notified='.$notification_id.'" class="list-group-item with-thumbnail black-link';
			if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			echo '<i class="fa fa-fw fa-diamond fa-lg list-group-thumbnail group-badge"></i>';
			// echo '<span class="badge on-top-of-element">'.$achievement[0]['points'].'</span>';
			
			echo '<span class="message">Du låste upp <strong>';
			echo $achievement[0]['name'].'</strong>.';

			echo '</br><i class="time">'.$notifications[$i]['date'].'</i></span>';
			echo '</a>';
		}
		else
		{
			echo '<a class="list-group-item with-thumbnail black-link">
				<i>Händelsen kunde inte hittas.</i></a>';
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
			
			echo '<a href="?page=event&id='.$event_id.'&notified='.$notification_id.'"class="list-group-item with-thumbnail black-link';
			if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			echo loadAvatarFromUserAsNotification($user[0]['id'], 32).'<span class="message"><strong>'.$user[0]['name'].' '.$user[0]['last_name'];
			echo '</strong> har avbokat sig från sitt ';
			echo $group[0]['name'].'-pass';

			echo ' i <strong>';
			echo $event[0]['name'].'</strong>.';

			echo '</br><i class="time">'.$notifications[$i]['date'].'</i></span>';
			echo '</a>';
		}
		else
		{
			echo '<a class="list-group-item with-thumbnail black-link">
				<i>Händelsen kunde inte hittas.</i></a>';
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

			echo '<a href="?page=DANote&id='.$event_id.'&notified='.$notification_id.'"class="list-group-item with-thumbnail black-link';
			if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			echo loadAvatarFromUserAsNotification($user[0]['id'], 32).'<span class="message"><strong>'.$user[0]['name'].' '.$user[0]['last_name'].'</strong>';
			echo ' har skrivit en ';
			echo '<span class="fa fa-key fa-fw fa-lg"></span>';
			echo '<strong>DA-lapp</strong>.';

			echo '</br><i class="time">'.$notifications[$i]['date'].'</i></span>';
			echo '</a>';
		}
		else
		{
			echo '<a class="list-group-item with-thumbnail black-link">
				<i>Händelsen kunde inte hittas.</i></a>';
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

			echo '<a href="?page=HeadwaiterNote&id='.$event_id.'&notified='.$notification_id.'"class="list-group-item with-thumbnail black-link';
			if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			echo loadAvatarFromUserAsNotification($user[0]['id'], 32).'<span class="message"><strong>'.$user[0]['name'].' '.$user[0]['last_name'].'</strong>';
			echo ' har skrivit en ';
			echo '<span class="fa fa-female fa-fw fa-lg"></span>';
			echo '<strong>Hovis-lapp</strong>.';

			echo '</br><i class="time">'.$notifications[$i]['date'].'</i></span>';
			echo '</a>';
		}
		else
		{
			echo '<a class="list-group-item with-thumbnail black-link">
				<i>Händelsen kunde inte hittas.</i></a>';
		}
	}
	else if($notification_type[0]['type'] == 'Uppgradering')
	{
		$group_id = $info;
		$group = DBQuery::sql("SELECT name, icon, hex FROM work_group
								WHERE id = '$group_id'");
		

		echo '<a href="?page=group&id='.$info.'&group_id='.$group_id.'&notified='.$notification_id.'"class="list-group-item with-thumbnail black-link';
		if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			if($group[0]['icon'] != '')
				echo '<span class="fa fa-'.$group[0]['icon'].' fa-fw list-group-thumbnail group-badge" style="background: #'.$group[0]['hex'].';"></span>';
			
		echo '<span class="message">Du har blivit tillagd i laget <strong>';
		echo $group[0]['name'];
		echo '</strong>.';
		echo '</br><i class="time">'.$notifications[$i]['date'].'</i></span>';
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
			
			echo '<a href="?page=browseDots&id='.$info.'&group_id='.$group_id.'&notified='.$notification_id.'"class="list-group-item with-thumbnail black-link';
			if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			echo loadAvatarFromUserAsNotification($user[0]['id'], 32).'<span class="message"><strong>'.$user[0]['name'].' '.$user[0]['last_name'];
			echo '</strong> har skrivit en punkt i <strong>';
			echo $group[0]['name'];
			echo '</strong>.</br><i class="time">'.$notifications[$i]['date'].'</i></span>';
			echo '</a>';
		}
		else
		{
			echo '<a class="list-group-item with-thumbnail black-link">
				<i>Händelsen kunde inte hittas.</i></a>';
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

			echo '<a href="?page=protocol&id='.$info.'&group_id='.$group_id.'&notified='.$notification_id.'"class="list-group-item with-thumbnail black-link';
			if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			echo loadAvatarFromUserAsNotification($user[0]['id'], 32).'<span class="message"><strong>'.$user[0]['name'].' '.$user[0]['last_name'];
			echo '</strong> har skrivit ett protokoll i <strong>';
			echo $group[0]['name'];
			echo '</strong></br><i class="time">'.$notifications[$i]['date'].'</i></span>';
			echo '</a>';
		}
		else
		{
			echo '<a class="list-group-item with-thumbnail black-link">
				<i>Händelsen kunde inte hittas.</i></a>';
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

			echo '<a href="?page=event&id='.$event_id.'&notified='.$notification_id.'"class="list-group-item with-thumbnail black-link';
			if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			echo loadAvatarFromUserAsNotification($user[0]['id'], 32).'<span class="message"><strong>'.$user[0]['name'].' '.$user[0]['last_name'];
			echo '</strong> har kommenterat i evenemanget <strong>';
			echo $event[0]['name'];
			echo '</strong></br><i class="time">'.$notifications[$i]['date'].'</i></span>';
			echo '</a>';
		}
		else
		{
			echo '<a class="list-group-item with-thumbnail black-link">
				<i>Händelsen kunde inte hittas.</i></a>';
		}
	}
	else if($notification_type[0]['type'] == 'Ansökan - Portalen')
	{
		echo '<a href="?page=reviseApplications"class="list-group-item with-thumbnail black-link';
		if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
		echo loadAvatarFromUserAsNotification(-1, 32).'<span class="message"><strong>'.$info;
		echo '</strong> har gjort en ansökan till portalen.';

		echo '</br><i class="time">'.$notifications[$i]['date'].'</i></span>';
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

			echo '<a href="?page=group&id='.$group_id.'&notified='.$notification_id.'" class="list-group-item with-thumbnail black-link';
			if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			echo loadAvatarFromUserAsNotification($user[0]['id'], 32).'<span class="message"><strong>'.$user[0]['name'].' '.$user[0]['last_name'];
			echo '</strong> har sökt till ditt lag ';
			echo '<strong>'.$group[0]['name'].'</strong>.';
			echo '</br><i class="time">'.$notifications[$i]['date'].'</i></span>';
			echo '</a>';
		}
		else
		{
			echo '<a class="list-group-item with-thumbnail black-link">
				<i>Händelsen kunde inte hittas.</i></a>';
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

			echo '<a href="?page=DANote&id='.$event_id.'&notified='.$notification_id.'"class="list-group-item with-thumbnail black-link';
			if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			echo loadAvatarFromUserAsNotification($user[0]['id'], 32).'<span class="message"><strong>'.$user[0]['name'].' '.$user[0]['last_name'];
			echo '</strong> har kommenterat i ';
			echo '<span class="fa fa-key fa-fw fa-lg"></span>';
			echo '<strong>DA-lappen</strong> ';

			echo $event[0]['name'];
			echo '</br><i class="time">'.$notifications[$i]['date'].'</i></span>';
			echo '</a>';
		}
		else
		{
			echo '<a class="list-group-item with-thumbnail black-link">
				<i>Händelsen kunde inte hittas.</i></a>';
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

			echo '<a href="?page=headwaiterNote&id='.$event_id.'&notified='.$notification_id.'"class="list-group-item with-thumbnail black-link';
			if(count($unseen_notification) > 0)
				echo ' new-notification';
			echo '">';
			echo loadAvatarFromUserAsNotification($user[0]['id'], 32).'<span class="message"><strong>'.$user[0]['name'].' '.$user[0]['last_name'];
			echo '</strong> har kommenterat i ';
			echo '<span class="fa fa-female fa-fw fa-lg"></span>';
			echo '<strong>Hovis-lappen</strong> ';

			echo $event[0]['name'];
			echo '</br><i class="time">'.$notifications[$i]['date'].'</i></span>';
			echo '</a>';
		}
		else
		{
			echo '<a class="list-group-item with-thumbnail black-link">
				<i>Händelsen kunde inte hittas.</i></a>';
		}
	}
}
echo '<a class="list-group-item" href="?page=browseUserNotifications&user_id='.$_SESSION['user_id'].'" style="text-align: center;"><strong>Alla händelser</strong></a>';

?>