<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('Hantera eventmallar');

if(checkAdminAccess())
	loadAll();
else
	{
		?>
		<script>
			window.location = "?page=start";
			alert("Sluta försöka hacka sidan!")
		</script>
	<?php
}

if(isset($_POST['slots'])) {
	$p_start_time = $_POST['start_h'];
	$p_end_time = $_POST['end_h'];
	$p_start_date = $_POST['start_d'];
	$p_end_date = $_POST['end_d'];
	$p_points = $_POST['points'];
	$p_wage = $_POST['wage'];
	$p_work_slot_id = $_POST['work_slot_id'];

	$slotCounter = count($p_work_slot_id);

    for($i=0; $i < $slotCounter; $i++)
    {
    	$start_time = $p_start_time[$i];
    	$end_time = $p_end_time[$i];
    	$start_date = $p_start_date[$i];
    	$end_date = $p_end_date[$i];
    	$points = $p_points[$i];
    	if($points < 0 || $points > 10)
    		$points = 0;
    	$wage = $p_wage[$i];
    	if($wage < 0 || $wage > 170)
    		$wage = 0;
    	$work_slot_id = $p_work_slot_id[$i];

    	$start = $start_date.' '.$start_time.':00';
    	$end = $end_date.' '.$end_time.':00';

        DBQuery::sql("UPDATE event_template_group
			  SET start_time = '$start', end_time = '$end',
			  		points = '$points', wage = '$wage'
			  WHERE id='$work_slot_id'");
    }
}

if(isset($_POST['addSlot']))
{
	$group_id = $_POST['groups'];
	$amount = $_POST['amount'];
	$event_template_id = $_POST['event_template_id'];

	if($group_id != '')
	{
		for($i = 0; $i < $amount; ++$i)
		{
			DBQuery::sql("INSERT INTO event_template_group (event_template_id, group_id, points, wage, start_time, end_time)
							VALUES ('$event_template_id', '$group_id', '0', '0', '2015-01-01 17:00:00', '2015-01-02 02:00:00')");
		}
	}
}

if(isset($_POST['submit']))
{
	$event_template_name = $_POST['name'];
	$id = $_POST['id'];
	$event_type_id = $_POST['event_type_id'];
	$start_time = $_POST['start_time'];
	$end_time = $_POST['end_time'];

	if($event_template_name != '' && $event_type_id != '' && $start_time != '' && $end_time != '')
	{
		DBQuery::sql("UPDATE event_template
				  SET name = '$event_template_name', event_type_id = '$event_type_id', 
				  start_time = '$start_time', end_time = '$end_time'
				  WHERE id = '$id'");
		?>
		<script>
			window.location = "?page=manageEventTemplate";
			alert("Mall ändrad!")
		</script>
		<?php
	}
}

if(isset($_POST['add']))
{
	DBQuery::sql("INSERT INTO event_template 
					(name, event_type_id, start_time, end_time)
					VALUES ('Obestämd', '1', '2015-12-28 13:37:00', '2015-12-28 13:37:00')");
	?>
	<script>
		window.location = "?page=manageEventTemplate";
		alert("Mall tillagd!")
	</script>
	<?php
}

function loadAll()
{
	echo '<div class="row">
			<div class="col-sm-12">
				<div class="page-header">
					<h1><span class="fa fa-table fa-fw fa-lg"></span> Hantera eventmallar</h1>
				</div>
			</div>
		</div> <!-- .row -->';
	echo '<div class="row">
			<div class="col-sm-6">
				<form action="" method="post">
					<div class="white-box">';

	echo '<label for="template">Mallar</label>
			<select name="template" id="template" class="bottom-border">
				<option id="typeno" value="typeno">Välj mall</option>';
	loadAllTemplatesAsOption();
	echo '</select>
		<input type="submit" name="chooseTemplate" value="Välj">
		<input type="submit" name="add" value="Lägg till mall">';

	
	echo 			'</div>
				</form>
			</div>
		</div>';

	$template = '';
	if(isset($_POST['chooseTemplate']))
	{
		$template = $_POST['template'];
		if($template != '')
			loadTemplateManageTools($template);
	}

	echo '<div class="col-sm-7">
			<div class="white-box">
				<h3>Pass</h3>

				<div class="list-group">';
	
				loadWorkSlots($template);

	echo 		'</div>
			</div> <!-- .white-box -->
			<div class="white-box">
				<h3>Lägg till pass</h3>
			<form action="" method="post">
				<label for="groups">Typ av pass</label>
				<select id="groups" name="groups">';
				loadGroups();
	echo 		'</select>
				<label for="amount">Antal pass</label>
				<input type="number" id="amount" name="amount" value="1" class="bottom-border">';
	echo 		'<input type="hidden" name="event_template_id" id="event_template_id" value="';
	echo 		$template;
	echo		'">';
	echo		'<input type="submit" name="addSlot" value="Lägg till pass">
			</form>
			</div>		
		</div> <!-- .col-sm-7 -->';
}

function loadGroups()
{
	$groups = DBQuery::sql("SELECT id, name FROM work_group ORDER BY name");
	for($i = 0; $i < count($groups); ++$i)
	{
		echo '<option value="'.$groups[$i]['id'].'" name="groups[]">'.$groups[$i]['name'].'</option>';
	}
}

function loadAllTemplatesAsOption()
{
	$templates = DBQuery::sql("SELECT id, name FROM event_template ORDER BY name");
	for($i = 0; $i < count($templates); ++$i)
	{
		echo '<option value="'.$templates[$i]['id'].'">'.$templates[$i]['name'].'</option>';
	}
}

function loadTemplateManageTools($template)
{
	$template_name = DBQuery::sql("SELECT id, name, event_type_id, start_time, end_time FROM event_template 
						WHERE id = '$template'
						ORDER BY name");

	echo '<div class="row">
			<div class="col-sm-6">
				<form action="" method="post">
					<div class="white-box">';

	echo '<label for="name">Eventmall</label>
			<input type="text" name="name" id="name" value="'.$template_name[0]['name'].'">
			<label for="event_type_id">Event typ id</label>
			<input type="text" name="event_type_id" id="event_type_id" value="'.$template_name[0]['event_type_id'].'">
			<label for="start_time">Starttid</label>
			<input type="text" name="start_time" id="start_time" value="'.$template_name[0]['start_time'].'">
			<label for="end_time">Sluttid</label>
			<input type="text" name="end_time" id="end_time" value="'.$template_name[0]['end_time'].'">
			<input type="hidden" name="id" id="id" value="'.$template_name[0]['id'].'">';


	echo '<input type="submit" name="submit" value="Spara">';
	
	echo 			'</div>
				</form>
			</div>
		</div>';
}

function loadWorkSlots($event_template_id)
{
	$user_id = $_SESSION['user_id'];

	$slots = DBQuery::sql("SELECT id, points, event_template_id, start_time, end_time, group_id, wage FROM event_template_group 
						WHERE event_template_id = '$event_template_id'");

	$groups = DBQuery::sql("SELECT id, name, main_group, sub_group, icon, hex FROM work_group 
							WHERE id IN 
								(SELECT group_id FROM event_template_group 
								WHERE event_template_id = '$event_template_id')
							ORDER BY name");

	echo '<form action="" method="post">';
	for($i = 0; $i < count($groups); ++$i)
	{
		$number = 0;
		if($groups[$i]['main_group'] == NULL)
		{
			echo '<li class="list-group-item with-thumbnail">';
			
			if($groups[$i]['icon'] != '')
				echo '<span class="'.$groups[$i]['icon'].' list-group-thumbnail group-badge webb"></span>';
			else
				echo '<span class="fa fa-code fa-fw list-group-thumbnail group-badge webb"></span>'; 
			echo '<a href="?page=group&id='.$groups[$i]['id'].'" class="black-link"><strong>'.$groups[$i]['name'].'</strong></a></li>';
		}
		for($j = 0; $j < count($slots); ++$j)
		{
			$work_slot_id = $slots[$j]['id'];
			
			if(($slots[$j]['group_id'] == $groups[$i]['id'] || $slots[$j]['group_id'] == $groups[$i]['sub_group']) && $groups[$i]['main_group'] == 0)
			{
				$slotStart = new DateTime($slots[$j]['start_time']);
				$slotEnd = new DateTime($slots[$j]['end_time']);
				$start_h = $slotStart->format('H:i');
				$end_h = $slotEnd->format('H:i');
				$start_d = $slotStart->format('Y-m-d');
				$end_d = $slotEnd->format('Y-m-d');
				$number++;

				if($slots[$j]['group_id'] == $groups[$i]['sub_group'])
					echo '<li class="list-group-item">'.$number.'! ';
				else
					echo '<li class="list-group-item">'.$number.'. ';
				echo '<input type="text" class="input-book-long" name="start_d[]" id="start_d[]" value="'.$start_d.'">';
				echo '<input type="text" class="input-book" name="start_h[]" id="start_h[]" value="'.$start_h.'"> ';
				echo '<input type="text" class="input-book-long" name="end_d[]" id="end_d[]" value="'.$end_d.'">';
				echo '<input type="text" class="input-book" name="end_h[]" id="end_h[]" value="'.$end_h.'"> ';
				echo '<input type="text" class="input-book" name="wage[]" id="wage[]" value="'.$slots[$j]['wage'].'"> kr/h ';

				echo '<a href=?page=eventTemplateRemoveWorkSlot&event_template_id='.$event_template_id.'&work_slot_id='.$slots[$j]['id'].
					' class="list-group-item-text-book-remove"><span class="fa fa-remove fa-fw fa-lg"></span></a>';

				echo '<input type="text" class="input-book" name="points[]" id="points[]" value="'.$slots[$j]['points'].'">p';
				echo '<input type="hidden" name="work_slot_id[]" id="work_slot_id[]" value="'.$slots[$j]['id'].'">';
				echo '<input type="hidden" name="event_template_id[]" id="event_template_id[]" value="'.$event_template_id.'">';
			}
		}
	}
	echo '<p><input type="submit" name="slots" value="Spara"></p>';
	echo '</form>';
}

?>