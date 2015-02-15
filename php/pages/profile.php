<?php
include_once("php/DBQuery.php");

if(isset($_POST['submit']))
{
	if(isset($_POST['addGroup'])) 
	{
		$addGroup = $_POST['addGroup'];
		DBQuery::sql("INSERT INTO group_member (group_id, user_id)
							VALUES ('$addGroup', '$_SESSION[user_id]')"); //ändra $_SESSION[user_id] till dens profil det är
	}
	if(isset($_POST['removeGroup']))
	{
		$removeGroup = $_POST['removeGroup'];
		DBQuery::sql("DELETE FROM group_member
							WHERE $removeGroup = group_id AND $_SESSION[user_id] = user_id"); //ändra $_SESSION[user_id] till dens profil det är
	}
}

$result = DBQuery::sql("SELECT description FROM user WHERE id = '$_SESSION[user_id]' AND description IS NOT NULL");

if(count($result) == 1)
	$profileDescription = $result[0]["description"];
else
	$profileDescription = "Hej ".$_SESSION['name']." har inte skrivit något om sig själv ännu.";

$result = DBQuery::sql("SELECT phone_number FROM user WHERE id = '$_SESSION[user_id]' AND phone_number IS NOT NULL");

if(count($result) == 1)
	$profileNumber = $result[0]["phone_number"];
else
	$profileNumber = "";


$result = DBQuery::sql("SELECT date_created FROM user WHERE id = '$_SESSION[user_id]' AND date_created IS NOT NULL");

if(count($result) == 1)
	$profileCreation = $result[0]["date_created"];
else
	$profileCreation = "";

$result = DBQuery::sql("SELECT mail FROM user WHERE id = '$_SESSION[user_id]' AND mail IS NOT NULL");

if(count($result) == 1)
	$profileMail = $result[0]["mail"];
else
	$profileMail = "";

function loadUnjoinedGroups()
{
	$groups = DBQuery::sql("SELECT id, name FROM work_group 
							WHERE id NOT IN 
							(SELECT group_id FROM group_member WHERE user_id = '$_SESSION[user_id]')
							ORDER BY name");
	for($i = 0; $i < count($groups); ++$i)
	{
		?>
			<option value="<?php echo $groups[$i]['id']; ?>"><?php echo $groups[$i]['name']; ?></option>
		<?php
	}
}

function addToGroup()
{
	$user_id = $_SESSION['user_id'];
	$admin_rights_group_bool = false;

	$admin_rights_user = DBQuery::sql("SELECT access_id, user_id FROM user_access 
							WHERE user_id = '$user_id' AND access_id = 1");
	$admin_rights_group = DBQuery::sql("SELECT access_id, group_id FROM group_access");
	$users_groups = DBQuery::sql("SELECT user_id, group_id FROM group_member
							WHERE user_id = '$user_id'");

	for($i = 0; $i < count($admin_rights_group); ++$i)
	{
		for($j = 0; $j < count($users_groups); ++$j)
		{
			if($admin_rights_group[$i]['group_id'] == $users_groups[$j]['group_id'])
				$admin_rights_group_bool = true;
		}
	}

	if($admin_rights_group_bool || isset($admin_rights_user[0]))
	{
		?>
		<div class="col-sm-6">
			<div class="white-box">
				<form action="" method="post">
					<label for="addGroup">Lägg till i lag</label>
						<select name="addGroup" id="addGroup">
							<option id="typeno" value="no">Välj lag</option>
							<?php loadUnjoinedGroups(); ?>
						</select>
					<input type="submit" name="submit" value="Lägg till">		
				</form>
			</div>
		</div>
		<?php
	}
}

function removeFromGroup()
{
	$user_id = $_SESSION['user_id'];
	$admin_rights_group_bool = false;

	$admin_rights_user = DBQuery::sql("SELECT access_id, user_id FROM user_access 
							WHERE user_id = '$user_id' AND access_id = 1");
	$admin_rights_group = DBQuery::sql("SELECT access_id, group_id FROM group_access");
	$users_groups = DBQuery::sql("SELECT user_id, group_id FROM group_member
							WHERE user_id = '$user_id'");

	for($i = 0; $i < count($admin_rights_group); ++$i)
	{
		for($j = 0; $j < count($users_groups); ++$j)
		{
			if($admin_rights_group[$i]['group_id'] == $users_groups[$j]['group_id'])
				$admin_rights_group_bool = true;
		}
	}

	if($admin_rights_group_bool || isset($admin_rights_user[0]))
	{
		?>
		<div class="col-sm-6">
			<div class="white-box">
				<form action="" method="post">
					<label for="removeGroup">Ta bort från lag</label>
						<select name="removeGroup" id="removeGroup">
							<option id="typeno" value="no">Välj lag</option>
							<?php loadMyGroupsOption(); ?>
						</select>
					<input type="submit" name="submit" value="Ta bort">		
				</form>
			</div>
		</div>
		<?php
	}
}

?>