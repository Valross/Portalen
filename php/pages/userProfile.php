<?php
include_once("php/DBQuery.php");

$user_id = $_GET['id'];

if(isset($_POST['submit']))
{
	if(isset($_POST['addGroup'])) 
	{
		$addGroup = $_POST['addGroup'];
		DBQuery::sql("INSERT INTO group_member (group_id, user_id)
							VALUES ('$addGroup', '$user_id')"); 
	}
	if(isset($_POST['removeGroup']))
	{
		$removeGroup = $_POST['removeGroup'];
		DBQuery::sql("DELETE FROM group_member
							WHERE $removeGroup = group_id AND '$user_id' = user_id");
	}
}

$result = DBQuery::sql("SELECT description FROM user WHERE id = '$user_id' AND description IS NOT NULL");

if(count($result) == 1)
	$profileDescription = $result[0]["description"];
else
	$profileDescription = "Hej, den här personen har inte skrivit något om sig själv ännu.";

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

$result = DBQuery::sql("SELECT latest_session FROM user WHERE id = '$user_id' AND latest_session IS NOT NULL");

if(count($result) == 1)
	$latest_session = $result[0]["latest_session"];
else
	$latest_session = "";

$result = DBQuery::sql("SELECT major FROM user WHERE id = '$user_id' AND major IS NOT NULL");

if(count($result) == 1)
	$major = $result[0]["major"];
else
	$major = "";

$result = DBQuery::sql("SELECT address FROM user WHERE id = '$user_id' AND address IS NOT NULL");

if(count($result) == 1)
	$address = $result[0]["address"];
else
	$address = "";

function loadUnjoinedGroups()
{
	$user_id = $_GET['id'];

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
		$group_id = $groups[$i]['id'];
		$group_members = DBQuery::sql("SELECT user_id, group_id, member_since FROM group_member 
							WHERE user_id = '$user_id' AND group_id = '$group_id'");
		?>
			<a href=<?php echo '"?page=group&id='.$groups[$i]['id'].'"'; ?> class="list-group-item with-thumbnail">
				<span class="fa fa-code fa-fw list-group-thumbnail group-badge webb"></span>
				<?php echo $groups[$i]['name']; ?>
				<span class="list-group-item-text pull-right"><?php echo 'sedan '.$group_members[0]['member_since']; ?></span>
			</a>
		<?php
	}
}

function loadGroupsOption()
{
	$user_id = $_GET['id'];

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
	$user_id = $_SESSION['user_id'];

	if(checkAdminAccess())
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

	if(checkAdminAccess())
	{
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
}

function loadUserName()
{
	$user_id = $_GET['id'];

	$user = DBQuery::sql("SELECT name, last_name, achievement_points FROM user  
							WHERE id = '$user_id'");

	if(isset($user[0]['name']))
	{
		echo $user[0]['name'].' '.$user[0]['last_name'];
		echo ' - <span class="fa fa-diamond fa-fw"></span><a href="?page=browseUserAchievements&id='.$user_id.'">'.$user[0]['achievement_points'].'</a>';
	}
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

function loadLastWorked()
{
	$user_id = $_GET['id'];
	$lastWorked = DBQuery::sql("SELECT id, name, start_time FROM event
								WHERE id IN
									(SELECT event_id FROM work_slot
									WHERE id IN
										(SELECT work_slot_id FROM user_work
										WHERE user_id = '$user_id' AND checked = 1))
								ORDER BY start_time DESC");
	if(count($lastWorked) > 0)
		echo '<a href=?page=event&id='.$lastWorked[0]['id'].'>'.$lastWorked[0]['name'].' ('.$lastWorked[0]['start_time'].')'.'</a>';
	else
		echo 'Har ej jobbat';
}

function loadAge()
{
	$user_id = $_GET['id'];

	$user_name = DBQuery::sql("SELECT ssn FROM user  
							WHERE id = '$user_id'");

	// $slotStart = new DateTime($slots[$j]['start_time']);
	// $start_h = $slotStart->format('H:i');

	echo 'to be calculated';
}

?>