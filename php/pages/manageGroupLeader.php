<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('Hantera lagledare');

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
	$work_group_id = $_POST['id'];
	$add_user_id = $_POST['add_group_leader'];
	$remove_user_id = $_POST['remove_group_leader'];

	DBQuery::sql("INSERT INTO work_group_leaders
					(user_id, work_group_id)
					VALUES ('$add_user_id', '$work_group_id')");

	DBQuery::sql("DELETE FROM work_group_leaders
        					WHERE '$work_group_id' = work_group_id AND '$remove_user_id' = user_id");
}

function loadAll()
{
	echo '<div class="row">
			<div class="col-sm-12">
				<div class="page-header">
					<h1>
					Hantera Lagledare - 
					<a href="?page=createGroup">Skapa Lag</a> - 
					<a href="?page=manageGroup">Hantera Lag</a>
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

function loadAllPeopleWithAdminAccess($group)
{
	$users = DBQuery::sql("SELECT id, name, last_name FROM user 
						ORDER BY name");

	$group_leader = DBQuery::sql("SELECT user_id FROM work_group_leaders
						WHERE work_group_id = '$group'");

	for($i = 0; $i < count($users); ++$i)
	{
		if(checkAdminAccessForUser($users[$i]['id']))
		{
			if(!in_array($users[$i]['id'], $group_leader))
				echo '<option value="'.$users[$i]['id'].'">'.$users[$i]['name'].' '.$users[$i]['last_name'].'</option>';
		}
	}
}

function loadAllGroupLeaders($group)
{
	$group_leader = DBQuery::sql("SELECT user_id, work_group_id FROM work_group_leaders
						WHERE work_group_id = '$group'");

	for($i = 0; $i < count($group_leader); ++$i)
	{
		$user_id = $group_leader[$i]['user_id'];
		$user = DBQuery::sql("SELECT id, name, last_name FROM user 
						WHERE id = '$user_id'");
		echo '<option value="'.$user[0]['id'].'">'.$user[0]['name'].' '.$user[0]['last_name'].'</option>';
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

	echo '<input type="hidden" name="id" id="id" value="'.$group_name[0]['id'].'">';

	echo '<h3>'.$group_name[0]['name'].'</h3>';

	echo '<label for="add_group_leader">Lägg till lagledare</label>
			<select name="add_group_leader" id="add_group_leader" class="bottom-border">
				<option id="typeno" value="NULL">Lägg till lagledare</option>';
	loadAllPeopleWithAdminAccess($group);
	echo '</select>';

	echo '<label for="remove_group_leader">Ta bort lagledare</label>
			<select name="remove_group_leader" id="remove_group_leader" class="bottom-border">
				<option id="typeno" value="NULL">Ta bort lagledare</option>';
	loadAllGroupLeaders($group);
	echo '</select>';

	echo '<input type="submit" name="submit" value="Spara">';
	
	echo 			'</div>
				</form>
			</div>
		</div>';
}

?>