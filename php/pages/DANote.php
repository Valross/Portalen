<?php

function loadEventName()
{
	$event_id = $_GET['id'];
	
	$eventName = DBQuery::sql("SELECT name FROM event
							WHERE id = '$event_id'");
	echo $eventName[0]['name'];
}

function loadDAStats()
{
	$DANotes = DBQuery::sql("SELECT da_note.event_id, da_note.sales_entry, da_note.sales_bar, da_note.cash, 
									da_note.n_of_people, da_note.sales_spenta, da_note.message, event.name FROM da_note 
							INNER JOIN event ON da_note.event_id = event.id 
							ORDER BY event.start_time");

	for($i = 0; $i < count($DANotes); ++$i)
	{
		?>
		<tr>
			<td><?php echo $DANotes[$i]['sales_entry']; ?></td>
			<td><?php echo $DANotes[$i]['sales_bar']; ?></td>
			<td><?php echo $DANotes[$i]['cash']; ?></td>
			<td><?php echo $DANotes[$i]['n_of_people']; ?></td>
			<td><?php echo $DANotes[$i]['sales_spenta']; ?></td>
		</tr>
		<?php
	}
}

function loadDAMessage()
{
	$DANotes = DBQuery::sql("SELECT da_note.event_id, da_note.message FROM da_note 
							INNER JOIN event ON da_note.event_id = event.id 
							ORDER BY event.start_time");

	echo $DANotes[0]['message'];
}

function loadDAName()
{
	$event_id = $_GET['id'];

	$DA = DBQuery::sql("SELECT user_id FROM da_note 
						WHERE event_id = '$event_id'"); 
	$DA_id = $DA[0]['user_id'];

	$DA_name = DBQuery::sql("SELECT name, last_name FROM user  
							WHERE id = '$DA_id'");

	if(isset($DA_name[0]['name'])) 
	{
		?>
			<a href=<?php echo '?page=userProfile&id='.$DA_id; ?>>
		<?php
			echo $DA_name[0]['name'].' '.$DA_name[0]['last_name'];
		?>
			</a>
		<?php
	}
	else
		echo 'John Doe';
}

function loadDAAvatar()
{
	$event_id = $_GET['id'];

	$DA = DBQuery::sql("SELECT user_id FROM da_note 
						WHERE event_id = '$event_id'"); 
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

?>