<?php

function loadGroupName()
{
	$group_id = $_GET['group_id'];

	$group_name = DBQuery::sql("SELECT name, id, icon, hex FROM work_group 
						WHERE id = '$group_id'");

	if($group_name[0]['icon'] != '')
		echo '<span class="'.$group_name[0]['icon'].' list-group-thumbnail group-badge webb"></span>';
	else
		echo '<span class="fa fa-code fa-fw list-group-thumbnail group-badge webb"></span>'; 

	echo '<a href="?page=group&id='.$group_name[0]['id'].'">'.$group_name[0]['name'].'</a>';
}

function loadDotsLink()
{
	$user_id = $_SESSION['user_id'];
	$group_id = $_GET['group_id'];

	$memberOfGroup = DBQuery::sql("SELECT group_id FROM group_member 
								WHERE group_id = '$group_id'
								AND user_id = '$user_id'");
	if(count($memberOfGroup) > 0)
	{
		echo '<a href="?page=browseDots&group_id='.$group_id.'"><span class="fa fa-ellipsis-v fa-fw fa-lg"></span>Punkter</a>';
	}
}

function loadProtocolLink()
{
	$user_id = $_SESSION['user_id'];
	$group_id = $_GET['group_id'];

	$memberOfGroup = DBQuery::sql("SELECT group_id FROM group_member 
								WHERE group_id = '$group_id'
								AND user_id = '$user_id'");
	if(count($memberOfGroup) > 0)
	{
		echo '<a href="?page=createProtocol&group_id='.$group_id.'"><span class="fa fa-pencil-square-o fa-fw fa-lg"></span>Skriv protokoll</a>';
	}
}

function loadProtocolAvatar($user_id)
{
	$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$user_id' AND avatar IS NOT NULL");
	if(count($results) == 0)
	{
		return 'img/avatars/no_face_small.png';
	}
	return 'img/avatars/'.$results[0]['avatar'];
}

function loadAllProtocols()
{
	$user_id = $_SESSION['user_id'];
	$group_id = $_GET['group_id'];

	$memberOfGroup = DBQuery::sql("SELECT group_id FROM group_member 
								WHERE group_id = '$group_id'
								AND user_id = '$user_id'");

	$protocols = DBQuery::sql("SELECT id, title, date_written, user_id, group_id FROM protocol 
							WHERE group_id = '$group_id'
							ORDER BY date_written DESC");

	if(count($protocols) > 0 && count($memberOfGroup) > 0)
	{
		for($i = 0; $i < count($protocols); ++$i)
		{
			?>
			<tr>
				<td><?php echo $i+1;?></td>
				<td><a href=<?php echo '"?page=protocol&id='.$protocols[$i]['id'].'&group_id='.$protocols[$i]['group_id'].'"'; ?>>
				<?php echo $protocols[$i]['title']; ?></a></td>
				<td><?php echo $protocols[$i]['date_written']; ?></td>
				<td><a href=<?php echo '?page=userProfile&id='.$protocols[$i]['user_id']; ?>>
				<img src="<?php echo loadProtocolAvatar($protocols[$i]['user_id']); ?>" width="25" height="25" class="img-circle"></a></td>
			</tr>
			<?php
		}
	}
}

?>