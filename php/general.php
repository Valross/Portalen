<?php
include_once('php/DBQuery.php');
	
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
	return '<i>\n';
}

//
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
	$bookedEvents = DBQuery::sql("SELECT id, name, start_time FROM event WHERE id IN
									(SELECT event_id FROM work_slot WHERE id IN
									(SELECT work_slot_id FROM user_work WHERE user_id = '$_SESSION[user_id]' AND checked = '0')
									) 
								ORDER BY start_time
								");
	
	$workTimes = DBQuery::sql	("SELECT start_time, end_time, points FROM work_slot WHERE id IN
									(SELECT work_slot_id FROM user_work WHERE user_id = '$_SESSION[user_id]' AND checked = '0')
								ORDER BY start_time
								");
								
							
	for($i = 0; $i < count($bookedEvents); ++$i)
	{
		$eventId = $bookedEvents[$i]['id'];	
		$availableSlots = DBQuery::sql	("SELECT id FROM work_slot WHERE event_id = '$eventId' AND id NOT IN
											(SELECT work_slot_id FROM user_work)
										");
		$availableSlotsCount = count($availableSlots);
		$availableSlotsText = 'lediga platser';
		if($availableSlotsCount == 1)
		{
			$availableSlotsText = 'ledig plats';
		}
		$name = $bookedEvents[$i]['name'];
		$eventDate = new DateTime($bookedEvents[$i]['start_time']);
		$day = $eventDate->format('j');
		$month = $eventDate->format('n');
		$start = new DateTime($workTimes[$i]['start_time']);
		$start = $start->format(' H:i -');
		$end = new DateTime($workTimes[$i]['end_time']);
		$end = $end->format(' H:i');
		$points = $workTimes[$i]['points'];
		
		?>
			<a href=<?php echo '"?page=event&id='.$bookedEvents[$i]['id'].'"'; ?> class="list-group-item">
			<span class="badge"><?php echo $points ?>p</span>
			<strong><?php echo $day.'/'.$month.' '; ?></strong>
			<?php echo ' '.$name ?></a>
		<?php
	}
	
	if(count($bookedEvents) == 0)
	{
		?>
		
		<p><i>Du har inte några bokade pass just nu.</i></p>
		
		<?php
	}
}
//
//Load today's events
function loadTodaysEvents()
{
	global $dateNoTime;
	$upcomingEvents = DBQuery::sql("SELECT event.id, event.name AS event_name, event.start_time, event.end_time, event_type.name AS type_name FROM event 
									INNER JOIN event_type ON event.event_type_id = event_type.id 
									WHERE start_time > '$dateNoTime' ORDER BY start_time");

	$nothingIsHappening = true;							
	
	for($i = 0; $i < count($upcomingEvents); ++$i)
	{
		$eventId = $upcomingEvents[$i]['id'];
		$workSlots = DBQuery::sql("SELECT id FROM work_slot WHERE event_id = '$eventId'");
		$availableSlots = DBQuery::sql	("SELECT id FROM work_slot WHERE event_id = '$eventId' AND id NOT IN
											(SELECT work_slot_id FROM user_work)
										");

		

		$eventDate = new DateTime($upcomingEvents[$i]['start_time']);
		if($dateNoTime == $eventDate->format('Y-m-d'))
		{
			$nothingIsHappening = false;	
			$workSlotsCount = count($workSlots);
			$availableSlotsCount = count($availableSlots);
			$availableSlotsText = 'lediga platser';
			if($availableSlotsCount == 1)
			{
				$availableSlotsText = 'ledig plats';
			}
			
			$name = $upcomingEvents[$i]['event_name'];
			
			$day = $eventDate->format('j');
			$month = $eventDate->format('n');
			$start = $eventDate->format('H:i -');
			$end = new DateTime($upcomingEvents[$i]['end_time']);
			$end = $end->format(' H:i');
			$type = $upcomingEvents[$i]['type_name'];
			?>
				<a href=<?php echo '"?page=event&id='.$upcomingEvents[$i]['id'].'"'; ?> class="list-group-item">
				<strong class="list-group-item-time-floated-left"><?php echo $start. '' .$end.' ';?></strong>
				<?php echo $name ?></a>
			<?php
		}
	}
	if($nothingIsHappening)
	{
		?>
		
		<p><i>Rätt lugnt på Trappan idag.</i></p>
		
		<?php
	}
}
//
//Load upcoming events
function loadAvailableEvents()
{
	global $dateNoTime;
	$availableEvents = DBQuery::sql("SELECT event.id, event.name AS event_name, event.start_time, event.end_time, event_type.name AS type_name FROM event 
									INNER JOIN event_type ON event.event_type_id = event_type.id 
									WHERE start_time > '$dateNoTime' AND event.id IN
										(SELECT event_id FROM work_slot WHERE id NOT IN
											(SELECT work_slot_id FROM user_work)
										)
									ORDER BY start_time");
								
	
	for($i = 0; $i < count($availableEvents); ++$i)
	{
		$eventId = $availableEvents[$i]['id'];
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
		
		$name = $availableEvents[$i]['event_name'];
		$eventDate = new DateTime($availableEvents[$i]['start_time']);
		$day = $eventDate->format('j');
		$month = $eventDate->format('n');
		$start = $eventDate->format('H:i -');
		$end = new DateTime($availableEvents[$i]['end_time']);
		$end = $end->format(' H:i');
		$type = $availableEvents[$i]['type_name'];

		?>
			<a href=<?php echo '"?page=event&id='.$availableEvents[$i]['id'].'"'; ?> class="list-group-item">
			<span class="badge"><?php echo $availableSlotsCount.' '.$availableSlotsText; ?></span>
			<strong class="list-group-item-date-floated-left"><?php echo $day.'/'.$month.' '; ?></strong>
			<?php echo $name ?></a>
		<?php
	}

	if(count($availableEvents) == 0)
	{
		?>
		
		<p><i>Det finns inte några lediga pass just nu.</i></p>
		
		<?php
	}
}
//Load upcoming meetings
function loadAvailableMeetings()
{
	global $dateNoTime;
	$availableMeetings = DBQuery::sql("SELECT event.id, event.name AS event_name, event.start_time, event.end_time, event_type.name AS type_name FROM event 
									INNER JOIN event_type ON event.event_type_id = event_type.id 
									WHERE start_time > '$dateNoTime' AND event.id IN
										(SELECT event_id FROM work_slot WHERE id NOT IN
											(SELECT work_slot_id FROM user_work)
										)
									AND event.event_type_id = 5
									ORDER BY start_time");
								
	
	for($i = 0; $i < count($availableMeetings); ++$i)
	{
		$eventId = $availableMeetings[$i]['id'];
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
		
		$name = $availableMeetings[$i]['event_name'];
		$eventDate = new DateTime($availableMeetings[$i]['start_time']);
		$day = $eventDate->format('j');
		$month = $eventDate->format('n');
		$start = $eventDate->format('H:i -');
		$end = new DateTime($availableMeetings[$i]['end_time']);
		$end = $end->format(' H:i');
		$type = $availableMeetings[$i]['type_name'];

		?>
			<a href=<?php echo '"?page=event&id='.$availableMeetings[$i]['id'].'"'; ?> class="list-group-item">
			<span class="badge"><?php echo $availableSlotsCount.' '.$availableSlotsText; ?></span>
			<strong class="list-group-item-date-floated-left"><?php echo $day.'/'.$month.' '; ?></strong>
			<?php echo $name ?></a>
		<?php
	}

	if(count($availableMeetings) == 0)
	{
		?>
		
		<p><i>Det finns inte några möten för dig just nu.</i></p>
		
		<?php
	}
}

function loadTitleForBrowser($title)
{
	echo '<title>';
	if($title != '')
		echo $title;
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
					echo '<span class="'.$groups[$i]['icon'].' list-group-thumbnail group-badge webb"></span>'; 
				else
					echo '<span class="fa fa-code fa-fw list-group-thumbnail group-badge webb"></span>'; 
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
					echo '<span class="'.$groups[$i]['icon'].' list-group-thumbnail group-badge webb"></span>'; 
				else
					echo '<span class="fa fa-code fa-fw list-group-thumbnail group-badge webb"></span>'; 
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
	if($user_id < 0)
	{
		return false;
	}
	return true;
}

function checkAdminAccess()
{
	$user_id = $_SESSION['user_id'];
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
	echo '<div class="col-sm-7">
					<div class="white-box">';
	echo '<p>';

	if($currentPage == 0)
	{
		echo 'Första ';
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

		echo '<a href="?page='.$page.'&pageNumber='.($currentPage-1).$append.'">'.($currentPage-1).'</a> ';
		
		echo 'Sista ';
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
	echo    '</div>
		 </div>';
}

function loadAmountOfUnseenNotifications()
{
	$user_id = $_SESSION['user_id'];
	$notifications = DBQuery::sql("SELECT id FROM notification
										WHERE user_id = '$user_id' AND seen IS NULL");

	echo count($notifications);
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

function unlockAchievementForUser($user_id, $achievement_id)
{
	$dates = new DateTime;
	$dates->setTimezone(new DateTimeZone('Europe/Stockholm'));
	$date = $dates->format('Y-m-d H:i:s');
	
	$achievement = DBQuery::sql("SELECT id, points FROM achievement WHERE id = '$achievement_id'");

	$achievement_unlocked = DBQuery::sql("SELECT achievement_id FROM achievement_unlocked 
								WHERE user_id = '$user_id' AND achievement_id = $achievement_id");

	$points = DBQuery::sql("SELECT achievement_points FROM user WHERE id = '$user_id'");

	$total_points = $points[0]['achievement_points'] + $achievement[0]['points'];
	
	if(count($achievement_unlocked) == 0)
	{
		DBQuery::sql("INSERT INTO achievement_unlocked (user_id, achievement_id, date_unlocked)
							VALUES ('$user_id', '$achievement_id', '$date')");

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