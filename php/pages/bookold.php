<?php
include_once('php/DBQuery.php');

function loadPageNavigators($this_week, $this_year)
{
	$prev_week = $this_week-1;
	$next_week = $this_week+1;

	echo '<a href="?page=bookold&y='.$this_year.'&w='.$prev_week.'">';
	echo '<i class="fa fa-angle-left fa-lg fa-margin-right"></i> Föregående veckor';
	echo '</a>';

	echo '   ';

	echo '<a href="?page=bookold&y='.$this_year.'&w='.$next_week.'">';
	echo 'Nästa veckor <i class="fa fa-angle-right fa-lg fa-margin-right"></i>';
	echo '</a>';
}

function loadLayout()
{
	if(isset($_GET['y']) && isset($_GET['w']))
	{
		$this_week = $_GET['w'];
		$this_year = $_GET['y'];
		if($this_week >= 53)
		{
			$this_year = $this_year+1;
			$this_week = 1;
		}
		if($this_week <= 0)
		{
			$this_year = $this_year-1;
			$this_week = 52;
		}
	}
	else
	{
		$dates = new DateTime;
		$dates->setTimezone(new DateTimeZone('Europe/Stockholm'));
		$this_week = $dates->format('W');
		$this_year = $dates->format('Y');
	}

	echo '<div class="col-sm-8">
			<div class="white-box">
				<div class="calendar-top">
				<h3>Bokning</h3>
				<div class="pull-right form-inline">
				<div class="btn-group">
					<!-- <form action="?page=bookold&y=2015&w=15">
					    <button class="btn btn-default" data-calendar-nav="prev"><i class="fa fa-angle-left fa-lg fa-margin-right"></i> Föregående veckor</button>
					</form>
					<button class="btn btn-default" data-calendar-nav="next">Nästa veckor <i class="fa fa-angle-right fa-lg fa-margin-left"></i></button> -->';
	loadPageNavigators($this_week, $this_year);
	echo '		</div>
				</div>
				</div>
			</div> <!-- .white-box -->
		</div> <!-- .col-sm-8 -->';

	$dates = new DateTime;
	$dates->setTimezone(new DateTimeZone('Europe/Stockholm'));
	setlocale(LC_TIME, 'swedish');

	$date1 = date("l, M jS, Y", strtotime($this_year."W".sprintf("%02u", $this_week)."1")); // First day of week
	$date_int = strtotime($date1);

	$date = new DateTime();
	$date->setTimestamp($date_int);

	for($k = 0; $k < 2; $k++)
	{
		echo '<div class="col-sm-4">
			<div class="white-box">';

		echo '<h4>';
		echo 'Vecka '.($this_week+$k);
		// echo 'Vecka '.strftime('%W', mktime(0, 0, 0, $date_m, $date_d, $date_Y));
		echo '</h4>';
		
		for($i = 0; $i < 7; $i++)
		{
			$date_d = $date->format('d');
			$date_m = $date->format('m');
			$date_Y = $date->format('Y');
			$this_date = $date->format('Y-m-d');

			$events_this_day = DBQuery::sql("SELECT id, name, event_type_id, info, start_time, end_time FROM event 
							WHERE start_time > '".$this_date." 00:00:00' AND start_time < '".$this_date." 23:59:59'
							ORDER BY start_time");

			echo '<p>';
			echo strftime('%A %d:e %B', mktime(0, 0, 0, $date_m, $date_d, $date_Y));
			for($j = 0; $j < count($events_this_day); $j++)
			{
				echo '</br>';
				echo '<a href="?page=event&id='.$events_this_day[$j]['id'].'">';
				echo $events_this_day[$j]['name'];
				// echo ' '.$events_this_day[$j]['start_time'];
				echo '</a>';
			}
			date_add($date, date_interval_create_from_date_string('1 days'));
			echo '</p>';
		}

		echo '</div>
			</div>';
	}
}

function loadEventName()
{
	$event_id = $_GET['id'];
	$user_id = $_SESSION['user_id'];

	$event_name = DBQuery::sql("SELECT name, event_type_id FROM event
							WHERE id = '$event_id'");

	if(count($event_name) > 0)
	{
		echo '<span class="fa fa-picture-o fa-fw fa-lg"></span>'.$event_name[0]['name'];
		loadTitleForBrowser($event_name[0]['name']);
	}
	else
		echo "Nu har du kommit lite fel!";

	$da_note = DBQuery::sql("SELECT event_id FROM da_note
							WHERE event_id = '$event_id'");

	$headwaiter_note = DBQuery::sql("SELECT event_id FROM headwaiter_note
							WHERE event_id = '$event_id'");

	if(checkAdminAccess() == 1 && $event_name[0]['event_type_id'] != 5)
	{
		echo ' - <a href="?page=checkPasses&id='.$event_id.'"><span class="fa fa-check-square-o fa-fw fa-lg"></span>Checka Pass</a>';
	}

	if(count($da_note) > 0 && checkAdminAccess() == 1)
	{
		echo ' - <a href="?page=DANote&id='.$da_note[0]['event_id'].'">DA-lapp</a>';
	}

	if(count($headwaiter_note) > 0 && checkAdminAccess() == 1)
	{
		echo ' - <a href="?page=HeadwaiterNote&id='.$headwaiter_note[0]['event_id'].'">Hovis-lapp</a>';
	}
}

function loadEventPasses()
{
	$event_id = $_GET['id'];
	$event_info = DBQuery::sql("SELECT info, start_time, end_time, event_type_id FROM event 
						WHERE id = '$event_id'");

	$eventStart = new DateTime($event_info[0]['start_time']);
	$eventEnd = new DateTime($event_info[0]['end_time']);
	$start = $eventStart->format('Y-m-d H:i');
	$end = $eventEnd->format('Y-m-d H:i');

	$start_h = $eventStart->format('H:i');
	$end_h = $eventEnd->format('H:i');
	$start_d = $eventStart->format('Y-m-d');
	$end_d = $eventEnd->format('Y-m-d');

	if(checkAdminAccess() == 1)
	{
		echo '<form action="" method="post">';
		if(count($event_info) > 0 && $event_info[0]['event_type_id'] == 5)
		{
			echo "<tr><td><strong>Börjar</strong></td><td>";
			echo '<input type="text" class="input-book-long" name="start_d" id="start_d" value="'.$start_d.'">';
			echo '<input type="text" class="input-book" name="start_h" id="start_h" value="'.$start_h.'"> ';
			echo "</td></tr>";

			echo "<tr><td><strong>Slutar</strong></td><td>";
			echo '<input type="text" class="input-book-long" name="end_d" id="end_d" value="'.$end_d.'">';
			echo '<input type="text" class="input-book" name="end_h" id="end_h" value="'.$end_h.'"> ';
			echo "</td></tr>";

			echo "<tr><td><strong>Information</strong></td><td>";
			echo '<textarea rows="4" name="info" id="info" class="bottom-border">'.$event_info[0]['info'].'</textarea>';
			echo "</td></tr>";
		}
		else
		{
			echo "<tr><td><strong>Öppnar</strong></td><td>";
			echo '<input type="text" class="input-book-long" name="start_d[]" id="start_d[]" value="'.$start_d.'">';
			echo '<input type="text" class="input-book" name="start_h[]" id="start_h[]" value="'.$start_h.'"> ';
			echo "</td></tr>";

			echo "<tr><td><strong>Stänger</strong></td><td>";
			echo '<input type="text" class="input-book-long" name="end_d[]" id="end_d[]" value="'.$end_d.'">';
			echo '<input type="text" class="input-book" name="end_h[]" id="end_h[]" value="'.$end_h.'"> ';
			echo "</td></tr>";

			echo "<tr><td><strong>Information</strong></td><td>";
			echo '<textarea rows="4" name="info" id="info" class="bottom-border">'.$event_info[0]['info'].'</textarea>';
			echo "</td></tr>";
		}
		echo '<tr><td><input type="submit" name="eventInfo" value="Spara"></td></tr>';
		echo '</form>';
	}
	else
	{
		if(count($event_info) > 0 && $event_info[0]['event_type_id'] == 5)
		{
			echo "<tr><td><strong>Börjar</strong></td><td>".$start."</td></tr>";
			echo "<tr><td><strong>Slutar</strong></td><td>".$end."</td></tr>";
			echo "<tr><td><strong>Information</td><td>".$event_info[0]['info']."</td></tr>";	
		}
		else
		{
			echo "<tr><td><strong>Öppnar</strong></td><td>".$start."</td></tr>";
			echo "<tr><td><strong>Stänger</strong></td><td>".$end."</td></tr>";
			echo "<tr><td><strong>Information</strong></td><td>".$event_info[0]['info']."</td></tr>";
		}
	}
}

?>