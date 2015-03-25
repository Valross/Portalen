<?php
loadTitleForBrowser('Händelser');

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
			if(count($achievement) > 0)
			{			
				echo '<span class="time">'.$notifications[$i]['date'].'</span></div>';
				echo '<p>Du låste upp ';
				echo '<a href="?page=achievement&id='.$achievement[0]['id'].'" ';
				echo 'class="black-link" data-toggle="tooltip" 
							data-placement="bottom" title="'.$achievement[0]['description'].'">';
				echo '<i class="'.$achievement[0]['icon'].'"></i>';
				echo '<span class="badge on-top-of-element">'.$achievement[0]['points'].'</span>'.
						$achievement[0]['name'].'</a>.</p>';
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
				
				echo '<span class="time">'.$notifications[$i]['date'].'</span></div>';
				echo '<p>Avbokning på ';
				echo '<a href="?page=event&id='.$event[0]['id'].'" ';
				echo 'class="">'.$event[0]['name'].'</a>';
				echo ' från <a href="?page=group&id='.$group_id.'">'.$group[0]['name'].'</a>';
				echo ' av <a href="?page=userProfile&id='.$info_user_id.'">'.loadAvatarFromUser($user[0]['id'], 25).$user[0]['name'].' '.$user[0]['last_name'].'</a>.</p>';
			}
			else
			{
				echo '<p><i>Det verkar som att det här inlägget är borttaget.</i></p>';
				echo '</div>';
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
				
				echo '<span class="time">'.$notifications[$i]['date'].'</span></div>';
				echo '<p>';
				echo '<a href="?page=userProfile&id='.$user_id.'">'.loadAvatarFromUser($user[0]['id'], 25).$user[0]['name'].' '.$user[0]['last_name'].'</a> ';
				echo ' har skrivit en DA-lapp för <a href="?page=DANote&id='.$event_id.'" ';
				echo 'class="">'.$event[0]['name'].'</a>.';
				echo '</p>';
			}
			else
			{
				echo '<p><i>Det verkar som att det här inlägget är borttaget.</i></p>';
				echo '</div>';
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
				
				echo '<span class="time">'.$notifications[$i]['date'].'</span></div>';
				echo '<p>';
				echo '<a href="?page=userProfile&id='.$user_id.'">'.loadAvatarFromUser($user[0]['id'], 25).$user[0]['name'].' '.$user[0]['last_name'].'</a> ';
				echo ' har skrivit en Hovis-lapp för <a href="?page=HeadwaiterNote&id='.$event_id.'" ';
				echo 'class="">'.$event[0]['name'].'</a>.';
				echo '</p>';
			}
			else
			{
				echo '<p><i>Det verkar som att det här inlägget är borttaget.</i></p>';
				echo '</div>';
			}
		}
		else if($notification_type[0]['type'] == 'Uppgradering')
		{
			$group_id = $info;
			$group = DBQuery::sql("SELECT name FROM work_group
									WHERE id = '$group_id'");
			
			echo '<span class="time">'.$notifications[$i]['date'].'</span></div>';
			echo '<p>Din ansökan om att gå med i <a href="?page=group&id='.$group_id.'">'.$group[0]['name'].'</a> har blivit godkänd, grattis!</p>';
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
				
				echo '<span class="time">'.$notifications[$i]['date'].'</span></div>';
				echo '<p><a href="?page=userProfile&id='.$user_id.'">'.loadAvatarFromUser($user[0]['id'], 25).$user[0]['name'].' '.$user[0]['last_name'].'</a>';
				echo ' har skrivit en ';
				echo '<a href="?page=browseDots&id='.$info.'&group_id='.$group_id.'" ';
				echo 'class="">punkt</a> i ';
				echo '<a href="?page=group&id='.$group_id.'">';

				if($group[0]['icon'] != '')
					echo '<span class="'.$group[0]['icon'].' list-group-thumbnail group-badge webb"></span>';

				echo $group[0]['name'].'</a>.</p>';
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
				
				echo '<span class="time">'.$notifications[$i]['date'].'</span></div>';
				echo '<p>Nytt protokoll ';
				echo '<a href="?page=protocol&id='.$info.'&group_id='.$group_id.'" ';
				echo 'class="">'.$title.'</a>';
				echo ' i <a href="?page=group&id='.$group_id.'">'.$group[0]['name'].'</a>';
				echo ' av <a href="?page=userProfile&id='.$user_id.'">'.loadAvatarFromUser($user[0]['id'], 25).$user[0]['name'].' '.$user[0]['last_name'].'</a>.</p>';
			}
			else
			{
				echo '<p><i>Det verkar som att det här inlägget är borttaget.</i></p>';
				echo '</div>';
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
				
				echo '<span class="time">'.$notifications[$i]['date'].'</span></div>';
				echo '<p>';
				echo '<a href="?page=userProfile&id='.$user_id.'">'.loadAvatarFromUser($user[0]['id'], 25).$user[0]['name'].' '.$user[0]['last_name'].'</a>';
				echo ' har kommenterat i evenemanget ';
				echo '<a href="?page=event&id='.$event[0]['id'].'" class="">'.$event[0]['name'].'</a>.';
				echo '</p>';
			}
			else
			{
				echo '<p><i>Det verkar som att det här inlägget är borttaget.</i></p>';
				echo '</div>';
			}
		}
		else if($notification_type[0]['type'] == 'Ansökan - Portalen')
		{
			echo '<span class="time">'.$notifications[$i]['date'].'</span></div>';
			echo '<p>';
			echo '<a href="?page=reviseApplications" ';
			echo 'class="">'.$info.'</a> har gjort en ansökan till portalen.';
			echo '</p>';
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

				echo '<span class="time">'.$notifications[$i]['date'].'</span></div>';
				echo '<p>';
				echo '<a href="?page=userProfile&id='.$user_id.'">'.loadAvatarFromUser($user[0]['id'], 25).$user[0]['name'].' '.$user[0]['last_name'].'</a>';
				echo ' har gjort en ansökan till ditt lag ';
				echo '<a href="?page=group&id='.$application[0]['group_id'].'" class="">';

				if($group[0]['icon'] != '')
					echo '<span class="'.$group[0]['icon'].' list-group-thumbnail group-badge webb"></span>';

				echo $group[0]['name'].'</a>.';
				echo '</p>';
			}
			else
			{
				echo '<p><i>Det verkar som att det här inlägget är borttaget.</i></p>';
				echo '</div>';
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
				
				echo '<span class="time">'.$notifications[$i]['date'].'</span></div>';
				echo '<p>';
				echo '<a href="?page=userProfile&id='.$user_id.'">'.loadAvatarFromUser($user[0]['id'], 25).$user[0]['name'].' '.$user[0]['last_name'].'</a>';
				echo ' har kommenterat i DA-lappen ';
				echo '<a href="?page=DANote&id='.$event[0]['id'].'" class="">'.$event[0]['name'].'</a>';
				echo '</p>';
			}
			else
			{
				echo '<p><i>Det verkar som att det här inlägget är borttaget.</i></p>';
				echo '</div>';
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
				
				echo '<span class="time">'.$notifications[$i]['date'].'</span></div>';
				echo '<p>';
				echo '<a href="?page=userProfile&id='.$user_id.'">'.loadAvatarFromUser($user[0]['id'], 25).$user[0]['name'].' '.$user[0]['last_name'].'</a>';
				echo ' har kommenterat i Hovis-lappen ';
				echo '<a href="?page=HeadwaiterNote&id='.$event[0]['id'].'" class="">'.$event[0]['name'].'</a>';
				echo '</p>';
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
		DBQuery::sql("UPDATE notification
			SET seen = 1
			WHERE id='$notification_id'");
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