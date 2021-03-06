<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/Portalen/php/DBQuery.php');

if(isset($_GET['notified']))
{
	$notification_id = $_GET['notified'];
	DBQuery::sql("UPDATE notification
		 	SET seen = 1
		 	WHERE id = '$notification_id'");
}
	
//Score progress bar calculation
$dates = new DateTime;
$dates->setTimezone(new DateTimeZone('Europe/Stockholm'));
$date = $dates->format('Y-m-d H:i:s');
$dateNoTime = $dates->format('Y-m-d');
				
$workedPointsResult = DBQuery::sql	("SELECT points FROM work_slot WHERE event_id IN
										(SELECT id FROM event WHERE period_id IN 
											(SELECT id FROM period WHERE start_date <= '$dateNoTime' AND end_date >= '$dateNoTime')
										) 
									AND id IN
										(SELECT work_slot_id FROM user_work WHERE user_id = '$_SESSION[user_id]' AND checked = '1')
									");
				
$workedPoints = 0;

$bookedPointsResult = DBQuery::sql	("SELECT points FROM work_slot WHERE event_id IN
										(SELECT id FROM event WHERE period_id IN 
											(SELECT id FROM period WHERE start_date <= '$dateNoTime' AND end_date >= '$dateNoTime')
										) 
									AND id IN
										(SELECT work_slot_id FROM user_work WHERE user_id = '$_SESSION[user_id]' AND checked = '0')
									");
				
$bookedPoints = 0;
				
for($i = 0; $i < count($workedPointsResult); ++$i)
{
	$workedPoints = $workedPoints + $workedPointsResult[$i]['points'];
}

for($i = 0; $i < count($bookedPointsResult); ++$i)
{
	$bookedPoints = $bookedPoints + $bookedPointsResult[$i]['points'];
}

$emptyPoints = 8 - $workedPoints - $bookedPoints;

$emptyPointsPercent = $emptyPoints / 8 * 100;
$workedPointsPercent = $workedPoints / 8 * 100;
$bookedPointsPercent = $bookedPoints / 8 * 100;

/*
	The progressbar showed wrong value, 25% instead of 75%. It seems to work after I 	commented this code. /Andreas

if($emptyPointsPercent > 100 - $emptyPointsPercent)
{
	$emptyPointsPercent = 100 - $emptyPointsPercent;
}*/
if($workedPointsPercent > 100)
{
	$workedPointsPercent = 100;
}
if($bookedPointsPercent > 100 - $workedPointsPercent)
{
	$bookedPointsPercent = 100 - $workedPointsPercent;
}

//Allowed tags
function allowed_tags()
{
	return '<i>\n<a>';
}

//Load upcoming events
function loadUpcomingEvents()
{
	global $date;
	$upcomingEvents = DBQuery::sql("SELECT event.id, event.name AS event_name, event.start_time, event.end_time, event_type.name AS type_name FROM event 
									INNER JOIN event_type ON event.event_type_id = event_type.id 
									WHERE start_time > '$date' ORDER BY start_time LIMIT 3");
								
	
	for($i = 0; $i < count($upcomingEvents); ++$i)
	{
		$eventId = $upcomingEvents[$i]['id'];
		$workSlots = DBQuery::sql("SELECT id FROM work_slot WHERE event_id = '$eventId'");
		$availableSlots = DBQuery::sql	("SELECT id FROM work_slot WHERE event_id = '$eventId' AND id NOT IN
											(SELECT work_slot_id FROM user_work)
										");
		$workSlotsCount = count($workSlots);
		$availableSlotsCount = count($availableSlots);
		$availableSlotsText = 'lediga platser';
		if($availableSlotsCount == 1)
		{
			$availableSlotsText = 'ledig plats';
		}
		
		$name = $upcomingEvents[$i]['event_name'];
		$eventDate = new DateTime($upcomingEvents[$i]['start_time']);
		$day = $eventDate->format('j');
		$month = $eventDate->format('n');
		$start = $eventDate->format('H:i');
		$end = new DateTime($upcomingEvents[$i]['end_time']);
		$end = $end->format('H:i');
		$type = $upcomingEvents[$i]['type_name'];
		/*switch($month)
		{
		case '01':
			$month = 'januari';
			break;
		case '02':
			$month = 'februari';
			break;
		case '03':
			$month = 'mars';
			break;
		case '04':
			$month = 'april';
			break;
		case '05':
			$month = 'maj';
			break;
		case '06':
			$month = 'juni';
			break;
		case '07':
			$month = 'juli';
			break;
		case '08':
			$month = 'augusti';
			break;
		case '09':
			$month = 'september';
			break;
		case '10':
			$month = 'oktober';
			break;
		case '11':
			$month = 'november';
			break;
		case '12':
			$month = 'december';
			break;
		default:
			break;
		}*/
		?>
			<a href="#" class="list-group-item"><strong><?php echo $day.'/'.$month; ?></strong><?php echo $name ?>
			<span class="badge"><?php echo $availableSlotsCount.' '.$availableSlotsText; ?></span></a>
		<?php
	}
}
//
//Load current period
$periodDates = DBquery::sql("SELECT start_date, end_date FROM period WHERE start_date <= '$dateNoTime' AND end_date >= '$dateNoTime'");
$periodStart = "";
$periodEnd = "";
if(count($periodDates) == 1)
{
	$periodStart = new DateTime($periodDates[0]['start_date']);
	$periodStart = strtolower($periodStart->format('j M'));
	$periodEnd = new DateTime($periodDates[0]['end_date']);
	$periodEnd = strtolower($periodEnd->format('j M'));
	if($periodStart == "oct")
	{
		$periodStart = "okt";
	}
	else if($periodStart == "may")
	{
		$periodStart = "maj";
	}
	if($periodEnd == "oct")
	{
		$periodEnd = "okt";
	}
	else if($periodEnd == "may")
	{
		$periodStart = "maj";
	}
}
//
//Load booked events
function loadBookedEvents()
{
	$bookedEvents = DBQuery::sql("SELECT id, name, start_time FROM event 
								WHERE id IN
									(SELECT event_id FROM work_slot 
									WHERE id IN
										(SELECT work_slot_id FROM user_work 
										WHERE user_id = '$_SESSION[user_id]' AND checked = '0')) 
								ORDER BY start_time");
	
	$workTimes = DBQuery::sql	("SELECT start_time, end_time, points, group_id, wage FROM work_slot 
								WHERE id IN
									(SELECT work_slot_id FROM user_work 
									WHERE user_id = '$_SESSION[user_id]' AND checked = '0')
								ORDER BY start_time");
	
	if(count($bookedEvents) > 0)
	{
		echo '<div class="white-box">
				<h4>Bokat</h4>	
					<div class="list-group">';
	}
	for($i = 0; $i < count($bookedEvents) && $i < 15; ++$i)
	{
		$eventId = $bookedEvents[$i]['id'];	
		$group_id = $workTimes[$i]['group_id'];
		$availableSlots = DBQuery::sql("SELECT id FROM work_slot WHERE event_id = '$eventId' AND id NOT IN
											(SELECT work_slot_id FROM user_work)");

		$group = DBQuery::sql("SELECT name FROM work_group 
								WHERE id = '$group_id'");

		$name = $bookedEvents[$i]['name'];
		$eventDate = new DateTime($bookedEvents[$i]['start_time']);
		$day = $eventDate->format('j');
		$month = $eventDate->format('n');
		$start = new DateTime($workTimes[$i]['start_time']);
		$start = $start->format(' H:i -');
		$end = new DateTime($workTimes[$i]['end_time']);
		$end = $end->format(' H:i');
		$points = $workTimes[$i]['points'];
		$wage = $workTimes[$i]['wage'];
		
		echo '<a href="?page=event&id='.$bookedEvents[$i]['id'].'" class="list-group-item">';
		echo '<span class="badge">'.$points.'p</span>';
		if($wage > 0)
			echo '<span class="badge">'.$wage.'kr/h</span>';
		echo '<strong>'.$day.'/'.$month.' </strong>';
		echo ' '.$name.' ('.$group[0]['name'].')</a>';
	}
	if(count($bookedEvents) > 0)
	{
		echo '</div>
		</div> <!-- .white-box -->';
	}
}
//
//Load today's events
function loadTodaysEvents()
{
	global $dateNoTime;
	$todaysEvents = DBQuery::sql("SELECT id, name, start_time, end_time, name FROM event 
									WHERE start_time > '$dateNoTime' ORDER BY start_time");					
	
	if(count($todaysEvents) > 0)
	{
		echo '<div class="white-box">
				<h4>Idag</h4>
					<div class="list-group">';
	}
	for($i = 0; $i < count($todaysEvents); ++$i)
	{
		$eventId = $todaysEvents[$i]['id'];
		$workSlots = DBQuery::sql("SELECT id FROM work_slot WHERE event_id = '$eventId'");
		$availableSlots = DBQuery::sql	("SELECT id FROM work_slot WHERE event_id = '$eventId' AND id NOT IN
											(SELECT work_slot_id FROM user_work)
										");

		$eventDate = new DateTime($todaysEvents[$i]['start_time']);
		if($dateNoTime == $eventDate->format('Y-m-d'))
		{
			$workSlotsCount = count($workSlots);
			$availableSlotsCount = count($availableSlots);
			$availableSlotsText = 'lediga platser';
			if($availableSlotsCount == 1)
			{
				$availableSlotsText = 'ledig plats';
			}
			
			$name = $todaysEvents[$i]['name'];
			
			$day = $eventDate->format('j');
			$month = $eventDate->format('n');
			$start = $eventDate->format('H:i -');
			$end = new DateTime($todaysEvents[$i]['end_time']);
			$end = $end->format(' H:i');

			echo '<a href="?page=event&id='.$todaysEvents[$i]['id'].'" class="list-group-item">';
			echo '<strong class="list-group-item-time-floated-left">'.$start.''.$end.' </strong>';
			echo ' '.$name.'</a>';
		}
	}
	if(count($todaysEvents) > 0)
	{
		echo '</div>
		</div> <!-- .white-box -->';
	}
}
//
//Load upcoming events
function loadAvailableEvents()
{
	global $dateNoTime;
	$availableEvents = DBQuery::sql("SELECT id, name, start_time, end_time, name FROM event
									WHERE start_time > '$dateNoTime' AND id IN
										(SELECT event_id FROM work_slot WHERE id NOT IN
											(SELECT work_slot_id FROM user_work))
									AND event_type_id != 5
									ORDER BY start_time");
								
	if(count($availableEvents) > 0)
	{
		echo '<div class="white-box">
				<h4>Bokningsbart</h4>
					<div class="list-group">';
	}
	for($i = 0; $i < count($availableEvents) && $i < 10; ++$i)
	{
		$total_available_slots = 0;
		$event_id = $availableEvents[$i]['id'];

		$groups = DBQuery::sql("SELECT id, name, main_group, sub_group, icon, hex FROM work_group 
							WHERE id IN 
								(SELECT group_id FROM work_slot WHERE event_id = '$event_id')
							ORDER BY name");

		for($k = 0; $k < count($groups); $k++)
		{
			$group_id = $groups[$k]['id'];
			$available_slots = DBQuery::sql("SELECT id, points, event_id, start_time, end_time, group_id, wage FROM work_slot 
				WHERE event_id = '$event_id' AND group_id = '$group_id'
				AND id NOT IN
					(SELECT work_slot_id FROM user_work)");

			if(checkIfMemberOfGroup($_SESSION['user_id'], $group_id))
				$total_available_slots = $total_available_slots + count($available_slots);
		}
		
		$availableSlotsCount = $total_available_slots;
		$availableSlotsText = 'lediga platser';

		if($availableSlotsCount == 1)
			$availableSlotsText = 'ledig plats';
		
		$name = $availableEvents[$i]['name'];
		$eventDate = new DateTime($availableEvents[$i]['start_time']);
		$day = $eventDate->format('j');
		$month = $eventDate->format('n');
		$start = $eventDate->format('H:i -');
		$end = new DateTime($availableEvents[$i]['end_time']);
		$end = $end->format(' H:i');

		echo '<a href="?page=event&id='.$availableEvents[$i]['id'].'" class="list-group-item">';
		echo '<span class="badge">'.$availableSlotsCount.' '.$availableSlotsText.'</span>';
		echo '<strong class="list-group-item-date-floated-left">'.$day.'/'.$month.' </strong>';
		echo ' '.$name.'</a>';
	}
	if(count($availableEvents) > 0)
	{
		echo '</div>
		</div> <!-- .white-box -->';
	}
}
//Load upcoming meetings
function loadAvailableMeetings()
{
	global $dateNoTime;
	$user_id = $_SESSION['user_id'];
	$availableMeetings = DBQuery::sql("SELECT id, name, start_time, end_time, name FROM event
									WHERE start_time > '$dateNoTime' AND id IN
										(SELECT event_id FROM work_slot WHERE id NOT IN
											(SELECT work_slot_id FROM user_work))
									AND event_type_id = 5
									AND id IN
										(SELECT event_id FROM work_slot
										WHERE group_id IN
											(SELECT group_id FROM group_member
											WHERE user_id = '$user_id'))
									ORDER BY start_time");
								
	if(count($availableMeetings) > 0)
	{
		echo '<div class="white-box">
				<h4>Möten</h4>
					<div class="list-group">';
	}
	for($i = 0; $i < count($availableMeetings) && $i < 4; ++$i)
	{
		$eventId = $availableMeetings[$i]['id'];
		$workSlots = DBQuery::sql("SELECT id FROM work_slot WHERE event_id = '$eventId'");
		$availableSlots = DBQuery::sql	("SELECT id FROM work_slot WHERE event_id = '$eventId' AND id NOT IN
											(SELECT work_slot_id FROM user_work)
										");
		$workSlotsCount = count($workSlots);
		$availableSlotsCount = count($availableSlots);
		
		$name = $availableMeetings[$i]['name'];
		$eventDate = new DateTime($availableMeetings[$i]['start_time']);
		$day = $eventDate->format('j');
		$month = $eventDate->format('n');
		$start = $eventDate->format('H:i -');
		$end = new DateTime($availableMeetings[$i]['end_time']);
		$end = $end->format(' H:i');

		echo '<a href="?page=event&id='.$availableMeetings[$i]['id'].'" class="list-group-item">';
		echo '<span class="badge">Boka upp dig!</span>';
		echo '<strong class="list-group-item-date-floated-left">'.$day.'/'.$month.' </strong>';
		echo ' '.$name.'</a>';
	}
	if(count($availableMeetings) > 0)
	{
		echo '</div>
		</div> <!-- .white-box -->';
	}
}

function loadTitleForBrowser($title)
{
	echo '<title>';
	if($title != '')
		echo $title . ' - Trappans personalportal';
	else
		echo 'Trappans personalportal';
	echo '</title>';
}

//
//Load avatar
function loadAvatar()
{
	$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$_SESSION[user_id]' AND avatar IS NOT NULL");
	if(count($results) == 0)
	{
		return 'img/avatars/no_face_small.png';
	}
	return 'img/avatars/'.$results[0]['avatar'];
}

function loadAvatarFromUser($user_id, $size)
{
	$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$user_id' AND avatar IS NOT NULL");
	if(count($results) == 0)
	{
		return '<img src="img/avatars/no_face_small.png" width="'.$size.'" height="'.$size.'" class="img-circle">';
	}
	return '<img src="img/avatars/'.$results[0]['avatar'].'" width="'.$size.'" height="'.$size.'" class="img-circle">';
}
function loadAvatarFromUserAsNotification($user_id, $size)
{
	$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$user_id' AND avatar IS NOT NULL");
	if(count($results) == 0)
	{
		return '<img src="img/avatars/no_face_small.png" width="'.$size.'" height="'.$size.'" class="img-circle list-group-thumbnail">';
	}
	return '<img src="img/avatars/'.$results[0]['avatar'].'" width="'.$size.'" height="'.$size.'" class="img-circle list-group-thumbnail">';
}

function loadMyGroups()
{
	$groups = DBQuery::sql("SELECT id, name, icon, hex FROM work_group 
							WHERE id IN 
							(SELECT group_id FROM group_member WHERE user_id = '$_SESSION[user_id]')
							ORDER BY name");

	for($i = 0; $i < count($groups); ++$i)
	{
		$group_id = $groups[$i]['id'];
		$group_members = DBQuery::sql("SELECT user_id, group_id, member_since FROM group_member 
							WHERE user_id = '$_SESSION[user_id]' AND group_id = '$group_id'");
		?>
			<a href=<?php echo '"?page=group&id='.$groups[$i]['id'].'"'; ?> class="list-group-item with-thumbnail">
				<?php 
				if($groups[$i]['icon'] != '')
					echo '<span class="fa fa-'.$groups[$i]['icon'].' fa-fw fa-lg list-group-thumbnail group-badge" style="background: #'.$groups[$i]['hex'].';"></span>'; 
				else
					echo '<span class="fa fa-circle fa-fw fa-lg list-group-thumbnail group-badge" style="background: #'.$groups[$i]['hex'].';"></span>'; 
				?>
				<?php echo $groups[$i]['name']; ?>
				<span class="list-group-item-text pull-right"><?php echo 'sedan '.$group_members[0]['member_since']; ?></span>
			</a>
		<?php
	}
}

function loadMyGroupsOption()
{
	$groups = DBQuery::sql("SELECT id, name, icon FROM work_group 
							WHERE id IN 
							(SELECT group_id FROM group_member WHERE user_id = '$_SESSION[user_id]')
							ORDER BY name");
	for($i = 0; $i < count($groups); ++$i)
	{
		?>
			<option value="<?php echo $groups[$i]['id']; ?>"><?php echo $groups[$i]['icon'].$groups[$i]['name']; ?></option>
		<?php
	}
}

function loadAllGroups()
{
	$groups = DBQuery::sql("SELECT id, name, icon, hex FROM work_group ORDER BY name");
	for($i = 0; $i < count($groups); ++$i)
	{
		$group_id = $groups[$i]['id'];

		$members = DBQuery::sql("SELECT name, last_name, id FROM user 
							WHERE id IN 
							(SELECT user_id FROM group_member WHERE group_id = '$group_id')");

		?>
			<a href=<?php echo '"?page=group&id='.$groups[$i]['id'].'"'; ?> class="list-group-item with-thumbnail">
				
				<?php 
				if($groups[$i]['icon'] != '')
					echo '<span class="fa fa-'.$groups[$i]['icon'].' fa-fw fa-lg list-group-thumbnail group-badge" style="background: #'.$groups[$i]['hex'].';"></span>'; 
				else
					echo '<span class="fa fa-circle fa-fw list-group-thumbnail group-badge" style="background: #'.$groups[$i]['hex'].';"></span>'; 
				?>
				<?php echo $groups[$i]['name']; ?>
				<span class="badge"><?php echo count($members); ?></span>
			</a>
		<?php
	}
}

function loadAllGroupsOption()
{
	$groups = DBQuery::sql("SELECT id, name, icon FROM work_group ORDER BY name");
	for($i = 0; $i < count($groups); ++$i)
	{
		?>
			<option value="<?php echo $groups[$i]['id']; ?>"><?php echo $groups[$i]['icon'].$groups[$i]['name']; ?></option>
		<?php
	}
}

function checkIfMemberOfGroup($user_id, $group_id)
{
	$group_member = DBQuery::sql("SELECT group_id, user_id FROM group_member
									WHERE group_id = '$group_id'
									AND user_id = '$user_id'");

	$main_group_query = DBQuery::sql("SELECT main_group FROM work_group
										WHERE id = '$group_id'");

	if(count($main_group_query) > 0 && $main_group_query[0]['main_group'] != 'NULL')
	{
		$main_group = $main_group_query[0]['main_group'];
		$group_member_of_main = DBQuery::sql("SELECT group_id, user_id FROM group_member
									WHERE group_id = '$main_group'
									AND user_id = '$user_id'");

		if(count($group_member_of_main) > 0)
			return true;
	}

	if(count($group_member) > 0)
		return true;

	return false;
}

function checkAdminAccess()
{
	$user_id = $_SESSION['user_id'];
	$DG = DBQuery::sql("SELECT access_id FROM group_access
						WHERE access_id = 1 AND
						group_id IN
							(SELECT group_id FROM group_member
							WHERE user_id = '$user_id')");

	$DA = DBQuery::sql("SELECT access_id FROM group_access
						WHERE access_id = 2 AND
						group_id IN
							(SELECT group_id FROM group_member
							WHERE user_id = '$user_id')");

	$hovis = DBQuery::sql("SELECT access_id FROM group_access
						WHERE access_id = 3 AND
						group_id IN
							(SELECT group_id FROM group_member
							WHERE user_id = '$user_id')");

	$DGAccessUser = DBQuery::sql("SELECT access_id FROM user_access
						WHERE access_id = 1
						AND user_id = '$user_id'");

	$DAAccessUser = DBQuery::sql("SELECT access_id FROM user_access
						WHERE access_id = 2
						AND user_id = '$user_id'");

	$HovisAccessUser = DBQuery::sql("SELECT access_id FROM user_access
						WHERE access_id = 3
						AND user_id = '$user_id'");

	$webmaster = DBQuery::sql("SELECT access_id FROM user_access
						WHERE access_id = 5
						AND user_id = '$user_id'");

	if(count($webmaster) > 0)
		return -1;
	if(count($DG) > 0 || count($DGAccessUser) > 0)
		return 1;
	else if(count($DA) > 0 || count($DAAccessUser) > 0)
		return 2;
	else if(count($hovis) > 0 || count($HovisAccessUser) > 0)
		return 3;
	else
		return 4; //No access
}

function checkAdminAccessForUser($user_id)
{
	$adminAccess = DBQuery::sql("SELECT access_id, group_id FROM group_access
						WHERE (access_id = 1 OR access_id = 2 OR access_id = 4) AND
						group_id IN
							(SELECT group_id FROM group_member
							WHERE user_id = '$user_id' AND (group_id = 1 OR group_id = 7))");

	$adminAccessUser = DBQuery::sql("SELECT access_id FROM user_access
						WHERE (access_id = 1 OR access_id = 2 OR access_id = 4)
						AND user_id = '$user_id'");

	if(count($adminAccess) > 0 || count($adminAccessUser) > 0)
		return true;
	else
		return false;
}

function loadNameFromUser($user_id)
{
	$results = DBQuery::sql("SELECT name, last_name FROM user WHERE id = '$user_id'");
	if(count($results) == 0)
	{
		return '';
	}
	
	return $results[0]['name'].' '.$results[0]['last_name'];
}

function loadPageNumbers($currentPage, $lastPage, $page, $append)
{
	echo '<p>';

	if($currentPage == 0)
	{
		echo 'Första (0) ';

		if($currentPage < $lastPage-1)
			echo '<a href="?page='.$page.'&pageNumber='.($currentPage+1).$append.'">'.($currentPage+1).'</a> ';

		if($lastPage > $currentPage+2)
			echo '... ';

		if($lastPage != $currentPage)
			echo '<a href="?page='.$page.'&pageNumber='.($lastPage).$append.'">Sista ('.$lastPage.')</a> ';
	}
	else if($currentPage == $lastPage)
	{
		echo '<a href="?page='.$page.'&pageNumber=0'.$append.'">Första (0)</a> ';

		if($currentPage-2 > 0)
			echo '... ';

		if($currentPage > 1)
			echo '<a href="?page='.$page.'&pageNumber='.($currentPage-1).$append.'">'.($currentPage-1).'</a> ';
		
		echo 'Sista ('.$lastPage.')';
	}
	else
	{
		echo '<a href="?page='.$page.'&pageNumber=0'.$append.'">Första (0)</a> ';

		if($currentPage-2 > 0)
			echo '... ';

		if($currentPage-1 > 0)
			echo '<a href="?page='.$page.'&pageNumber='.($currentPage-1).$append.'">'.($currentPage-1).'</a> ';
		
		echo $currentPage.' ';

		if($currentPage < $lastPage)
		{
			if($currentPage == $lastPage-1)
				echo '<a href="?page='.$page.'&pageNumber='.($currentPage+1).$append.'">Sista ('.$lastPage.')</a> ';
			else
				echo '<a href="?page='.$page.'&pageNumber='.($currentPage+1).$append.'">'.($currentPage+1).'</a> ';
		}

		if($lastPage > $currentPage+2)
			echo '... ';
		
		if($lastPage > $currentPage+1)
			echo '<a href="?page='.$page.'&pageNumber='.($lastPage).$append.'">Sista ('.$lastPage.')</a> ';
	}

	echo '</p>';
}

function notify($user_id, $notification_type, $info)
{
	$dates = new DateTime;
	$dates->setTimezone(new DateTimeZone('Europe/Stockholm'));
	$date = $dates->format('Y-m-d H:i:s');

	if($user_id != '' && $notification_type != '' && $info != '')
		DBQuery::sql("INSERT INTO notification (user_id, notification_type, info, date)
							VALUES ('$user_id', '$notification_type', '$info', '$date')");
}

function mailToUser($recipient, $subject, $msg)
{
	mail($recipient, $subject, $msg);
	echo("mailing to " . $recipient . ", mail with subject " . $subject);
}

function mailToGroup($group, $subject, $msg) 
{
	$recipients = DBQuery::sql("SELECT mail FROM user WHERE id IN 
													(SELECT user_id FROM group_member 
														WHERE group_id = '$group' )");
	$howMany = count($recipients);
	for($i = 0; $i < $howMany; ++$i)
	{
		// echo $recipients[$i]['mail'];
		mail($recipients[$i]['mail'], $subject, $msg);
		echo("mailing to " . $recipients[$i]['mail'] . ", subject: " . $subject . "  ");
	}

}

function unlockAchievementForUser($user_id, $achievement_id)
{	
	$achievement = DBQuery::sql("SELECT id, points FROM achievement WHERE id = '$achievement_id'");

	$achievement_unlocked = DBQuery::sql("SELECT achievement_id FROM achievement_unlocked 
								WHERE user_id = '$user_id' AND achievement_id = $achievement_id");

	$points = DBQuery::sql("SELECT achievement_points FROM user WHERE id = '$user_id'");

	$total_points = $points[0]['achievement_points'] + $achievement[0]['points'];
	
	if(count($achievement_unlocked) == 0)
	{
		DBQuery::sql("INSERT INTO achievement_unlocked (user_id, achievement_id)
							VALUES ('$user_id', '$achievement_id')");

		DBQuery::sql("UPDATE user
				  SET achievement_points = '$total_points', 
				  WHERE id='$user_id'");

		notify($user_id, 1, $achievement_id);
	}
}

function checkIfAchievement($user_id)
{
	$achievements_unlocked = DBQuery::sql("SELECT achievement_id FROM achievement_unlocked 
								WHERE user_id = '$user_id'");

	$workedGuard = DBQuery::sql("SELECT id FROM event 
									WHERE id IN
										(SELECT event_id FROM work_slot 
										WHERE id IN 
											(SELECT work_slot_id FROM user_work
											WHERE user_id = '$user_id' AND group_id = 6)) 
										AND event_type_id != 5");

	$workedChef = DBQuery::sql("SELECT id FROM event 
									WHERE id IN
										(SELECT event_id FROM work_slot 
										WHERE id IN 
											(SELECT work_slot_id FROM user_work
											WHERE user_id = '$user_id' AND group_id = 3)) 
										AND event_type_id != 5");

	$workedBar = DBQuery::sql("SELECT id FROM event 
									WHERE id IN
										(SELECT event_id FROM work_slot 
										WHERE id IN 
											(SELECT work_slot_id FROM user_work
											WHERE user_id = '$user_id' AND group_id = 4)) 
										AND event_type_id != 5");

	$workedAll = DBQuery::sql("SELECT id FROM event 
									WHERE id IN
										(SELECT event_id FROM work_slot 
										WHERE id IN 
											(SELECT work_slot_id FROM user_work
											WHERE user_id = '$user_id' AND group_id = 13)) 
										AND event_type_id != 5");

	$workedServe = DBQuery::sql("SELECT id FROM event 
									WHERE id IN
										(SELECT event_id FROM work_slot 
										WHERE id IN 
											(SELECT work_slot_id FROM user_work
											WHERE user_id = '$user_id' AND group_id = 11)) 
										AND event_type_id != 5");

	$workedHeadwaiter = DBQuery::sql("SELECT id FROM event 
									WHERE id IN
										(SELECT event_id FROM work_slot 
										WHERE id IN 
											(SELECT work_slot_id FROM user_work
											WHERE user_id = '$user_id' AND group_id = 12)) 
										AND event_type_id != 5");

	$workedDA = DBQuery::sql("SELECT id FROM event 
									WHERE id IN
										(SELECT event_id FROM work_slot 
										WHERE id IN 
											(SELECT work_slot_id FROM user_work
											WHERE user_id = '$user_id' AND group_id = 7)) 
										AND event_type_id != 5");

	$workedPointsResult = DBQuery::sql("SELECT points FROM work_slot 
									WHERE id IN
										(SELECT work_slot_id FROM user_work WHERE user_id = '$user_id' AND checked = '1')
									");

	$periods = DBQuery::sql("SELECT id FROM period");
	
	for($i = 1; $i < count($periods); ++$i)
	{
		$workedPointsThatPeriod = DBQuery::sql("SELECT points FROM work_slot 
									WHERE event_id IN
										(SELECT id FROM event WHERE period_id IN 
											(SELECT id FROM period
											WHERE id = '$i')
										)
									AND id IN
										(SELECT work_slot_id FROM user_work WHERE user_id = '$user_id' AND checked = '1')
									");

		$workedPointsPeriod = 0;
		for($j = 0; $j < count($workedPointsThatPeriod); ++$j)
		{
			$workedPointsPeriod = $workedPointsPeriod + $workedPointsThatPeriod[$j]['points'];
		}

		if($workedPointsPeriod >= 12)
		{
			unlockAchievementForUser($user_id, 20); //Jobba 12p i en period
			if($workedPointsPeriod >= 25)
			{
				unlockAchievementForUser($user_id, 21); //Jobba 25p i en period
			}
		}
	}
	
	$workedPointsTotal = 0;
	if(count($workedPointsResult) > 0)
	{
		for($i = 0; $i < count($workedPointsResult); ++$i)
			$workedPointsTotal = $workedPointsTotal + $workedPointsResult[$i]['points'];
	}

	//--------------------------------------------------------------------------------------------------------------------

	//Totalpoäng
	if($workedPointsTotal >= 250)
	{
		unlockAchievementForUser($user_id, 22); //Jobba minst 250p
	}

	//Alla
	if(count($workedAll) >= 2) 
	{
		unlockAchievementForUser($user_id, 28); //Jobba alla 2 gånger
		if(count($workedAll) >= 8) 
		{
			unlockAchievementForUser($user_id, 29); //Jobba alla 8 gånger
			if(count($workedAll) >= 15) 
			{
				unlockAchievementForUser($user_id, 30); //Jobba alla 15 gånger
				if(count($workedAll) >= 25) 
				{
					unlockAchievementForUser($user_id, 31); //Jobba alla 25 gånger
				}
			}
		}
	}

	//Värd
	if(count($workedGuard) >= 2) 
	{
		unlockAchievementForUser($user_id, 15); //Jobba värd 2 gånger
		if(count($workedGuard) >= 10) 
		{
			unlockAchievementForUser($user_id, 16); //Jobba värd 10 gånger
			if(count($workedGuard) >= 25) 
			{
				unlockAchievementForUser($user_id, 3); //Jobba värd 25 gånger
				if(count($workedGuard) >= 50) 
				{
					unlockAchievementForUser($user_id, 14); //Jobba värd 50 gånger
				}
			}
		}
	}

	//Kock
	if(count($workedChef) >= 2)
	{
		unlockAchievementForUser($user_id, 5); //Jobba kock 2 gånger
		if(count($workedChef) >= 10) 
		{
			unlockAchievementForUser($user_id, 13); //Jobba kock 10 gånger
			if(count($workedChef) >= 25) 
			{
				unlockAchievementForUser($user_id, 11); //Jobba kock 25 gånger
				if(count($workedChef) >= 50) 
				{
					unlockAchievementForUser($user_id, 12); //Jobba kock 50 gånger
				}
			}
		}
	}

	//Bar
	if(count($workedBar) >= 2) 
	{
		unlockAchievementForUser($user_id, 4); //Jobba bar 2 gånger
		if(count($workedBar) >= 10) 
		{
			unlockAchievementForUser($user_id, 8); //Jobba bar 10 gånger
			if(count($workedBar) >= 25) 
			{
				unlockAchievementForUser($user_id, 9); //Jobba bar 25 gånger
				if(count($workedBar) >= 50) 
				{
					unlockAchievementForUser($user_id, 10); //Jobba bar 50 gånger
				}
			}
		}
	}

	//DA
	if(count($workedDA) >= 2)
	{
		unlockAchievementForUser($user_id, 6); //Jobba DA 2 gånger
		if(count($workedDA) >= 10) 
		{
			unlockAchievementForUser($user_id, 17); //Jobba DA 10 gånger
			if(count($workedDA) >= 25) 
			{
				unlockAchievementForUser($user_id, 18); //Jobba DA 25 gånger
				if(count($workedDA) >= 50) 
				{
					unlockAchievementForUser($user_id, 19); //Jobba DA 50 gånger
				}
			}
		}
	}

	//Servering
	if(count($workedServe) >= 2) 
	{
		unlockAchievementForUser($user_id, 23); //Jobba Servering 2 gånger
		if(count($workedServe) >= 10)
		{
			unlockAchievementForUser($user_id, 24); //Jobba Servering 10 gånger
			if(count($workedServe) >= 25)
			{
				unlockAchievementForUser($user_id, 25); //Jobba Servering 25 gånger
				if(count($workedServe) >= 50)
				{
					unlockAchievementForUser($user_id, 26); //Jobba Servering 50 gånger
				}
			}
		}
	}

	//Hovis
	if(count($workedHeadwaiter) >= 2) 
	{
		unlockAchievementForUser($user_id, 32); //Jobba Hovis 2 gånger
		if(count($workedHeadwaiter) >= 8)
		{
			unlockAchievementForUser($user_id, 33); //Jobba Hovis 8 gånger
			if(count($workedHeadwaiter) >= 15)
			{
				unlockAchievementForUser($user_id, 34); //Jobba Hovis 15 gånger
				if(count($workedHeadwaiter) >= 25)
				{
					unlockAchievementForUser($user_id, 35); //Jobba Hovis 25 gånger
				}
			}
		}
	}

	//Jobba allt
	if(count($workedBar) >= 1 && count($workedChef) >= 1 && count($workedGuard) >= 1 
			&& count($workedServe) >= 1 && count($workedAll) >= 1) 
	{
		unlockAchievementForUser($user_id, 7); //Jobba allt 1 pass
		if(count($workedBar) >= 10 && count($workedChef) >= 10 && count($workedGuard) >= 10 
			&& count($workedServe) >= 10 && count($workedAll) >= 10)
		{
			unlockAchievementForUser($user_id, 7); //Jobba allt 10 pass
		}
	}
}

?>