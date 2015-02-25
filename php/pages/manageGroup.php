<?php
include_once('php/DBQuery.php');

loadAll();

if(isset($_POST['submit']))
{
	$groupName = $_POST['groupName'];
	$id = $_POST['id'];
	$facebookGroup = $_POST['facebookGroup'];
	$description = $_POST['description'];

	if($groupName != '')
	{
		DBQuery::sql("UPDATE work_group
				  SET name = '$groupName', facebook_group = '$facebookGroup', description = '$description'
				  WHERE id = '$id'");
	}
}

function loadAll()
{
	echo '<div class="row">
			<div class="col-sm-12">
				<div class="page-header">
					<h1>Hantera Lag</h1>
				</div>
			</div>
		</div> <!-- .row -->';
	echo '<div class="row">
			<div class="col-sm-6">
				<form action="" method="post">
					<div class="white-box">';

	echo '<label for="group">Lag</label>
			<select name="group" id="group" class="bottom-border">
				<option id="typeno" value="typeno">Välj lag</option>';
	loadAllGroupsAsOption();
	echo '</select>
		<input type="submit" name="chooseGroup" value="Välj">';
	
	echo 			'</div>
				</form>
			</div>
		</div>';
	if(isset($_POST['chooseGroup']))
	{
		$group = $_POST['group'];
		if($group != '')
			loadGroupManageTools($group);
	}
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

function loadGroupManageTools($group)
{
	$group_name = DBQuery::sql("SELECT id, name, description, facebook_group FROM work_group 
						WHERE id = '$group'
						ORDER BY name");

	echo '<div class="row">
			<div class="col-sm-6">
				<form action="" method="post">
					<div class="white-box">';

	echo '<label for="groupName">Lagnamn</label>
			<input type="text" name="groupName" id="groupName" value="'.$group_name[0]['name'].'">
			<label for="facebookGroup">Facebookgrupp</label>
			<input type="text" name="facebookGroup" id="facebookGroup" value="'.$group_name[0]['facebook_group'].'">
			<label for="description">Beskrivning</label>
			<textarea rows="6" cols="50" name="description" id="description" class="bottom-border">'.$group_name[0]['description'].'</textarea>
			<input type="hidden" name="id" id="id" value="'.$group_name[0]['id'].'">';


	echo '<input type="submit" name="submit" value="Spara">';
	
	echo 			'</div>
				</form>
			</div>
		</div>';
}

?>