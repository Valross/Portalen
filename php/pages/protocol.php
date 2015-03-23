<?php

function loadProtocolLink()
{
	$user_id = $_SESSION['user_id'];
	$group_id = $_GET['group_id'];

	$memberOfGroup = DBQuery::sql("SELECT group_id FROM group_member 
								WHERE group_id = '$group_id'
								AND user_id = '$user_id'");
	if(count($memberOfGroup) > 0)
	{
		echo '<a href="?page=browseProtocol&group_id='.$group_id.'"><span class="fa fa-list-alt fa-fw fa-lg"></span>Protokoll</a>';
	}
}

function loadRemove()
{
	$group_id = $_GET['group_id'];
	$protocol_id = $_GET['id'];
	echo '<a href=?page=removeProtocol&protocol_id='.$protocol_id.'&group_id='.$group_id.
							' class="list-group-item-text-book"><span class="fa fa-remove fa-fw fa-lg"></span></a>';
}

function loadProtocolTitle()
{
	$protocol_id = $_GET['id'];
	
	$protocol = DBQuery::sql("SELECT title FROM protocol 
						WHERE id = '$protocol_id'"); 

	loadTitleForBrowser($protocol[0]['title']);
	echo $protocol[0]['title'];
}

function loadProtocolMessage()
{
	$protocol_id = $_GET['id'];

	$protocol = DBQuery::sql("SELECT message FROM protocol 
						WHERE id = '$protocol_id'"); 

	echo $protocol[0]['message'];
}

function loadSecretaryName()
{
	$protocol_id = $_GET['id'];

	$protocol = DBQuery::sql("SELECT user_id, date_written FROM protocol 
						WHERE id = '$protocol_id'"); 
	
	$protocol_user_id = $protocol[0]['user_id'];
	$date_written = $protocol[0]['date_written'];

	$secretary_name = DBQuery::sql("SELECT name, last_name FROM user  
							WHERE id = '$protocol_user_id'");

	if(isset($secretary_name[0]['name'])) 
	{
		?>
			<a href=<?php echo '?page=userProfile&id='.$protocol_user_id; ?>>
		<?php
			echo $secretary_name[0]['name'].' '.$secretary_name[0]['last_name'];
		?>
			</a>
		<?php
			echo ' - '.$date_written;
	}
	else
		echo 'John Doe';
}

function loadProtocolAvatar()
{
	$protocol_id = $_GET['id'];

	$protocol = DBQuery::sql("SELECT user_id FROM protocol 
						WHERE id = '$protocol_id'"); 

	$protocol_user_id = $protocol[0]['user_id'];

	if(isset($protocol_user_id))
	{
		$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$protocol_user_id' AND avatar IS NOT NULL");
		if(count($results) == 0)
		{
			return 'img/avatars/no_face_small.png';
		}
		return 'img/avatars/'.$results[0]['avatar'];
	}
}

?>