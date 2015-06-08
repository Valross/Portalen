<?php

if(isset($_POST['submitComment']))
{
	$comment = strip_tags($_POST['comment'], allowed_tags());
	$headwaiter_note_event_id = $_GET['id'];

	$headwaiter_note = DBQuery::sql("SELECT id FROM headwaiter_note
							WHERE event_id = '$headwaiter_note_event_id'");

	$headwaiter_note_id = $headwaiter_note[0]['id'];
	
	if($comment != '')
	{
		DBQuery::sql("INSERT INTO headwaiter_note_comments (user_id, headwaiter_note_id, comment)
						VALUES ('$_SESSION[user_id]', '$headwaiter_note_id', '$comment')");

		$headwaiter_note_comment = DBQuery::sql("SELECT id FROM headwaiter_note_comments 
						ORDER BY date_written DESC");

		$headwaiter_note_comment_id = $headwaiter_note_comment[0]['id'];

		$users = DBQuery::sql("SELECT id FROM user
							WHERE id IN
								(SELECT user_id FROM group_member
								WHERE group_id = 7 OR group_id = 1 OR group_id = 12)");

		for($i = 0; $i < count($users); ++$i)
		{
			if($users[$i]['id'] != $_SESSION['user_id'])
				notify($users[$i]['id'], 12, $headwaiter_note_comment_id);
		}
		?>
		<script>
			window.location = <?php echo '?page=headwaiterNote&id='.$headwaiter_note_event_id; ?>;
		</script>
		<?php
	}
}

if(isset($_POST['submit']) && checkAdminAccess() <= 3)
{
	$event_id = $_GET['id'];
	$user_id = $_SESSION['user_id'];
	$headwaiter_note = DBQuery::sql("SELECT id FROM headwaiter_note
								WHERE event_id = '$event_id'");

	$headwaiter_note_id = $headwaiter_note[0]['id'];
	$nOfSitting = strip_tags($_POST['n_of_sitting'], allowed_tags());
	$food = strip_tags($_POST['food'], allowed_tags());
	$invoiceDrinks = strip_tags($_POST['invoice_drinks'], allowed_tags());
	$nOfWaitingOrganizers = strip_tags($_POST['n_of_waiting_organizers'], allowed_tags());
	$nOfWaitingStair = strip_tags($_POST['n_of_waiting_stair'], allowed_tags());
	$toast = strip_tags($_POST['toast'], allowed_tags());
	$organizers = strip_tags($_POST['organizers'], allowed_tags());
	$stairStaff = strip_tags($_POST['stair_staff'], allowed_tags());
	$organizersStaff = strip_tags($_POST['organizers_staff'], allowed_tags());
	$swine = strip_tags($_POST['swine'], allowed_tags());
	$fixlist = strip_tags($_POST['fixlist'], allowed_tags());
	$message = strip_tags($_POST['message'], allowed_tags());

	if($nOfSitting != '' && $food != '' && $invoiceDrinks != '' && $nOfWaitingOrganizers != '' 
		&& $nOfWaitingStair != '' && $toast != '' && $organizers != '' && $stairStaff != '' && $organizersStaff != '' && $swine != '' && $fixlist != '' && $message != '')
	{
		DBQuery::sql("UPDATE headwaiter_note
			SET n_of_sitting = '$nOfSitting', food = '$food',
				invoice_drinks = '$invoiceDrinks', n_of_waiting_organizers = '$nOfWaitingOrganizers', n_of_waiting_stair = '$nOfWaitingStair',
				toast = '$toast', organizers = '$organizers',
				stair_staff = '$stairStaff', organizers_staff = '$organizersStaff',
				swine = '$swine', fixlist = '$fixlist', message = '$message'
			WHERE id = '$headwaiter_note_id'");

		?>
			<script>
				window.location = "?page=HeadwaiterNote&id=<?php echo $event_id; ?>";
			</script>
		<?php
	}
}

function loadEventName()
{
	$event_id = $_GET['id'];
	
	$eventName = DBQuery::sql("SELECT name, start_time FROM event
							WHERE id = '$event_id'");
	loadTitleForBrowser('Hovis-lapp - '.$eventName[0]['name']);

	echo '<a href=?page=event&id='.$event_id.'>';

	$eventStart = new DateTime($eventName[0]['start_time']);
	$start = $eventStart->format('D Y-m-d');
	echo $eventName[0]['name'].'</a> - '.$start;
}

function loadButtons()
{
	$event_id = $_GET['id'];
	$user_id = $_SESSION['user_id'];

	$headwaiter_note = DBQuery::sql("SELECT id FROM headwaiter_note
								WHERE event_id = '$event_id'");

	$headwaiter_note_id = $headwaiter_note[0]['id'];

	$my_note = DBQuery::sql("SELECT id, name, start_time FROM event 
							WHERE event_type_id != 5 AND id IN
								(SELECT event_id FROM work_slot
								WHERE group_id = 12 AND id IN
									(SELECT work_slot_id FROM user_work
									WHERE user_id = '$user_id'))"); 

	if(count($my_note) > 0 || checkAdminAccess() < 1)
		echo '<a href="?page=removeHeadwaiterNote&event_id='.$event_id.'&headwaiter_note_id='.$headwaiter_note_id.'" class="btn btn-page-header"
			onclick="return confirm(\'Är du säker på att du vill ta bort lappen? Det går inte att ångra sig.\')">
			<span class="fa fa-remove fa-fw fa-lg"></span>Ta bort</a></td>';
	if((count($my_note) > 0 || checkAdminAccess() < 1) && !isset($_GET['edit']))
		echo '<a href="?page=HeadwaiterNote&id='.$event_id.'&edit" class="btn btn-page-header"><span class="fa fa-wrench fa-fw fa-lg"></span>Redigera</a>';
}


function loadHeadwaiterStats()
{
	$event_id = $_GET['id'];

	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.n_of_sitting, 
		headwaiter_note.n_of_waiting_organizers, headwaiter_note.n_of_waiting_stair, event.name FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id WHERE event.id = '$event_id'");

	echo '<tr>';
	if(!isset($_GET['edit']))
	{
		echo '<td>'.$HeadwaiterNotes[0]['n_of_sitting'].'</td>';
		echo '<td>'.$HeadwaiterNotes[0]['n_of_waiting_organizers'].'</td>';
		echo '<td>'.$HeadwaiterNotes[0]['n_of_waiting_stair'].'</td>';
	}
	else
	{
		echo '<td><input type="number" name="n_of_sitting" id="n_of_sitting" min="0" max="500"
			value="'.$HeadwaiterNotes[0]['n_of_sitting'].'" form="headwaiter_note_form"></td>';
		echo '<td><input type="number" name="n_of_waiting_organizers" id="n_of_waiting_organizers" min="0" max="20"
			value="'.$HeadwaiterNotes[0]['n_of_waiting_organizers'].'" form="headwaiter_note_form"></td>';
		echo '<td><input type="number" name="n_of_waiting_stair" id="n_of_waiting_stair" min="0" max="15"
			value="'.$HeadwaiterNotes[0]['n_of_waiting_stair'].'" form="headwaiter_note_form"></td>';
	}
	echo '</tr>';
}

function loadFood()
{
	$event_id = $_GET['id'];

	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.food FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id WHERE event.id = '$event_id'");

	if(!isset($_GET['edit']))
		echo $HeadwaiterNotes[0]['food'];
	else
		echo '<textarea rows="5" cols="50" name="food" id="food" maxlength="400"
			class="bottom-border">'.$HeadwaiterNotes[0]['food'].'</textarea>';
}

function loadInvoiceDrinks()
{
	$event_id = $_GET['id'];

	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.invoice_drinks FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id WHERE event.id = '$event_id'");

	if(!isset($_GET['edit']))
		echo $HeadwaiterNotes[0]['invoice_drinks'];
	else
		echo '<textarea rows="5" cols="50" name="invoice_drinks" id="invoice_drinks" maxlength="400"
			class="bottom-border">'.$HeadwaiterNotes[0]['invoice_drinks'].'</textarea>';
}

function loadToast()
{
	$event_id = $_GET['id'];

	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.toast FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id WHERE event.id = '$event_id'");

	if(!isset($_GET['edit']))
		echo $HeadwaiterNotes[0]['toast'];
	else
		echo '<textarea rows="4" cols="50" name="toast" id="toast" maxlength="400"
			class="bottom-border">'.$HeadwaiterNotes[0]['toast'].'</textarea>';
}

function loadOrganizers()
{
	$event_id = $_GET['id'];

	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.organizers FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id WHERE event.id = '$event_id'");

	if(!isset($_GET['edit']))
		echo $HeadwaiterNotes[0]['organizers'];
	else
		echo '<textarea rows="4" cols="50" name="organizers" id="organizers" maxlength="400"
			class="bottom-border">'.$HeadwaiterNotes[0]['organizers'].'</textarea>';
}

function loadStairStaff()
{
	$event_id = $_GET['id'];

	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.stair_staff FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id WHERE event.id = '$event_id'");

	if(!isset($_GET['edit']))
		echo $HeadwaiterNotes[0]['stair_staff'];
	else
		echo '<textarea rows="4" cols="50" name="stair_staff" id="stair_staff" maxlength="400"
			class="bottom-border">'.$HeadwaiterNotes[0]['stair_staff'].'</textarea>';
}

function loadOrganizersStaff()
{
	$event_id = $_GET['id'];

	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.organizers_staff FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id WHERE event.id = '$event_id'");

	if(!isset($_GET['edit']))
		echo $HeadwaiterNotes[0]['organizers_staff'];
	else
		echo '<textarea rows="4" cols="50" name="organizers_staff" id="organizers_staff" maxlength="400"
			class="bottom-border">'.$HeadwaiterNotes[0]['organizers_staff'].'</textarea>';
}

function loadSwine()
{
	$event_id = $_GET['id'];

	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.swine FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id WHERE event.id = '$event_id'");

	if(!isset($_GET['edit']))
		echo $HeadwaiterNotes[0]['swine'];
	else
		echo '<textarea rows="5" cols="50" name="swine" id="swine" maxlength="400"
			class="bottom-border">'.$HeadwaiterNotes[0]['swine'].'</textarea>';
}

function loadFixlist()
{
	$event_id = $_GET['id'];

	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.fixlist FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id WHERE event.id = '$event_id'");

	if(!isset($_GET['edit']))
		echo $HeadwaiterNotes[0]['fixlist'];
	else
		echo '<textarea rows="6" cols="50" name="fixlist" id="fixlist" maxlength="4000"
			class="bottom-border">'.$HeadwaiterNotes[0]['fixlist'].'</textarea>';
}

function loadMessage()
{
	$event_id = $_GET['id'];

	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.message FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id WHERE event.id = '$event_id'");

	if(!isset($_GET['edit']))
		echo $HeadwaiterNotes[0]['message'];
	else
	{
		echo '<textarea rows="12" cols="50" name="message" id="message" maxlength="6000"
			class="bottom-border">'.$HeadwaiterNotes[0]['message'].'</textarea>';
		echo '<input type="submit" name="submit" value="Uppdatera">';
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

function loadHeadwaiterName()
{
	$event_id = $_GET['id'];

	$headwaiter = DBQuery::sql("SELECT user_id, date_written FROM headwaiter_note 
						WHERE event_id = '$event_id'"); 
	
	$headwaiter_id = $headwaiter[0]['user_id'];
	$headwaiter_note_date = $headwaiter[0]['date_written'];
	$headwaiter_name = DBQuery::sql("SELECT name, last_name FROM user  
							WHERE id = '$headwaiter_id'");

	if(isset($headwaiter_name[0]['name'])) 
	{
		echo '<a href=?page=userProfile&id='.$headwaiter_id.'>';
		echo $headwaiter_name[0]['name'].' '.$headwaiter_name[0]['last_name'];
		echo '</a>';
		echo ' - '.$headwaiter_note_date;
	}
	else
		echo 'John Doe';
}

function loadHeadwaiterAvatar()
{
	$event_id = $_GET['id'];

	$headwaiter = DBQuery::sql("SELECT user_id FROM headwaiter_note 
						WHERE event_id = '$event_id'"); 
	$headwaiter_id = $headwaiter[0]['user_id'];

	if(isset($headwaiter))
	{
		$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$headwaiter_id' AND avatar IS NOT NULL");
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

	$user = DBQuery::sql("SELECT user_id FROM headwaiter_note_comments 
						WHERE headwaiter_note_id IN
							(SELECT id FROM headwaiter_note 
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
		
		$headwaiter_note_event_id = $_GET['id'];
		$headwaiter_note = DBQuery::sql("SELECT id FROM headwaiter_note
								WHERE event_id = '$headwaiter_note_event_id'");

		$headwaiter_note_id = $headwaiter_note[0]['id'];

		$headwaiter_comments = DBQuery::sql("SELECT id, headwaiter_note_id, comment, date_written, user_id FROM headwaiter_note_comments 
								WHERE headwaiter_note_id = '$headwaiter_note_id'");

		if(count($headwaiter_comments) > 0)
		{
			echo '<div class="col-sm-7">
							<div class="white-box">';
			echo '<h3>Kommentarer ('.count($headwaiter_comments).')</h3>';
		

			for($i = 0; $i < count($headwaiter_comments); ++$i)
			{
				$user_id = $headwaiter_comments[$i]['user_id'];
				$comment_id = $headwaiter_comments[$i]['id'];
				$my_user_id = $_SESSION['user_id'];

				$myComment = DBQuery::sql("SELECT id FROM headwaiter_note_comments 
								WHERE id = '$comment_id'
								AND user_id = '$my_user_id'");

				$commenter = DBQuery::sql("SELECT name, last_name FROM user 
								WHERE id = '$user_id' AND id IN
								(SELECT user_id FROM headwaiter_note_comments WHERE id = '$comment_id')");
				echo '<div class="comment">';
				echo '<img src="'.loadCommentAvatar($headwaiter_comments[$i]['id']).'" width="64" height="64" class="img-circle">';
				echo '<p><a href="?page=userProfile&id='.$headwaiter_comments[$i]['id'].'">'.$commenter[0]['name'].' '.$commenter[0]['last_name'].'</a> ';
				echo '<span class="time">- '.$headwaiter_comments[$i]['date_written'].'</span><br />';
				echo nl2br($headwaiter_comments[$i]['comment']);
				echo '</p>';
				if(checkAdminAccess() <= 1 || count($myComment) > 0)
						echo '<a href=?page=removeHeadwaiterNoteComment&headwaiter_note_id='.$headwaiter_note_event_id.'&comment_id='.$headwaiter_comments[$i]['id'].
								' class="list-group-item-text-book"><span class="fa fa-remove fa-fw fa-lg"></span></a>';
				echo '</div>';
			}
			echo '			</div> <!-- .white-box -->
						</div> <!-- .col-sm-7 -->';
		}
		echo '<form action="" method="post">
				<div class="col-sm-5">
					<div class="white-box">
						<h3>Skriv kommentar</h3>
						<label for="comment">Kommentar</label>
						<textarea rows="6" cols="50" placeholder="Fan glöm inte att kolla om det redan finns öppnade vinflaskor!" 
							name="comment" id="comment" class="bottom-border"></textarea>

						<input type="submit" name="submitComment" value="Skicka kommentar">
					</div> <!-- .white-box -->
				</div>
			</form>';
	echo '</div> <!-- .row -->';
	}
}

?>