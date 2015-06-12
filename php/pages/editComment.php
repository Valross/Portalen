<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('Redigera nyhet');

if(isset($_POST['submitComment']))
{
	$comment_id = $_GET['comment_id'];
	$comment_type = $_GET['comment_type'];
	$comment = strip_tags($_POST['comment'], allowed_tags());

	if($comment_type == 'da_note')
	{
		DBQuery::sql("UPDATE da_note_comments
			  SET comment = '$comment', last_edit = '$date'
			  WHERE id = '$comment_id'");
		$event_id = $_GET['event_id'];
		?>
		<script>
			window.location = "?page=DANote&id=<?php echo $event_id; ?>";
		</script>
		<?php
	}
	else if($comment_type == 'headwaiter_note')
	{
		DBQuery::sql("UPDATE headwaiter_note_comments
			  SET comment = '$comment', last_edit = '$date'
			  WHERE id = '$comment_id'");
		$event_id = $_GET['event_id'];
		?>
		<script>
			window.location = "?page=HeadwaiterNote&id=<?php echo $event_id; ?>";
		</script>
		<?php
	}
	else if($comment_type == 'event')
	{
		DBQuery::sql("UPDATE event_comments
			  SET comment = '$comment', last_edit = '$date'
			  WHERE id = '$comment_id'");
		$event_id = $_GET['event_id'];
		?>
		<script>
			window.location = "?page=event&id=<?php echo $event_id; ?>";
		</script>
		<?php
	}
}

function loadFormContent()
{
	$comment_id = $_GET['comment_id'];
	$comment_type = $_GET['comment_type'];

	if($comment_type == 'da_note')
	{
		$comment = DBQuery::sql("SELECT id, comment, user_id FROM da_note_comments 
						WHERE id = '$comment_id'");

		if($comment[0]['user_id'] == $_SESSION['user_id'] || checkAdminAccess() < 1)
			loadCommentForm($comment[0]['comment']);
	}
	else if($comment_type == 'headwaiter_note')
	{
		$comment = DBQuery::sql("SELECT id, comment, user_id FROM headwaiter_note_comments 
						WHERE id = '$comment_id'");

		if($comment[0]['user_id'] == $_SESSION['user_id'] || checkAdminAccess() < 1)
			loadCommentForm($comment[0]['comment']);
	}
	else if($comment_type == 'event')
	{
		$comment = DBQuery::sql("SELECT id, comment, user_id FROM event_comments 
						WHERE id = '$comment_id'");

		if($comment[0]['user_id'] == $_SESSION['user_id'] || checkAdminAccess() < 1)
			loadCommentForm($comment[0]['comment']);
	}
	else
	{
		?>
		<script>
			window.location = "?page=start";
			alert("Sluta försöka hacka sidan!")
		</script>
		<?php
	}	
}

function loadCommentForm($comment)
{
	echo '<h3>Skriv kommentar</h3>
				<label for="comment">Kommentar</label>
				<textarea rows="6" cols="50" maxlength="1000"
					name="comment" id="comment" class="bottom-border">'.$comment.'</textarea>

				<input type="submit" name="submitComment" value="Uppdatera kommentar">';
}

?>