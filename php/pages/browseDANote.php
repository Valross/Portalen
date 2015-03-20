<?php

function loadDAAvatar($DA_id)
{
	$results = DBQuery::sql("SELECT avatar FROM user WHERE id = '$DA_id' AND avatar IS NOT NULL");
	if(count($results) == 0)
	{
		return 'img/avatars/no_face_small.png';
	}
	return 'img/avatars/'.$results[0]['avatar'];
}

function loadAllDANotes()
{
	$sort = '';
	if(isset($_GET['sort']))
		$sort = $_GET['sort'];

	$DANotes_sql = 'SELECT da_note.event_id, da_note.user_id, da_note.sales_total, da_note.sales_entry, da_note.sales_bar, da_note.cash, 
									da_note.n_of_people, da_note.sales_spenta, da_note.message, event.name, event.start_time FROM da_note 
							INNER JOIN event ON da_note.event_id = event.id ';

	if($sort == 'total')
		$DANotes_sql .= 'ORDER BY da_note.sales_total DESC';
	else if($sort == 'nOfPeople')
		$DANotes_sql .= 'ORDER BY da_note.n_of_people DESC';
	else if($sort == 'sales_bar')
		$DANotes_sql .= 'ORDER BY da_note.sales_bar DESC';
	else if($sort == 'sales_entry')
		$DANotes_sql .= 'ORDER BY da_note.sales_entry DESC';
	else if($sort == 'cash')
		$DANotes_sql .= 'ORDER BY da_note.cash DESC';
	else if($sort == 'sales_spenta')
		$DANotes_sql .= 'ORDER BY da_note.sales_spenta DESC';
	else
		$DANotes_sql .= 'ORDER BY event.start_time DESC';

	$DANotes = DBQuery::sql($DANotes_sql);

	if(count($DANotes) > 0 && checkAdminAccess())
	{
		for($i = 0; $i < count($DANotes); ++$i)
		{
			?>
			<tr>
				<td><?php echo $i+1;?></td>
				<td><a href=<?php echo '"?page=DANote&id='.$DANotes[$i]['event_id'].'"'; ?>>
				<?php echo $DANotes[$i]['name']; ?></a></td>
				<td><?php echo $DANotes[$i]['start_time']; ?></td>
				<td><?php echo $DANotes[$i]['sales_total']; ?></td>
				<td><?php echo $DANotes[$i]['sales_entry']; ?></td>
				<td><?php echo $DANotes[$i]['sales_bar']; ?></td>
				<td><?php echo $DANotes[$i]['cash']; ?></td>
				<td><?php echo $DANotes[$i]['n_of_people']; ?></td>
				<td><?php echo $DANotes[$i]['sales_spenta']; ?></td>
				<td><a href=<?php echo '?page=userProfile&id='.$DANotes[$i]['user_id']; ?>>
				<img src="<?php echo loadDAAvatar($DANotes[$i]['user_id']); ?>" width="25" height="25" class="img-circle"></a></td>
			</tr>
			<?php
		}
	}
}

?>