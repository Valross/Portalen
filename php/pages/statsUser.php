<?php

function loadStats()
{
	$user_id = $_SESSION['user_id'];
	$user = DBQuery::sql("SELECT name, last_name, id, number_of_sessions FROM user 
						WHERE id = '$user_id'
						ORDER BY id");
	echo '<p>Antal inlogg: '.$user[0]['number_of_sessions'].'</p>';
	echo '<p>Antal kommentarer på event: '.loadEventComments($user_id).'</p>';
	echo '<p>Antal kommentarer på DA-lappar: '.loadDANoteComments($user_id).'</p>';
}

function loadEventComments($user_id)
{
	$amountOfComments = DBQuery::sql("SELECT id FROM event_comments
									WHERE user_id = '$user_id'");
	return count($amountOfComments);
}

function loadDANoteComments($user_id)
{
	$amountOfComments = DBQuery::sql("SELECT id FROM da_note_comments
									WHERE user_id = '$user_id'");
	return count($amountOfComments);
}

?>