<?php
include_once("php/DBQuery.php");

$group_id = $_GET['id'];
$dates = new DateTime;
$dates->setTimezone(new DateTimeZone('Europe/Stockholm'));
$date = $dates->format('Y-m-d');

$members = DBQuery::sql("SELECT name, last_name, id FROM user 
							WHERE id IN 
							(SELECT user_id FROM group_member WHERE group_id = '$group_id')");

$nMembers = count($members);

if(isset($_POST['accept']))
{
	$group_id = $_GET['id'];
	$user_id = $_SESSION['user_id'];

	DBQuery::sql("INSERT INTO group_member (group_id, user_id, group_leader, member_since)
						VALUES ('$group_id', '$user_id', '0', '$date')");

	DBQuery::sql("DELETE FROM group_application 
					WHERE user_id = '$user_id'
					AND group_id = '$group_id'");
}
if(isset($_POST['deny']))
{
	$group_id = $_GET['id'];
	$user_id = $_SESSION['user_id'];

	DBQuery::sql("DELETE FROM group_application 
					WHERE user_id = '$user_id'
					AND group_id = '$group_id'");
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

function loadProtocolLink()
{
	$user_id = $_SESSION['user_id'];
	$group_id = $_GET['id'];

	$memberOfGroup = DBQuery::sql("SELECT group_id FROM group_member 
								WHERE group_id = '$group_id'
								AND user_id = '$user_id'");
	if(count($memberOfGroup) > 0)
	{
		echo ' - <a href="?page=browseProtocol&group_id='.$group_id.'"><span class="fa fa-list-alt fa-fw fa-lg"></span>Protokoll</a>';
	}
}

function loadDotLink()
{
	$user_id = $_SESSION['user_id'];
	$group_id = $_GET['id'];

	$memberOfGroup = DBQuery::sql("SELECT group_id FROM group_member 
								WHERE group_id = '$group_id'
								AND user_id = '$user_id'");
	if(count($memberOfGroup) > 0)
	{
		echo ' - <a href="?page=browseDots&group_id='.$group_id.'" class="black-link"><span class="fa fa-ellipsis-v fa-fw fa-lg"></span>Punkter</a>';
	}
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
	$user_id = $_SESSION['user_id'];
	$group_id = $_GET['id'];

	$facebookGroupURL = DBQuery::sql("SELECT facebook_group FROM work_group 
							WHERE id = '$group_id'");

	$memberOfGroup = DBQuery::sql("SELECT group_id FROM group_member 
								WHERE group_id = '$group_id'
								AND user_id = '$user_id'");

	if(count($memberOfGroup) > 0)
	{
		echo '<tr><td><strong>Facebookgrupp</strong></td>';
		echo '<td><a href="'.$facebookGroupURL[0]['facebook_group'].'"class="">';
		echo $facebookGroupURL[0]['facebook_group'].'</a></td></tr>';	
	}
}

function loadApplyForGroupButton()
{
	$group_id = $_GET['id'];
	$user_id = $_SESSION['user_id'];

	$memberOfGroup = DBQuery::sql("SELECT group_id FROM group_member 
							WHERE group_id = '$group_id'
							AND user_id = '$user_id'");

	$alreadyApplied = DBQuery::sql("SELECT group_id, user_id FROM group_application 
							WHERE group_id = '$group_id'
							AND user_id = '$user_id'");

	if(count($memberOfGroup) == 0)
	{
		if(count($alreadyApplied) == 0)
		{
			echo '<form action="" method="post">';
			echo '<tr><td><input type="submit" name="apply" value="Sök detta laget"></td></tr>';
			echo '</form>';
		}
		else
			echo '<tr><td>Du söker det här laget</td></tr>';
		
	}
}

function loadApplications()
{
	$group_id = $_GET['id'];
	$user_id = $_SESSION['user_id'];

	$leaderOfGroup = DBQuery::sql("SELECT user_id FROM work_group_leaders 
							WHERE work_group_id = '$group_id'
							AND user_id = '$user_id'");

	$applications = DBQuery::sql("SELECT id, group_id, user_id FROM group_application
								WHERE group_id = '$group_id'");

	if(count($leaderOfGroup) > 0)
	{
		echo '<h3>Ansökningar</h3>';
		if(count($applications) > 0)
		{
			echo '<form action="" method="post">';
			for($i = 0; $i < count($applications); ++$i)
			{
				echo '<p>';
				echo '<input type="checkbox" name="applications[]" id="'.$applications[$i]['id'].'" value="'.$applications[$i]['id'].'">';
				echo '<a href="?page=userProfile&id='.$user_id.'" class="work-slot-user black-link"> '.loadAvatarFromUser($user_id, 20).loadNameFromUser($user_id).'</a>';
				echo '</p>';
			}
			echo '<input type="submit" name="accept" value="Acceptera">';
			echo '<input type="submit" name="deny" value="Neka">';
			echo '</form>';
		}
		else
			echo '<p>Inga ansökningar just nu</p>';
	}
}

?>