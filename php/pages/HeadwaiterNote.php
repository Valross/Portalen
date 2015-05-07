<?php

if(isset($_POST['submit']))
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
	echo ' - <a href=?page=browseHeadwaiterNote><span class="fa fa-female fa-fw fa-lg"></span>Hovis-lappar</a>';
}

function loadHeadwaiterStats()
{
	$event_id = $_GET['id'];

	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.n_of_sitting, 
		headwaiter_note.n_of_waiting_organizers, headwaiter_note.n_of_waiting_stair, event.name FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id WHERE event.id = '$event_id'");

	echo '<tr>';
		echo '<td>'.$HeadwaiterNotes[0]['n_of_sitting'].'</td>';
		echo '<td>'.$HeadwaiterNotes[0]['n_of_waiting_organizers'].'</td>';
		echo '<td>'.$HeadwaiterNotes[0]['n_of_waiting_stair'].'</td>';
	echo '</tr>';
}

function loadFood()
{
	$event_id = $_GET['id'];

	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.food FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id WHERE event.id = '$event_id'");

	echo $HeadwaiterNotes[0]['food'];
}

function loadInvoiceDrinks()
{
	$event_id = $_GET['id'];

	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.invoice_drinks FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id WHERE event.id = '$event_id'");

	echo $HeadwaiterNotes[0]['invoice_drinks'];
}

function loadToast()
{
	$event_id = $_GET['id'];

	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.toast FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id WHERE event.id = '$event_id'");

	echo $HeadwaiterNotes[0]['toast'];
}

function loadOrganizers()
{
	$event_id = $_GET['id'];

	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.organizers FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id WHERE event.id = '$event_id'");

	echo $HeadwaiterNotes[0]['organizers'];
}

function loadStairStaff()
{
	$event_id = $_GET['id'];

	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.stair_staff FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id WHERE event.id = '$event_id'");

	echo $HeadwaiterNotes[0]['stair_staff'];
}

function loadOrganizersStaff()
{
	$event_id = $_GET['id'];

	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.organizers_staff FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id WHERE event.id = '$event_id'");

	echo $HeadwaiterNotes[0]['organizers_staff'];
}

function loadSwine()
{
	$event_id = $_GET['id'];

	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.swine FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id WHERE event.id = '$event_id'");

	echo $HeadwaiterNotes[0]['swine'];
}

function loadMessage()
{
	$event_id = $_GET['id'];

	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.message FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id WHERE event.id = '$event_id'");

	echo $HeadwaiterNotes[0]['message'];
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
}

?>