<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('Hantera lag');

if(checkAdminAccess() <= 1)
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
	$groupName = strip_tags($_POST['groupName']);
	$id = strip_tags($_POST['id']);
	$facebookGroup = strip_tags($_POST['facebookGroup']);
	$description = strip_tags($_POST['description'], allowed_tags());
	$hex = strip_tags($_POST['hex']);
	$icon = strip_tags($_POST['icon']);
	$main_group = $_POST['main_group'];
	$sub_group = $_POST['sub_group'];

	if($groupName != '')
	{
		DBQuery::sql("UPDATE work_group
				  SET name = '$groupName', facebook_group = '$facebookGroup', description = '$description', 
				  hex = '$hex', icon = '$icon', sub_group = $sub_group, main_group = $main_group
				  WHERE id = '$id'");
	}
}

function loadAll()
{
	echo '<div class="row">
			<div class="col-sm-12">
				<div class="page-header">
					<h1>
					Hantera Lag - 
					<a href="?page=createGroup">Skapa Lag</a> - 
					<a href="?page=manageGroupLeader">Hantera Lagledare</a>
					</h1>
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
	echo '</select>';

	echo '<input type="submit" name="chooseGroup" value="Välj">';
	
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
		echo '<option value="'.$groups[$i]['id'].'">'.$groups[$i]['name'].'</option>';
	}
}

function loadAllOtherGroupsAsOption($this_group_id, $selected_group)
{
	$groups = DBQuery::sql("SELECT id, name FROM work_group ORDER BY name");
	for($i = 0; $i < count($groups); ++$i)
	{
		if($groups[$i]['id'] != $this_group_id)
		{
			if($groups[$i]['id'] == $selected_group)
				echo '<option selected="selected" value="'.$groups[$i]['id'].'">'.$groups[$i]['name'].'</option>';
			else
				echo '<option value="'.$groups[$i]['id'].'">'.$groups[$i]['name'].'</option>';
		}
	}
}

function loadGroupManageTools($group)
{
	$group_name = DBQuery::sql("SELECT id, name, description, facebook_group, icon, hex, sub_group, main_group FROM work_group 
						WHERE id = '$group'
						ORDER BY name");

	echo '<div class="row">
			<div class="col-sm-6">
				<form action="" method="post">
					<div class="white-box">';

	echo '<label for="groupName">Lagnamn</label>
			<input type="text" name="groupName" id="groupName" value="'.$group_name[0]['name'].'">
			<label for="facebookGroup">Facebookgrupp</label>
			<input type="text" name="facebookGroup" id="facebookGroup" placeholder="https://www.facebook.com/groups/" value="'.$group_name[0]['facebook_group'].'">
			<label for="icon">Ikon <span class="fa fa-cloud fa-fw fa-lg"></span></label>
			<input type="text" name="icon" id="icon" placeholder="cloud" value="'.$group_name[0]['icon'].'" class="bottom-border">
			<p class="alert alert-info small" role="alert">
			Värdet för fältet <strong>ikon</strong> används för att visa en specifik ikon från ikontypsnittet Font Awesome. En komplett lista över tillgängliga ikonnamn finns på <a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">http://fortawesome.github.io/Font-Awesome/icons/</a>.
			</p>
			<label for="hex">#Hexkod</label>
			<input type="text" name="hex" id="hex" placeholder="ffffff" value="'.$group_name[0]['hex'].'" class="bottom-border">
			<p class="alert alert-info small" role="alert">
			Värdet för fältet <strong>#Hexkod</strong> kommer användas till bakgrundsfärgen i cirkeln till lagets ikon. Färger anges med hexadecimaler. Skriv 6 tecken och strunta i hashtecknet (#).
			</p>
			<label for="description">Beskrivning</label>
			<textarea rows="6" cols="50" name="description" id="description" class="bottom-border">'.$group_name[0]['description'].'</textarea>
			<input type="hidden" name="id" id="id" value="'.$group_name[0]['id'].'">';

	echo '<label for="main_group">Huvudlag</label>
			<select name="main_group" id="main_group" class="bottom-border">
				<option id="typeno" value="NULL">Välj huvudlaget - om detta inte är ett</option>';
	loadAllOtherGroupsAsOption($group, $group_name[0]['main_group']);
	echo '</select>';

	echo '<label for="sub_group">Nybyggarlag</label>
			<select name="sub_group" id="sub_group" class="bottom-border">
				<option id="typeno" value="NULL">Välj nybyggarlaget - om detta inte är ett</option>';
	loadAllOtherGroupsAsOption($group, $group_name[0]['sub_group']);
	echo '</select>';


	echo '<input type="submit" name="submit" value="Spara">';
	
	if(checkAdminAccess() == -1)
		echo '<a href="?page=removeGroup&group_id='.$group_name[0]['id'].'" onclick="return confirm(\'Är du säker? Det går inte att ångra sig.\')">
			<span class="fa fa-remove fa-fw fa-lg"></span>Ta bort laget</a>';
	else
		echo '<a href="" class="black-link" data-toggle="tooltip" data-placement="bottom" title="Endast webchefen kan ta bort lag"> 
			<span class="fa fa-remove fa-fw fa-lg"></span>Ta bort laget</a>';
	
	echo 			'</div>
				</form>
			</div>
		</div>';
}

?>