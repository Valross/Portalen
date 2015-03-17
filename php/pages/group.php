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
}

function loadGroupName()
{
	$group_id = $_GET['id'];

	$groupName = DBQuery::sql("SELECT name, icon FROM work_group 
							WHERE id = '$group_id'");
	
	if($groupName[0]['icon'] != '')
		echo '<span class="'.$groupName[0]['icon'].' list-group-thumbnail group-badge webb"></span>';
	else
		echo '<span class="fa fa-code fa-fw list-group-thumbnail group-badge webb"></span>'; 
	echo $groupName[0]['name'];
}

function loadGroupInfo()
{
	$group_id = $_GET['id'];

	$groupName = DBQuery::sql("SELECT description FROM work_group 
							WHERE id = '$group_id'");

	echo $groupName[0]['description'];
}

function loadMemberAvatar($user_id)
{
	$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$user_id' AND avatar IS NOT NULL");
	if(count($results) == 0)
	{
		return 'img/avatars/no_face_small.png';
	}
	return 'img/avatars/'.$results[0]['avatar'];
}

function loadMembersOfGroup()
{
	$group_id = $_GET['id'];

	$members = DBQuery::sql("SELECT name, last_name, id FROM user 
							WHERE id IN 
							(SELECT user_id FROM group_member WHERE group_id = '$group_id')");

	for($i = 0; $i < count($members); ++$i)
	{
		$member_id = $members[$i]['id'];
		$group_members = DBQuery::sql("SELECT user_id, group_id, member_since FROM group_member 
							WHERE user_id = '$member_id' AND group_id = '$group_id'");
		?>
		<a href=<?php echo '"?page=userProfile&id='.$members[$i]['id'].'"'; ?> class="list-group-item with-thumbnail">
			<img src="<?php echo loadMemberAvatar($member_id); ?>" class="img-circle list-group-thumbnail" width="32" height="32">
				<?php echo $members[$i]['name'].' '.$members[$i]['last_name']; ?>
				<span class="list-group-item-text pull-right">sedan <?php echo $group_members[0]['member_since']; ?></span>
		</a>
		<?php
	}
}

function loadGroupLeader()
{
	$group_id = $_GET['id'];

	$groupLeader = DBQuery::sql("SELECT name, last_name, id FROM user 
							WHERE id IN 
							(SELECT user_id FROM work_group_leaders WHERE work_group_id = '$group_id')");

	for($i = 0; $i < count($groupLeader); ++$i)
	{
		$groupLeader_id = $groupLeader[$i]['id'];
		?>
		<a href=<?php echo '"?page=userProfile&id='.$groupLeader[$i]['id'].'"'; ?> class="">
			<img src="<?php echo loadMemberAvatar($groupLeader_id); ?>" class="img-circle list-group-thumbnail" width="32" height="32">
				<?php echo $groupLeader[$i]['name'].' '.$groupLeader[$i]['last_name']; ?>
		</a>
		<?php
	}
	if(count($groupLeader) == 0)
		echo 'ej angivet';
}

function loadFacebookGroupURL()
{
	$group_id = $_GET['id'];

	$facebookGroupURL = DBQuery::sql("SELECT facebook_group FROM work_group 
							WHERE id = '$group_id'");

	for($i = 0; $i < count($facebookGroupURL); ++$i)
	{
		?>
		<a href=<?php echo '"'.$facebookGroupURL[$i]['facebook_group'].'"'; ?> class="">
				<?php echo $facebookGroupURL[$i]['facebook_group']; ?>
		</a>
		<?php
	}
	if(count($facebookGroupURL) == 0)
		echo 'ej angivet';
}

?>