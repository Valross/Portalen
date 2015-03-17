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
	$groupName = $_POST['groupName'];
	$id = $_POST['id'];
	$facebookGroup = $_POST['facebookGroup'];
	$description = $_POST['description'];
	$main_group = $_POST['main_group'];

	if($groupName != '')
	{
		DBQuery::sql("INSERT INTO work_group 
						(name, facebook_group, description, main_group)
						VALUES ('$groupName', '$facebookGroup', '$description', $main_group)");
	}
}

function loadAll()
{
	echo '<div class="row">
			<div class="col-sm-12">
				<div class="page-header">
					<h1>
					Skapa Lag - 
					<a href="?page=manageGroup">Hantera Lag</a> - 
					<a href="?page=manageGroupLeader">Hantera Lagledare</a>
					</h1>
				</div>
			</div>
		</div> <!-- .row -->';

	loadCreateGroupTools();
}

function loadAllGroupsAsOption()
{
	$groups = DBQuery::sql("SELECT id, name FROM work_group ORDER BY name");
	for($i = 0; $i < count($groups); ++$i)
	{
		?>
			<option value="<?php echo $groups[$i]['id']; ?>"><?php echo $groups[$i]['name']; ?></option>
		<?php
	}
}

function loadCreateGroupTools()
{
	echo '<div class="row">
			<div class="col-sm-6">
				<form action="" method="post">
					<div class="white-box">';

	echo '<label for="groupName">Lagnamn</label>
			<input type="text" name="groupName" id="groupName" value="">
			<label for="facebookGroup">Facebookgrupp</label>
			<input type="text" name="facebookGroup" id="facebookGroup" value="">
			<label for="description">Beskrivning</label>
			<textarea rows="6" cols="50" name="description" id="description" class="bottom-border"></textarea>
			<input type="hidden" name="id" id="id" value="">';

	echo '<label for="main_group">Huvudlag</label>
			<select name="main_group" id="main_group" class="bottom-border">
				<option id="typeno" value="NULL">Välj huvudlag - om detta inte är ett</option>';
	loadAllGroupsAsOption();
	echo '</select>';

	echo '<input type="submit" name="submit" value="Skapa">';
	
	echo 			'</div>
				</form>
			</div>
		</div>';
}

?>