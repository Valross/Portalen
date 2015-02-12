<?php

function loadAllDANotes()
{
	$DANotes = DBQuery::sql("SELECT da_note.event_id, da_note.sales_entry, da_note.sales_bar, da_note.cash, 
									da_note.n_of_people, da_note.sales_spenta, da_note.message, event.name FROM da_note 
							INNER JOIN event ON da_note.event_id = event.id 
							ORDER BY event.start_time");

	if(count($DANotes) > 0)
	{
		for($i = 0; $i < count($DANotes); ++$i)
		{
			?>
			<tr>
				<td><?php echo $i+1;?></td>
				<td><a href=<?php echo '"?page=DANote&id='.$DANotes[$i]['event_id'].'"'; ?>>
				<?php echo $DANotes[$i]['name']; ?></a></td>
				<td><?php echo $DANotes[$i]['sales_entry']; ?></td>
				<td><?php echo $DANotes[$i]['sales_bar']; ?></td>
				<td><?php echo $DANotes[$i]['cash']; ?></td>
				<td><?php echo $DANotes[$i]['n_of_people']; ?></td>
				<td><?php echo $DANotes[$i]['sales_spenta']; ?></td>
			</tr>
			<?php
		}
	}
}

?>