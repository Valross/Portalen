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
	$eventStart = new DateTime($eventName[0]['start_time']);
	$start = $eventStart->format('Y-m-d');
	echo $eventName[0]['name'].'</a> - '.$start;
}

function loadDAStats()
{
	$event_id = $_GET['id'];

	$DANotes = DBQuery::sql("SELECT da_note.event_id, da_note.sales_total, da_note.sales_entry, da_note.sales_bar, da_note.cash, 
									da_note.n_of_people, da_note.sales_spenta, da_note.message, event.name FROM da_note 
							INNER JOIN event ON da_note.event_id = event.id WHERE event.id = '$event_id'");
	?>
	<tr>
		<td><?php echo $DANotes[0]['sales_total']; ?></td>
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

function loadArrangingPartyries()
{
	$event_id = $_GET['id'];
	
	$arrangingPartyries = DBQuery::sql("SELECT id, name FROM partyries
							WHERE id IN
							(SELECT partyries_id FROM partyries_arrange
							WHERE event_id = '$event_id')");

	if(count($arrangingPartyries) > 0)
	{
		echo '<div class="col-sm-3">
						<div class="white-box">';
		if(count($arrangingPartyries) > 1)
			echo '<h4>Arrangerande festerier</h4>';
		else
			echo '<h4>Arrangerande festeri</h4>';

		for($i = 0; $i < count($arrangingPartyries); ++$i)
		{
			echo '<p>';
			echo $arrangingPartyries[$i]['name'];
			echo '</p>';
		}
		echo '			</div>
					</div>';
	}
}

function loadWorkingPartyries()
{
	$event_id = $_GET['id'];
	
	$workingPartyries = DBQuery::sql("SELECT id, name FROM partyries
							WHERE id IN
							(SELECT partyries_id FROM partyries_work
							WHERE event_id = '$event_id')");

	if(count($workingPartyries) > 0)
	{
		echo '<div class="col-sm-3">
						<div class="white-box">';
		if(count($workingPartyries) > 1)
			echo '<h4>Arbetande festerier</h4>';
		else
			echo '<h4>Arbetande festeri</h4>';

		for($i = 0; $i < count($workingPartyries); ++$i)
		{
			echo '<p>';
			echo $workingPartyries[$i]['name'];
			echo '</p>';
		}
		echo '			</div>
					</div>';
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
		echo '<div class="col-sm-7">
						<div class="white-box">';
		echo '<h3>Kommentarer ('.count($DAComments).')</h3>';
	

		for($i = 0; $i < count($DAComments); ++$i)
		{
			echo '<div class="comment">';
			echo '<img src="'.loadCommentAvatar($DAComments[$i]['id']).'" width="64" height="64" class="img-circle">';
			echo '<p><a href="?page=userProfile&id='.$user_id.'">'.$commenter[0]['name'].' '.$commenter[0]['last_name'].'</a> ';
			echo '<span class="time">- '.$DAComments[$i]['date_written'].'</span><br />';
			echo $DAComments[$i]['comment'].'</p>';
			echo '</div>';
		}
		echo '			</div> <!-- .white-box -->
					</div> <!-- .col-sm-7 -->';
	}
}

?>