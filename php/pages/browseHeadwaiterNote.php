<?php

function loadHeadwaiterAvatar()
{
	$headwaiter = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.user_id FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id ");

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

function loadAllHeadwaiterNotes()
{
	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.user_id, headwaiter_note.n_of_sitting, event.name FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id 
							ORDER BY event.start_time DESC");

	$headwaiter_id = $HeadwaiterNotes[0]['user_id'];

	if(count($HeadwaiterNotes) > 0)
	{
		for($i = 0; $i < count($HeadwaiterNotes); ++$i)
		{
			?>
			<tr>
				<td><?php echo $i+1;?></td>
				<td><a href=<?php echo '"?page=HeadwaiterNote&id='.$HeadwaiterNotes[$i]['event_id'].'"'; ?>>
				<?php echo $HeadwaiterNotes[$i]['name']; ?></a></td>
				<td><?php echo $HeadwaiterNotes[$i]['n_of_sitting']; ?></td>
				<td><a href=<?php echo '?page=userProfile&id='.$headwaiter_id; ?>>
				<img src="<?php echo loadHeadwaiterAvatar(); ?>" width="25" height="25" class="img-circle"></a></td>
			</tr>
			<?php
		}
	}
}

?>