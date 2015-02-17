<?php
include_once("php/DBQuery.php");

$group_id = $_GET['id'];

$members = DBQuery::sql("SELECT name, last_name, id FROM user 
							WHERE id IN 
							(SELECT user_id FROM group_member WHERE group_id = '$group_id')");

$nMembers = count($members);

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
	$groupDescription = $result[0]["description"];
else
	$groupDescription = "Hej, gruppen har ingen beskrivning ännu.";

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

function loadGroupName()
{
	$group_id = $_GET['id'];

	$groupName = DBQuery::sql("SELECT name FROM work_group 
							WHERE id = '$group_id'");
	echo $groupName[0]['name'];
}

function loadMembersOfGroup()
{
	$group_id = $_GET['id'];

	$members = DBQuery::sql("SELECT name, last_name, id FROM user 
							WHERE id IN 
							(SELECT user_id FROM group_member WHERE group_id = '$group_id')");

	// $members = DBQuery::sql("SELECT user.name, user.last_name FROM user 
	// 						INNER JOIN group_member ON user.id = group_member.user_id
	// 						ORDER BY user.last_name");

	for($i = 0; $i < count($members); ++$i)
	{
		?>
		<a href=<?php echo '"?page=userProfile&id='.$members[$i]['id'].'"'; ?> class="list-group-item">
				<?php echo $members[$i]['name'].' '.$members[$i]['last_name']; ?>
		</a>
		<?php
	}
}

?>