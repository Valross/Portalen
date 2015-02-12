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
		echo($removeGroup);
		DBQuery::sql("DELETE FROM group_member
							WHERE $removeGroup = group_id AND $_SESSION[user_id] = user_id"); //ändra $_SESSION[user_id] till dens profil det är
	}
}

$result = DBQuery::sql("SELECT description FROM user WHERE id = '$_SESSION[user_id]' AND description IS NOT NULL");

if(count($result) == 1)
	$groupDescription = $result[0]["description"];
else
	$groupDescription = "Hej ".$_SESSION['name']." har inte skrivit något om sig själv ännu.";

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

function loadMembersOfGroup()
{
	$groups = DBQuery::sql("SELECT user_id FROM group_member 
							WHERE group_id = 2");
	for($i = 0; $i < count($groups); ++$i)
	{
		?>
			<option value="<?php echo $groups[$i]['user_id']; ?>"><?php echo $groups[$i]['user_id']; ?></option>
		<?php
	}
}

?>