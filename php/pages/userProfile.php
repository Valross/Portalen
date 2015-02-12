<?php
include_once("php/DBQuery.php");

$user_id = $_GET['id'];

if(isset($_POST['submit']))
{
	if(isset($_POST['addGroup'])) 
	{
		$addGroup = $_POST['addGroup'];
		DBQuery::sql("INSERT INTO group_member (group_id, user_id)
							VALUES ('$addGroup', '$user_id')"); //ändra $user_id till dens profil det är
	}
	if(isset($_POST['removeGroup']))
	{
		$removeGroup = $_POST['removeGroup'];
		DBQuery::sql("DELETE FROM group_member
							WHERE $removeGroup = group_id AND '$user_id' = user_id"); //ändra $user_id till dens profil det är
	}
}

$result = DBQuery::sql("SELECT description FROM user WHERE id = '$user_id' AND description IS NOT NULL");

if(count($result) == 1)
	$profileDescription = $result[0]["description"];
else
	$profileDescription = "Hej ".$_SESSION['name']." har inte skrivit något om sig själv ännu.";

$result = DBQuery::sql("SELECT phone_number FROM user WHERE id = '$user_id' AND phone_number IS NOT NULL");

if(count($result) == 1)
	$profileNumber = $result[0]["phone_number"];
else
	$profileNumber = "";


$result = DBQuery::sql("SELECT date_created FROM user WHERE id = '$user_id' AND date_created IS NOT NULL");

if(count($result) == 1)
	$profileCreation = $result[0]["date_created"];
else
	$profileCreation = "";

$result = DBQuery::sql("SELECT mail FROM user WHERE id = '$user_id' AND mail IS NOT NULL");

if(count($result) == 1)
	$profileMail = $result[0]["mail"];
else
	$profileMail = "";

function loadUnjoinedGroups()
{
	$groups = DBQuery::sql("SELECT id, name FROM work_group 
							WHERE id NOT IN 
							(SELECT group_id FROM group_member WHERE user_id = '$user_id')
							ORDER BY name");
	for($i = 0; $i < count($groups); ++$i)
	{
		?>
			<option value="<?php echo $groups[$i]['id']; ?>"><?php echo $groups[$i]['name']; ?></option>
		<?php
	}
}

function loadGroups()
{
	$user_id = $_GET['id'];

	$groups = DBQuery::sql("SELECT id, name FROM work_group 
							WHERE id IN 
							(SELECT group_id FROM group_member WHERE user_id = '$user_id')
							ORDER BY name");
	for($i = 0; $i < count($groups); ++$i)
	{
		?>
			<p><?php echo $groups[$i]['name']; ?></p>
		<?php
	}
}

function loadGroupsOption()
{
	$groups = DBQuery::sql("SELECT id, name FROM work_group 
							WHERE id IN 
							(SELECT group_id FROM group_member WHERE user_id = '$user_id')
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
	//if(admin_rights)
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

function removeFromGroup()
{
	//if(admin_rights)
	?>
	<div class="col-sm-6">
		<div class="white-box">
			<form action="" method="post">
				<label for="removeGroup">Ta bort från lag</label>
					<select name="removeGroup" id="removeGroup">
						<option id="typeno" value="no">Välj lag</option>
						<?php loadGroupsOption(); ?>
					</select>
				<input type="submit" name="submit" value="Ta bort">		
			</form>
		</div>
	</div>
	<?php
}

function loadUserName()
{
	$user_id = $_GET['id'];

	$user_name = DBQuery::sql("SELECT name, last_name FROM user  
							WHERE id = '$user_id'");

	if(isset($user_name[0]['name']))
		echo $user_name[0]['name'].' '.$user_name[0]['last_name'];
	else
		echo 'John Doe';
}

function loadUserAvatar()
{
	$user_id = $_GET['id'];

	if(isset($user_id))
	{
		$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$user_id' AND avatar IS NOT NULL");
		if(count($results) == 0)
		{
			return 'img/avatars/no_face_small.png';
		}
		return 'img/avatars/'.$results[0]['avatar'];
	}
}

?>