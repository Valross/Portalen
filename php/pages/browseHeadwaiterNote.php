<?php

function loadHeadwaiterAvatar($headwaiter_id)
{
	$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$headwaiter_id' AND avatar IS NOT NULL");
	if(count($results) == 0)
	{
		return 'img/avatars/no_face_small.png';
	}
	return 'img/avatars/'.$results[0]['avatar'];
}

function loadAllHeadwaiterNotes()
{
	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.user_id, headwaiter_note.n_of_sitting, event.name FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id 
							ORDER BY event.start_time DESC");

	if(count($HeadwaiterNotes) > 0 && checkAdminAccess())
	{
		for($i = 0; $i < count($HeadwaiterNotes); ++$i)
		{
			?>
			<tr>
				<td><?php echo $i+1;?></td>
				<td><a href=<?php echo '"?page=HeadwaiterNote&id='.$HeadwaiterNotes[$i]['event_id'].'"'; ?>>
				<?php echo $HeadwaiterNotes[$i]['name']; ?></a></td>
				<td><?php echo $HeadwaiterNotes[$i]['n_of_sitting']; ?></td>
				<td><a href=<?php echo '?page=userProfile&id='.$HeadwaiterNotes[$i]['user_id']; ?>>
				<img src="<?php echo loadHeadwaiterAvatar($HeadwaiterNotes[$i]['user_id']); ?>" width="25" height="25" class="img-circle"></a></td>
			</tr>
			<?php
		}
	}
}

?>