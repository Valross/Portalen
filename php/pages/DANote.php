<?php

if(isset($_POST['submitComment']))
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

if(isset($_POST['submit']) && checkAdminAccess() <= 2)
{
	$event_id = $_GET['id'];
	$user_id = $_SESSION['user_id'];
	$da_note = DBQuery::sql("SELECT id FROM da_note
								WHERE event_id = '$event_id'");

	$da_note_id = $da_note[0]['id'];
	$salesTotal = strip_tags($_POST['salesTotal']);
	$salesEntry = strip_tags($_POST['salesEntry']);
	$salesBar = strip_tags($_POST['salesBar']);
	$cash = strip_tags($_POST['cash']);
	$nOfPeople = strip_tags($_POST['nOfPeople']);
	$salesSpenta = strip_tags($_POST['salesSpenta']);
	$salesShots = strip_tags($_POST['salesShots']);
	$fixlist = strip_tags($_POST['fixlist'], allowed_tags());
	$message = strip_tags($_POST['message'], allowed_tags());

	if($salesTotal != '' && $salesEntry != '' && $salesBar != '' && $cash != '' && $nOfPeople != '' && $salesSpenta != '' && $salesShots != '' && $fixlist != '' && $message != '')
	{
		DBQuery::sql("UPDATE da_note
			SET sales_total = '$salesTotal', sales_entry = '$salesEntry',
				sales_bar = '$salesBar', cash = '$cash', n_of_people = '$nOfPeople',
				sales_spenta = '$salesSpenta', sales_shots = '$salesShots',
				fixlist = '$fixlist', message = '$message'
			WHERE id = '$da_note_id'");
	}	
	if($salesEntry != '' && $salesBar != '' && $cash != '' && $nOfPeople != '' && $salesSpenta != '' && $message != '')
	{
		?>
		<script>
			window.location = "?page=DANote&id=<?php echo $event_id; ?>";
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

function loadButtons()
{
	$event_id = $_GET['id'];
	$user_id = $_SESSION['user_id'];

	$da_note = DBQuery::sql("SELECT id FROM da_note
								WHERE event_id = '$event_id'");

	$da_note_id = $da_note[0]['id'];

	$my_note = DBQuery::sql("SELECT id, name, start_time FROM event 
							WHERE event_type_id != 5 AND id IN
								(SELECT event_id FROM work_slot
								WHERE group_id = 7 AND id IN
									(SELECT work_slot_id FROM user_work
									WHERE user_id = '$user_id'))"); 

	if(count($my_note) > 0 || checkAdminAccess() < 1)
		echo '<a href="?page=removeDANote&event_id='.$event_id.'&da_note_id='.$da_note_id.'" class="btn btn-page-header"
			onclick="return confirm(\'Är du säker på att du vill ta bort lappen? Det går inte att ångra sig.\')">
			<span class="fa fa-remove fa-fw fa-lg"></span>Ta bort</a></td>';
	if(count($my_note) > 0 && !isset($_GET['edit']))
		echo '<a href="?page=DANote&id='.$event_id.'&edit" class="btn btn-page-header"><span class="fa fa-wrench fa-fw fa-lg"></span>Redigera</a>';
}

function loadDAStats()
{
	$event_id = $_GET['id'];

	$DANotes = DBQuery::sql("SELECT da_note.event_id, da_note.sales_total, da_note.sales_entry, da_note.sales_bar, da_note.cash, 
									da_note.n_of_people, da_note.sales_spenta, da_note.sales_shots, da_note.message, event.name FROM da_note 
							INNER JOIN event ON da_note.event_id = event.id WHERE event.id = '$event_id'");

	if(!isset($_GET['edit']))
	{
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
	else
	{
		echo '<tr>';
			echo '<td><input type="text" name="salesTotal" id="salesTotal" value="'.$DANotes[0]['sales_total'].'" form="da_note_form"></td>';
			echo '<td><input type="text" name="salesEntry" id="salesEntry" value="'.$DANotes[0]['sales_entry'].'" form="da_note_form"></td>';
			echo '<td><input type="text" name="salesBar" id="salesBar" value="'.$DANotes[0]['sales_bar'].'" form="da_note_form"></td>';
			echo '<td><input type="text" name="cash" id="cash" value="'.$DANotes[0]['cash'].'" form="da_note_form"></td>';
			echo '<td><input type="text" name="nOfPeople" id="nOfPeople" value="'.$DANotes[0]['n_of_people'].'" form="da_note_form"></td>';
			echo '<td><input type="text" name="salesSpenta" id="salesSpenta" value="'.$DANotes[0]['sales_spenta'].'" form="da_note_form"></td>';
			echo '<td><input type="text" name="salesShots" id="salesShots" value="'.$DANotes[0]['sales_shots'].'" form="da_note_form"></td>';
		echo '</tr>';
	}
}

function loadDAFixlist()
{
	$event_id = $_GET['id'];

	$DANotes = DBQuery::sql("SELECT da_note.event_id, da_note.fixlist FROM da_note 
							INNER JOIN event ON da_note.event_id = event.id WHERE event.id = '$event_id'");

	if(!isset($_GET['edit']))
		echo $DANotes[0]['fixlist'];
	else
		echo '<textarea rows="8" cols="50" name="fixlist" id="fixlist" class="bottom-border">'.$DANotes[0]['fixlist'].'</textarea>';
}

function loadDAMessage()
{
	$event_id = $_GET['id'];

	$DANotes = DBQuery::sql("SELECT da_note.event_id, da_note.message FROM da_note 
							INNER JOIN event ON da_note.event_id = event.id WHERE event.id = '$event_id'");

	if(!isset($_GET['edit']))
		echo $DANotes[0]['message'];
	else
	{
		echo '<textarea rows="12" cols="50" name="message" id="message" class="bottom-border">'.$DANotes[0]['message'].'</textarea>';
		echo '<input type="submit" name="submit" value="Uppdatera">';
	}
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

	if(count($arrangingPartyries) > 0 && !isset($_GET['edit']))
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

	if(count($workingPartyries) > 0 && !isset($_GET['edit']))
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
	if(isset($_GET['id']) && !isset($_GET['edit']))
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
	if(!isset($_GET['edit']))
	{
		echo '<div class="row">
				<div class="col-sm-12">
					<div class="page-header">
						<h1><span class="fa fa-comments fa-fw fa-lg"></span> Kommentarer</h1>
					</div>
				</div>
			</div> <!-- .row -->';

		echo '<div class="row">';
		echo '<form action="" method="post">
				<div class="col-sm-5">
					<div class="white-box">
						<h3>Skriv kommentar</h3>
						<label for="comment">Kommentar</label>
						<textarea rows="6" cols="50" placeholder="Fan panten är ju inte alls snygg!" name="comment" id="comment" class="bottom-border"></textarea>

						<input type="submit" name="submitComment" value="Skicka kommentar">
					</div> <!-- .white-box -->
				</div>
			</form>';

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
		echo '</div> <!-- .row -->';
	}
}

?>