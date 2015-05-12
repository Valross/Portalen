<?php
include_once('php/DBQuery.php');

function loadPageNavigators($navigate_date)
{
	date_sub($navigate_date, date_interval_create_from_date_string('2 weeks'));

	echo '<a href="?page=bookold&y='.$navigate_date->format('Y').'&w='.$navigate_date->format('W').'">';
	echo '<i class="fa fa-angle-left fa-lg fa-margin-right"></i> Föregående veckor';
	echo '</a>';

	echo '   ';
	date_add($navigate_date, date_interval_create_from_date_string('4 weeks'));

	echo '<a href="?page=bookold&y='.$navigate_date->format('Y').'&w='.$navigate_date->format('W').'">';
	echo 'Nästa veckor <i class="fa fa-angle-right fa-lg fa-margin-right"></i>';
	echo '</a>';
}

function loadLayout()
{
	$navigate_date = new DateTime();
	if(isset($_GET['y']) && isset($_GET['w']))
	{
		$this_week = $_GET['w'];
		$this_year = $_GET['y'];
		
		$navigate_date->setISODate($this_year, $this_week);
	}
	else
	{
		$dates = new DateTime;
		$dates->setTimezone(new DateTimeZone('Europe/Stockholm'));
		$this_week = $dates->format('W');
		$this_year = $dates->format('Y');
		$navigate_date->setISODate($this_year, $this_week);
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
	loadPageNavigators($navigate_date);
	echo '		</div>
				</div>
				</div>
			</div> <!-- .white-box -->
		</div> <!-- .col-sm-8 -->';

	$dates = new DateTime;
	$dates->setTimezone(new DateTimeZone('Europe/Stockholm'));
	setlocale(LC_TIME, 'sv');

	$date1 = date("l, M jS, Y", strtotime($this_year."W".sprintf("%02u", $this_week)."1")); // First day of week
	$date_int = strtotime($date1);

	$date = new DateTime();
	$date->setTimestamp($date_int);

	for($k = 0; $k < 2; $k++)
	{
		echo '<div class="col-sm-4">
			<div class="white-box">';

		echo '<h4>';
		echo 'Vecka ';
		echo $date->format('W');
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
				$event_id = $events_this_day[$j]['id'];
				$groups = DBQuery::sql("SELECT id, name, main_group, sub_group, icon, hex FROM work_group 
							WHERE id IN 
								(SELECT group_id FROM work_slot WHERE event_id = '$event_id')
							ORDER BY name");

				echo '</br>';
				echo '<a href="?page=event&id='.$event_id.'">';
				echo $events_this_day[$j]['name'];
				echo '</a>';

				$event_time_start = DateTime::createFromFormat('Y-m-d H:i:s', $events_this_day[$j]['start_time']);
				$event_time_end = DateTime::createFromFormat('Y-m-d H:i:s', $events_this_day[$j]['end_time']);
				echo $event_time_start->format(' H:i');
				echo $event_time_end->format('-H:i');

				for($k = 0; $k < count($groups); $k++)
				{
					$group_id = $groups[$k]['id'];
					$total_slots = DBQuery::sql("SELECT id, points, event_id, start_time, end_time, group_id, wage FROM work_slot 
						WHERE event_id = '$event_id' AND group_id = '$group_id'");

					$booked_slots = DBQuery::sql("SELECT id, points, event_id, start_time, end_time, group_id, wage FROM work_slot 
						WHERE event_id = '$event_id' AND group_id = '$group_id'
						AND id IN
							(SELECT work_slot_id FROM user_work)");

					if(checkIfMemberOfGroup($_SESSION['user_id'], $group_id))
					{
						echo '<p class="">';
						echo $groups[$k]['name'].' ('.count($booked_slots).'/'.count($total_slots).')';
						echo '</p>';
					}
				}
			}
			date_add($date, date_interval_create_from_date_string('1 days'));
			echo '</p>';
		}
		echo '</div>
			</div>';
	}
}

?>