<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('Skapa Access');

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

if(isset($_POST['submitCreate']))
{
	$accessName = strip_tags($_POST['accessName']);

	if($accessName != '')
	{
		DBQuery::sql("INSERT INTO access 
						(name)
						VALUES ('$accessName')");
	}
}

if(isset($_POST['submitGive']))
{
	$access_id = strip_tags($_POST['access_id']);
	$group_id = strip_tags($_POST['group_id']);

	DBQuery::sql("INSERT INTO group_access 
					(access_id, group_id)
					VALUES ('$access_id', '$group_id')");
}

function loadAll()
{
	echo '<div class="row">
			<div class="col-sm-12">
				<div class="page-header">
					<h1>
					<span class="fa fa-wheelchair fa-fw fa-lg"></span> Skapa Access - 
					<a href="?page=manageAccess">Hantera Access</a> - 
					<a href="?page=manageGroupLeader">Hantera Lagledare</a>
					</h1>
				</div>
			</div>
		</div> <!-- .row -->';

	loadCreateAccessGroupTools();

	loadCreateAccessForGroupTools();
}

function loadCreateAccessGroupTools()
{
	echo '<div class="row">
			<div class="col-sm-6">
				<form action="" method="post">
					<div class="white-box">';

	echo '<label for="accessName">Lagnamn / Accessnamn</label>
			<input type="text" name="accessName" id="accessName" value="">';

	echo '<input type="submit" name="submitCreate" value="Skapa Access">';
	
	echo 			'</div>
				</form>
			</div>
		</div>';
}

function loadAllGroupsAsOption()
{
	$groups = DBQuery::sql("SELECT id, name FROM work_group ORDER BY name");
	for($i = 0; $i < count($groups); ++$i)
	{
		echo '<option value="'.$groups[$i]['id'].'">'.$groups[$i]['name'].'</option>';
	}
}

function loadAllAccessAsOption()
{
	$access = DBQuery::sql("SELECT id, name FROM access ORDER BY name");
	for($i = 0; $i < count($access); ++$i)
	{
		echo '<option value="'.$access[$i]['id'].'">'.$access[$i]['name'].'</option>';
	}
}

function loadCreateAccessForGroupTools()
{
	$group_name = DBQuery::sql("SELECT id, name, description, facebook_group, icon, hex, sub_group, main_group FROM work_group 
						ORDER BY name");

	echo '<div class="row">
			<div class="col-sm-6">
				<form action="" method="post">
					<div class="white-box">';

	echo '<h3>'.$group_name[0]['name'].'</h3>';

	echo '<label for="group_id">Lag</label>
			<select name="group_id" id="group_id" class="bottom-border">
				<option id="typeno" value="NULL">Välj lag</option>';
	loadAllGroupsAsOption();
	echo '</select>';

	echo '<label for="access_id">Access</label>
			<select name="access_id" id="access_id" class="bottom-border">
				<option id="typeno" value="NULL">Välj Access</option>';
	loadAllAccessAsOption();
	echo '</select>';

	echo '<input type="submit" name="submitGive" value="Ge Access">';
	
	echo 			'</div>
				</form>
			</div>
		</div>';
}

?>