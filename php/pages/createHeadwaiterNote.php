<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('Skapa hovis-lapp');

if(isset($_POST['submit']))
{
	$event = strip_tags($_POST['event'], allowed_tags());
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

	
	if($event != 'typeno' && $nOfSitting != '' && $food != '' && $invoiceDrinks != '' && $nOfWaitingOrganizers != '' 
		&& $nOfWaitingStair != '' && $toast != '' && $organizers != '' && $stairStaff != '' && $organizersStaff != '' && $swine != '' && $fixlist != '' && $message != '')
	{
		DBQuery::sql("INSERT INTO headwaiter_note (id, user_id, event_id, n_of_sitting, food, invoice_drinks, 
			n_of_waiting_organizers, n_of_waiting_stair, toast, organizers, stair_staff, organizers_staff, swine, fixlist, message)
						VALUES ('', '$_SESSION[user_id]', '$event', '$nOfSitting', '$food', '$invoiceDrinks', '$nOfWaitingOrganizers', '$nOfWaitingStair', 
							'$toast', '$organizers', '$stairStaff', '$organizersStaff', '$swine', '$fixlist', '$message')");

		$headwaiter_note = DBQuery::sql("SELECT id FROM headwaiter_note 
						ORDER BY date_written DESC");

		$headwaiter_note_id = $headwaiter_note[0]['id'];

		$users = DBQuery::sql("SELECT id FROM user
							WHERE id IN
								(SELECT user_id FROM group_member
								WHERE group_id = 7 OR group_id = 1 OR group_id = 12)");

		for($i = 0; $i < count($users); ++$i)
		{
			if($users[$i]['id'] != $_SESSION['user_id'])
				notify($users[$i]['id'], 4, $headwaiter_note_id);
		}
		?>
		<script>
			window.location = "?page=browseHeadwaiterNote";
		</script>
		<?php
	}
	
}

function loadMyHeadWaiterEvents()
{
	$user_id = $_SESSION['user_id'];
	$events = DBQuery::sql("SELECT id, name, start_time, event_type_id FROM event 
							WHERE event_type_id != 5 AND id IN
								(SELECT event_id FROM work_slot
								WHERE group_id = 12 AND id IN
									(SELECT work_slot_id FROM user_work
									WHERE user_id = '$user_id'))
							AND id NOT IN
								(SELECT event_id FROM headwaiter_note)
							ORDER BY start_time DESC"); 

	for($i = 0; $i < count($events); ++$i)
	{
		echo '<option value="'.$events[$i]['id'].'">'.$events[$i]['name'].' - '.$events[$i]['start_time'].'</option>';
	}
}

?>