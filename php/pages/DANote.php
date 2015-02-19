<?php

$dates = new DateTime;
$dates->setTimezone(new DateTimeZone('Europe/Stockholm'));
$date = $dates->format('Y-m-d H:i:s');

if(isset($_POST['submit']))
{
	$comment = $_POST['comment'];
	$da_note_event_id = $_GET['id'];

	$da_note = DBQuery::sql("SELECT id FROM da_note
							WHERE event_id = '$da_note_event_id'");

	$da_note_id = $da_note[0]['id'];
	
	if($comment != '')
	{
		DBQuery::sql("INSERT INTO da_note_comments (user_id, da_note_id, comment, date_written)
						VALUES ('$_SESSION[user_id]', '$da_note_id', '$comment', '$date')");
		?>
		<script>
			window.location = <?php echo '?page=DANote&id='.$da_note_event_id; ?>;
		</script>
		<?php
	}
	
}

function loadEventName()
{
	$event_id = $_GET['id'];
	
	$eventName = DBQuery::sql("SELECT name, start_time FROM event
							WHERE id = '$event_id'");

	?>
	<a href=<?php echo '?page=event&id='.$event_id; ?>>
	<?php
	echo $eventName[0]['name'].'</a> '.$eventName[0]['start_time'];
}

function loadDAStats()
{
	$event_id = $_GET['id'];

	$DANotes = DBQuery::sql("SELECT da_note.event_id, da_note.sales_entry, da_note.sales_bar, da_note.cash, 
									da_note.n_of_people, da_note.sales_spenta, da_note.message, event.name FROM da_note 
							INNER JOIN event ON da_note.event_id = event.id WHERE event.id = '$event_id'");
	?>
	<tr>
		<td><?php echo $DANotes[0]['sales_entry']; ?></td>
		<td><?php echo $DANotes[0]['sales_bar']; ?></td>
		<td><?php echo $DANotes[0]['cash']; ?></td>
		<td><?php echo $DANotes[0]['n_of_people']; ?></td>
		<td><?php echo $DANotes[0]['sales_spenta']; ?></td>
	</tr>
	<?php
}

function loadDAMessage()
{
	$event_id = $_GET['id'];

	$DANotes = DBQuery::sql("SELECT da_note.event_id, da_note.message FROM da_note 
							INNER JOIN event ON da_note.event_id = event.id WHERE event.id = '$event_id'");

	echo $DANotes[0]['message'];
}

function loadDAName()
{
	$event_id = $_GET['id'];

	$DA = DBQuery::sql("SELECT user_id, date_written FROM da_note 
						WHERE event_id = '$event_id'"); 
	$DA_id = $DA[0]['user_id'];
	$DA_note_date = $DA[0]['date_written'];

	$DA_name = DBQuery::sql("SELECT name, last_name FROM user  
							WHERE id = '$DA_id'");

	if(isset($DA_name[0]['name'])) 
	{
		?>
			<a href=<?php echo '?page=userProfile&id='.$DA_id; ?>>
		<?php
			echo $DA_name[0]['name'].' '.$DA_name[0]['last_name'];
		?>
			</a>
		<?php
			echo ' - '.$DA_note_date;
	}
	else
		echo 'John Doe';
}

function loadDAAvatar()
{
	$event_id = $_GET['id'];

	$DA = DBQuery::sql("SELECT user_id FROM da_note 
						WHERE event_id = '$event_id'"); 
	if(count($DA) > 0)
		$DA_id = $DA[0]['user_id'];

	if(isset($DA_id))
	{
		$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$DA_id' AND avatar IS NOT NULL");
		if(count($results) == 0)
		{
			return 'img/avatars/no_face_small.png';
		}
		return 'img/avatars/'.$results[0]['avatar'];
	}
}

function loadCommentAvatar($comment_id)
{
	$event_id = $_GET['id'];

	$user = DBQuery::sql("SELECT user_id FROM da_note_comments 
						WHERE da_note_id IN
							(SELECT id FROM da_note 
							WHERE event_id = '$event_id')
						AND id = '$comment_id'"); 
	if(count($user) > 0)
		$user_id = $user[0]['user_id'];

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

function loadComments()
{
	$da_note_event_id = $_GET['id'];
	$da_note = DBQuery::sql("SELECT id FROM da_note
							WHERE event_id = '$da_note_event_id'");

	$da_note_id = $da_note[0]['id'];

	$DAComments = DBQuery::sql("SELECT id, da_note_id, comment, date_written FROM da_note_comments 
							WHERE da_note_id = '$da_note_id'");

	if(count($DAComments) > 0)
	{
		echo '<div class="row">
					<div class="col-sm-12">
						<div class="white-box">';
		echo '<h1>Kommentarer</h1>';
	

		for($i = 0; $i < count($DAComments); ++$i)
		{
			echo '<div>';
			echo '<img src="'.loadCommentAvatar($DAComments[$i]['id']).'" width="100" height="100" class="page-header-img">';
			echo '<p>'.$DAComments[$i]['date_written'].'</p>';
			echo '<p>'.$DAComments[$i]['comment'].'</p>';
			echo '</div>';
		}
		echo '			</div>
						</div>
					</div>';
	}
}

?>