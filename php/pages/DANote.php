<?php

if(isset($_POST['submit']))
{
	$comment = strip_tags($_POST['comment'], allowed_tags());
	$da_note_event_id = $_GET['id'];

	$da_note = DBQuery::sql("SELECT id FROM da_note
							WHERE event_id = '$da_note_event_id'");

	$da_note_id = $da_note[0]['id'];
	
	if($comment != '')
	{
		DBQuery::sql("INSERT INTO da_note_comments (user_id, da_note_id, comment)
						VALUES ('$_SESSION[user_id]', '$da_note_id', '$comment')");

		$da_note_comment = DBQuery::sql("SELECT id FROM da_note_comments 
						ORDER BY date_written DESC");

		$da_note_comment_id = $da_note_comment[0]['id'];

		$users = DBQuery::sql("SELECT id FROM user
							WHERE id IN
								(SELECT user_id FROM group_member
								WHERE group_id = 7 OR group_id = 1 OR group_id = 12)");

		for($i = 0; $i < count($users); ++$i)
		{
			if($users[$i]['id'] != $_SESSION['user_id'])
				notify($users[$i]['id'], 11, $da_note_comment_id);
		}
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
	loadTitleForBrowser('DA-lapp - '.$eventName[0]['name']);

	echo '<a href=?page=event&id='.$event_id.'>';

	$eventStart = new DateTime($eventName[0]['start_time']);
	$start = $eventStart->format('D Y-m-d');
	echo $eventName[0]['name'].'</a> - '.$start;
}

function loadDAStats()
{
	$event_id = $_GET['id'];

	$DANotes = DBQuery::sql("SELECT da_note.event_id, da_note.sales_total, da_note.sales_entry, da_note.sales_bar, da_note.cash, 
									da_note.n_of_people, da_note.sales_spenta, da_note.sales_shots, da_note.message, event.name FROM da_note 
							INNER JOIN event ON da_note.event_id = event.id WHERE event.id = '$event_id'");

	echo '<tr>';
		echo '<td>'.$DANotes[0]['sales_total'].'</td>';
		echo '<td>'.$DANotes[0]['sales_entry'].'</td>';
		echo '<td>'.$DANotes[0]['sales_bar'].'</td>';
		echo '<td>'.$DANotes[0]['cash'].'</td>';
		echo '<td>'.$DANotes[0]['n_of_people'].'</td>';
		echo '<td>'.$DANotes[0]['sales_spenta'].'</td>';
		echo '<td>'.$DANotes[0]['sales_shots'].'</td>';
	echo '</tr>';
}

function loadDAFixlist()
{
	$event_id = $_GET['id'];

	$DANotes = DBQuery::sql("SELECT da_note.event_id, da_note.fixlist FROM da_note 
							INNER JOIN event ON da_note.event_id = event.id WHERE event.id = '$event_id'");

	echo $DANotes[0]['fixlist'];
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
		echo '<a href=?page=userProfile&id='.$DA_id.'>';
		echo $DA_name[0]['name'].' '.$DA_name[0]['last_name'];
		echo '</a>';
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
	$arrangingPartyries = DBQuery::sql("SELECT event_id, partyries_id, comment FROM partyries_arrange
							WHERE event_id = '$event_id'");	

	if(count($arrangingPartyries) > 0)
	{
		echo '<div class="col-sm-6">';
		for($i = 0; $i < count($arrangingPartyries); ++$i)
		{
			$partyrie_id = $arrangingPartyries[$i]['partyries_id'];
			$partyrie = DBQuery::sql("SELECT id, name FROM partyries
								WHERE id = '$partyrie_id'");
			echo '<div class="white-box">';
			echo '<h4>';
			echo $partyrie[0]['name'];
			echo '</h4>';
			echo '<p>';
			echo $arrangingPartyries[$i]['comment'];
			echo '</p>';
			echo '</div>';
		}
		echo '</div>';
	}
}

function loadWorkingPartyries()
{
	$event_id = $_GET['id'];
	$workingPartyries = DBQuery::sql("SELECT event_id, partyries_id, comment FROM partyries_work
							WHERE event_id = '$event_id'");	

	if(count($workingPartyries) > 0)
	{
		echo '<div class="col-sm-6">';
		for($i = 0; $i < count($workingPartyries); ++$i)
		{
			$partyrie_id = $workingPartyries[$i]['partyries_id'];
			$partyrie = DBQuery::sql("SELECT id, name FROM partyries
								WHERE id = '$partyrie_id'");
			echo '<div class="white-box">';
			echo '<h4>';
			echo $partyrie[0]['name'];
			echo '</h4>';
			echo '<p>';
			echo $workingPartyries[$i]['comment'];
			echo '</p>';
			echo '</div>';
		}
		echo '</div>';
	}
}

function loadWorkSlots()
{
	if(isset($_GET['id']))
	{
		echo '<div class="col-sm-6">
					<div class="white-box">
						<div class="list-group">';
		$event_id = $_GET['id'];
		$user_id = $_SESSION['user_id'];
		$slots = DBQuery::sql("SELECT id, points, event_id, start_time, end_time, group_id, wage FROM work_slot 
							WHERE event_id = '$event_id'");

		$bookedSlots = DBQuery::sql("SELECT work_slot_id, user_id FROM user_work 
							WHERE work_slot_id IN
								(SELECT id FROM work_slot 
								WHERE event_id = '$event_id')
							AND user_id = '$user_id'");

		$groups = DBQuery::sql("SELECT id, name FROM work_group 
								WHERE id IN 
									(SELECT group_id FROM work_slot 
									WHERE event_id = '$event_id'
									AND id IN
										(SELECT work_slot_id FROM user_work))");


		if(count($groups) > 0)
		{
			echo '<h3>Passen</h3>';

			for($i = 0; $i < count($groups); ++$i)
			{
				echo '<p><strong>'.$groups[$i]['name'].'</strong></p>';
				for($j = 0; $j < count($slots); ++$j)
				{
					$work_slot_id = $slots[$j]['id'];
					$availableSlot = DBQuery::sql("SELECT id FROM work_slot 
												WHERE id NOT IN
													(SELECT work_slot_id FROM user_work)
												AND id = '$work_slot_id'");
					$slotStart = new DateTime($slots[$j]['start_time']);
					$slotEnd = new DateTime($slots[$j]['end_time']);
					$start = $slotStart->format('H:i -');
					$end = $slotEnd->format(' H:i');
					if($slots[$j]['group_id'] == $groups[$i]['id'])
					{
						$bookedSlot = DBQuery::sql("SELECT work_slot_id, user_id FROM user_work 
								WHERE work_slot_id IN
									(SELECT id FROM work_slot 
									WHERE event_id = '$event_id')
								AND work_slot_id = '$work_slot_id'");

						if(count($bookedSlot) > 0)
						{
							echo '<li class="list-group-item">';
							echo $start.$end;
							echo '<a href="?page=userProfile&id='.$bookedSlot[0]['user_id'].'" class="work-slot-user black-link"> 
								'.loadAvatarFromUser($bookedSlot[0]['user_id'], 20).loadNameFromUser($bookedSlot[0]['user_id']).'</a>';
							echo " (".$slots[$j]['points'].' poäng)';
							echo " (".$slots[$j]['wage'].' kr/h)';
							echo '</li>';
						}
					}
				}
			}
		}
		echo '</div>
			</div> <!-- .white-box -->
		</div>';
	}
}

function loadComments()
{
	$da_note_event_id = $_GET['id'];
	$da_note = DBQuery::sql("SELECT id FROM da_note
							WHERE event_id = '$da_note_event_id'");

	$da_note_id = $da_note[0]['id'];

	$DAComments = DBQuery::sql("SELECT id, da_note_id, comment, date_written, user_id FROM da_note_comments 
							WHERE da_note_id = '$da_note_id'");

	if(count($DAComments) > 0)
	{
		echo '<div class="col-sm-7">
						<div class="white-box">';
		echo '<h3>Kommentarer ('.count($DAComments).')</h3>';
	

		for($i = 0; $i < count($DAComments); ++$i)
		{
			$user_id = $DAComments[$i]['user_id'];
			$comment_id = $DAComments[$i]['id'];
			$my_user_id = $_SESSION['user_id'];

			$myComment = DBQuery::sql("SELECT id FROM da_note_comments 
							WHERE id = '$comment_id'
							AND user_id = '$my_user_id'");

			$commenter = DBQuery::sql("SELECT name, last_name FROM user 
							WHERE id = '$user_id' AND id IN
							(SELECT user_id FROM da_note_comments WHERE id = '$comment_id')");
			echo '<div class="comment">';
			echo '<img src="'.loadCommentAvatar($DAComments[$i]['id']).'" width="64" height="64" class="img-circle">';
			echo '<p><a href="?page=userProfile&id='.$DAComments[$i]['id'].'">'.$commenter[0]['name'].' '.$commenter[0]['last_name'].'</a> ';
			echo '<span class="time">- '.$DAComments[$i]['date_written'].'</span><br />';
			echo nl2br($DAComments[$i]['comment']);
			echo '</p>';
			if(checkAdminAccess() <= 1 || count($myComment) > 0)
					echo '<a href=?page=removeDANoteComment&da_note_id='.$da_note_event_id.'&comment_id='.$DAComments[$i]['id'].
							' class="list-group-item-text-book"><span class="fa fa-remove fa-fw fa-lg"></span></a>';
			echo '</div>';
		}
		echo '			</div> <!-- .white-box -->
					</div> <!-- .col-sm-7 -->';
	}
}

?>