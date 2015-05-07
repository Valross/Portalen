<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('Hantera Access');

if(checkAdminAccess() == -1)
	loadAll();
else
{
	?>
	<script>
		window.location = "?page=start";
		alert("Endast webchefen har tillgång till access!")
	</script>
	<?php
}

if(isset($_POST['submit']))
{
	$access_id = $_POST['id'];
	$add_user_id = $_POST['add_access'];
	$remove_user_id = $_POST['remove_access'];

	DBQuery::sql("INSERT INTO user_access
					(user_id, access_id)
					VALUES ('$add_user_id', '$access_id')");

	DBQuery::sql("DELETE FROM user_access
        					WHERE '$access_id' = access_id AND '$remove_user_id' = user_id");
}

function loadAll()
{
	echo '<div class="row">
			<div class="col-sm-12">
				<div class="page-header">
					<h1>
					<span class="fa fa-wheelchair fa-fw fa-lg"></span> Hantera Access - 
					<a href="?page=createAccess">Skapa Access</a>
					</h1>
				</div>
			</div>
		</div> <!-- .row -->';
	echo '<div class="row">
			<div class="col-sm-6">
				<form action="" method="post">
					<div class="white-box">';

	echo '<label for="access">Access</label>
			<select name="access" id="access" class="bottom-border">
				<option id="typeno" value="typeno">Välj access</option>';
	loadAllAccessAsOption();
	echo '</select>';

	echo '<input type="submit" name="chooseAccess" value="Välj">';
	
	echo 			'</div>
				</form>
			</div>
		</div>';
	if(isset($_POST['chooseAccess']))
	{
		$access = $_POST['access'];
		if($access != '')
			loadAccessManageTools($access);
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

function loadAllPeopleWithThisAccess($access)
{
	$user_access = DBQuery::sql("SELECT user_id FROM user_access
						WHERE access_id = '$access'");

	for($i = 0; $i < count($user_access); ++$i)
	{
		$user_id = $user_access[$i]['user_id'];
		$user = DBQuery::sql("SELECT id, name, last_name FROM user 
						WHERE id = '$user_id'");

		echo '<option value="'.$user[0]['id'].'">'.$user[0]['name'].' '.$user[0]['last_name'].'</option>';
	}
}

function loadAllPeopleWithoutThisAccess($access)
{
	$users = DBQuery::sql("SELECT id, name, last_name FROM user 
						ORDER BY name");

	for($i = 0; $i < count($users); ++$i)
	{
		if(!in_array($users[$i]['id'], $access))
			echo '<option value="'.$users[$i]['id'].'">'.$users[$i]['name'].' '.$users[$i]['last_name'].'</option>';
	}
}

function loadAccessManageTools($access)
{
	$access_name = DBQuery::sql("SELECT id, name FROM access 
						WHERE id = '$access'
						ORDER BY id");

	echo '<div class="row">
			<div class="col-sm-6">
				<form action="" method="post">
					<div class="white-box">';

	echo '<input type="hidden" name="id" id="id" value="'.$access_name[0]['id'].'">';

	echo '<h3>'.$access_name[0]['name'].'</h3>';

	echo '<label for="add_access">Lägg till access</label>
			<select name="add_access" id="add_access" class="bottom-border">
				<option id="typeno" value="NULL">Lägg till access</option>';
	loadAllPeopleWithoutThisAccess($access);
	echo '</select>';

	echo '<label for="remove_access">Ta bort access</label>
			<select name="remove_access" id="remove_access" class="bottom-border">
				<option id="typeno" value="NULL">Ta bort access</option>';
	loadAllPeopleWithThisAccess($access);
	echo '</select>';

	echo '<input type="submit" name="submit" value="Spara">';
	echo '<a href="?page=removeAccess&access_id='.$access.'" onclick="return confirm(\'Är du säker? Det går inte att ångra sig.\')">
			<span class="fa fa-remove fa-fw fa-lg"></span>Ta bort access ('.$access_name[0]['name'].')</a>';
	
	echo 			'</div>
				</form>
			</div>
		</div>';
}

?>