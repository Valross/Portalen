<?php
include_once('php/DBQuery.php');

if(isset($_POST['submit']) && checkAdminAccess() <= 1)
{
	$title = strip_tags($_POST['title']);
	$message = strip_tags($_POST['message'], allowed_tags());
	$group_id = $_GET['group_id'];
	
	if($title != '' && $message != '')
	{
		DBQuery::sql("INSERT INTO protocol (title, message, date_written, user_id, group_id)
						VALUES ('$title', '$message', '$date', '$_SESSION[user_id]', '$group_id')");

		$protocol = DBQuery::sql("SELECT id FROM protocol 
						WHERE group_id = '$group_id'
						ORDER BY date_written DESC");

		$protocol_id = $protocol[0]['id'];

		$users = DBQuery::sql("SELECT id FROM user
							WHERE id IN
								(SELECT user_id FROM group_member
								WHERE group_id = '$group_id')");

		for($i = 0; $i < count($users); ++$i)
		{
			if($users[$i]['id'] != $_SESSION['user_id'])
				notify($users[$i]['id'], 7, $protocol_id);
		}
		?>
		<script>
			window.location = "?page=protocol&id=<?php echo $protocol_id; ?>
					&group_id=<?php echo $group_id; ?>";
		</script>
		<?php
	}

	else
	{
		?>
		<script>
			window.location = "?page=start";
			alert("Fel: Du måste fylla i båda fält.")
		</script>
		<?php
	}
}

function loadGroupName()
{
	$group_id = $_GET['group_id'];

	$group_name = DBQuery::sql("SELECT name, id FROM work_group 
						WHERE id = '$group_id'");
	loadTitleForBrowser('Skapa Protokoll - '.$group_name[0]['name']);

	echo '<a href="?page=group&id='.$group_name[0]['id'].'">'.$group_name[0]['name'].'</a>';
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
		echo '<a href="?page=browseProtocol&group_id='.$group_id.'"><span class="fa fa-list-alt fa-fw fa-lg"></span>Protokoll</a>';
	}
}
?>