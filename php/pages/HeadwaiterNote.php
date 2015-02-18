<?php

function loadEventName()
{
	$event_id = $_GET['id'];
	
	$eventName = DBQuery::sql("SELECT name FROM event
							WHERE id = '$event_id'");
	echo $eventName[0]['name'];
}

function loadHeadwaiterStats()
{
	$event_id = $_GET['id'];

	$HeadwaiterNotes = DBQuery::sql("SELECT headwaiter_note.event_id, headwaiter_note.n_of_sitting, 
		headwaiter_note.n_of_waiting_organizers, headwaiter_note.n_of_waiting_stair, event.name FROM headwaiter_note 
							INNER JOIN event ON headwaiter_note.event_id = event.id WHERE event.id = '$event_id'");
	?>
	<tr>
		<td><?php echo $HeadwaiterNotes[0]['n_of_sitting']; ?></td>
		<td><?php echo $HeadwaiterNotes[0]['n_of_waiting_organizers']; ?></td>
		<td><?php echo $HeadwaiterNotes[0]['n_of_waiting_stair']; ?></td>
	</tr>
	<?php
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

	$headwaiter = DBQuery::sql("SELECT user_id FROM headwaiter_note 
						WHERE event_id = '$event_id'"); 
	$headwaiter_id = $headwaiter[0]['user_id'];

	$headwaiter_name = DBQuery::sql("SELECT name, last_name FROM user  
							WHERE id = '$headwaiter_id'");

	if(isset($headwaiter_name[0]['name'])) 
	{
		?>
			<a href=<?php echo '?page=userProfile&id='.$headwaiter_id; ?>>
		<?php
			echo $headwaiter_name[0]['name'].' '.$headwaiter_name[0]['last_name'];
		?>
			</a>
		<?php
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

?>