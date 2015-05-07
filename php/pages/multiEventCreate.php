<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('Multieventskapare');

if(isset($_POST['submit']) && checkAdminAccess() <= 1)
{
	$name = strip_tags($_POST['name']);
	$info = strip_tags($_POST['info'], allowed_tags());
	$template = strip_tags($_POST['template']);
	// $day = strip_tags($_POST['day']);
	$start = date_create(strip_tags($_POST['start']));
	$start = $start->format('Y-m-d');
	$end = date_create(strip_tags($_POST['end']));
	$end = $end->format('Y-m-d');
	$current = strip_tags($_POST['start']);

	$times = DBQuery::sql("SELECT start_time, end_time, id, event_type_id FROM event_template 
								WHERE id = '$template'");

	$start_time = $times[0]['start_time'];
	$end_time = $times[0]['end_time'];
	$event_template_id = $times[0]['id'];
	$event_type_id = $times[0]['event_type_id'];
	
	while($current <= $end)
	{
		$periodId = DBQuery::sql("SELECT id FROM period WHERE start_date < '$current' AND end_date > '$current'");
		
		if(!isset($periodId[0]["id"]))	//date invalid
	    	echo "Error: Det valda datumet har ingen definierad period";

	    else 							//date valid
	    {							
			$periodId = $periodId[0]["id"];

			if($name != '' && $info != '' && $start != '' && $end != '' && $start < $end)
			{
				$start_date = $current.' '.$start_time;
				$end_date = $current.' '.$end_time;

				DBQuery::sql("INSERT INTO event (id, name, info, event_type_id, start_time, end_time, period_id)
								VALUES ('', '$name', '$info', '$event_type_id', '$start_date', '$end_date', '$periodId')");

				$event_id = DBQuery::$lastId; 
				$slots = DBQuery::sql("SELECT id, group_id, start_time, end_time, points, wage, event_template_id FROM event_template_group 
										WHERE event_template_id = '$event_template_id'");
				
				for($i = 0; $i < count($slots); ++$i)
				{
					$group_id = $slots[$i]['group_id'];
					$slot_start_time = date('Y-m-d', strtotime($current)).' '.$slots[$i]['start_time'];
					if($slots[$i]['end_time'] <= strtotime('08:00:00'))
						$slot_end_time = date('Y-m-d', strtotime('+1 day', strtotime($current))).' '.$slots[$i]['end_time'];
					else
						$slot_end_time = date('Y-m-d', strtotime($current)).' '.$slots[$i]['end_time'];
					$points = $slots[$i]['points'];
					$wage = $slots[$i]['wage'];

					DBQuery::sql("INSERT INTO work_slot (group_id, event_id, start_time, end_time, points, wage)
							VALUES ('$group_id', '$event_id', '$slot_start_time', '$slot_end_time', '$points', '$wage')");
				}
				?>
				<script>
					window.location = "?page=multiEventCreate";
				</script>
				<?php
			}
			else
			{
				?>
				<script>
					window.location = "?page=multiEventCreate";
					alert("Det blev fel, du måste fylla i alla fält samt bestämma tider.")
				</script>
				<?php
			}
		}
		$current = strtotime($current);
		$current = date('Y-m-d', strtotime('+1 week', $current));
	}
}

function loadTemplates()
{
	$templates = DBQuery::sql("SELECT id, name FROM event_template ORDER BY name");
	for($i = 0; $i < count($templates); ++$i)
	{
		?>
			<option value="<?php echo $templates[$i]['id']; ?>"><?php echo $templates[$i]['name']; ?></option>
		<?php
	}
}

function loadGroups()
{
	$groups = DBQuery::sql("SELECT id, name FROM work_group ORDER BY name");
	for($i = 0; $i < count($groups); ++$i)
	{
		?>
			<option value="<?php echo $groups[$i]['id']; ?>"><?php echo $groups[$i]['name']; ?></option>
		<?php
	}
}

?>