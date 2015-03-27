<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('Eventmallar');

if(checkAdminAccess() == 1)
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
}

function loadAllTemplatesAsOption()
{
	$templates = DBQuery::sql("SELECT id, name FROM event_template ORDER BY name");
	for($i = 0; $i < count($templates); ++$i)
	{
		echo '<option value="'.$templates[$i]['id'].'">'.$templates[$i]['name'].'</option>';
	}
}

function loadAllEventTypesAsOption($template)
{
	$event_types = DBQuery::sql("SELECT id, name FROM event_type ORDER BY name");

	$event_type = DBQuery::sql("SELECT id FROM event_type 
							WHERE id IN 
								(SELECT event_type_id FROM event_template
								WHERE id = '$template')
							ORDER BY name");
	for($i = 0; $i < count($event_types); ++$i)
	{
		if($event_type[0]['id'] == $event_types[$i]['id'])
			echo '<option selected value="'.$event_types[$i]['id'].'">'.$event_types[$i]['name'].'</option>';
		else
			echo '<option value="'.$event_types[$i]['id'].'">'.$event_types[$i]['name'].'</option>';
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
			<input type="text" name="name" id="name" value="'.$template_name[0]['name'].'">';
	echo '<label for="event_type_id">Eventtyp</label>
			<select name="event_type_id" id="event_type_id" class="bottom-border">
				<option id="typeno" value="typeno">Välj eventtyp</option>';
	loadAllEventTypesAsOption($template);
	echo '</select>
			<label for="start_time">Starttid</label>
			<input type="text" name="start_time" id="start_time" value="'.$template_name[0]['start_time'].'">
			<label for="end_time">Sluttid</label>
			<input type="text" name="end_time" id="end_time" value="'.$template_name[0]['end_time'].'">
			<input type="hidden" name="id" id="id" value="'.$template_name[0]['id'].'">';


	echo '<input type="submit" name="submit" value="Spara">';
	echo '<a href="?page=manageEventTemplatePasses&id='.$template_name[0]['id'].'"><span class="fa fa-table fa-fw fa-lg"></span>Hantera passen</a>';
	
	echo 			'</div>
				</form>
			</div>
		</div>';
}
?>