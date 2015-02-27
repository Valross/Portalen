<?php
include_once('php/DBQuery.php');

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
					<h1>Hantera Eventmallar</h1>
				</div>
			</div>
		</div> <!-- .row -->';
	echo '<div class="row">
			<div class="col-sm-6">
				<form action="" method="post">
					<div class="white-box">';

	echo '<label for="group">Mallar</label>
			<select name="group" id="group" class="bottom-border">
				<option id="typeno" value="typeno">Välj mall</option>';
	loadAllTemplatesAsOption();
	echo '</select>
		<input type="submit" name="chooseGroup" value="Välj">
		<input type="submit" name="add" value="Lägg till mall">';

	
	echo 			'</div>
				</form>
			</div>
		</div>';
	if(isset($_POST['chooseGroup']))
	{
		$group = $_POST['group'];
		if($group != '')
			loadTemplateManageTools($group);
	}
}

function loadAllTemplatesAsOption()
{
	$templates = DBQuery::sql("SELECT id, name FROM event_template ORDER BY name");
	for($i = 0; $i < count($templates); ++$i)
	{
		?>
			<option value="<?php echo $templates[$i]['id']; ?>"><?php echo $templates[$i]['name']; ?></option>
		<?php
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

?>