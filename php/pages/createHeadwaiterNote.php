<?php
include_once('php/DBQuery.php');

if(isset($_POST['submit']))
{
	$event = $_POST['event'];
	$nOfSitting = $_POST['n_of_sitting'];
	$food = $_POST['food'];
	$invoiceDrinks = $_POST['invoice_drinks'];
	$nOfWaitingOrganizers = $_POST['n_of_waiting_organizers'];
	$nOfWaitingStair = $_POST['n_of_waiting_stair'];
	$toast = $_POST['toast'];
	$organizers = $_POST['organizers'];
	$stairStaff = $_POST['stair_staff'];
	$organizersStaff = $_POST['organizers_staff'];
	$swine = $_POST['swine'];
	$message = $_POST['message'];

	
	if($event != 'typeno' && $nOfSitting != '' && $food != '' && $invoiceDrinks != '' && $nOfWaitingOrganizers != '' 
		&& $nOfWaitingStair != '' && $toast != '' && $organizers != '' && $stairStaff != '' && $organizersStaff != '' && $swine != '' && $message != '')
	{
		DBQuery::sql("INSERT INTO headwaiter_note (id, user_id, event_id, n_of_sitting, food, invoice_drinks, 
			n_of_waiting_organizers, n_of_waiting_stair, toast, organizers, stair_staff, organizers_staff, swine, message)
						VALUES ('', '$_SESSION[user_id]', '$event', '$nOfSitting', '$food', '$invoiceDrinks', '$nOfWaitingOrganizers', '$nOfWaitingStair', 
							'$toast', '$organizers', '$stairStaff', '$organizersStaff', '$swine', '$message')");
		?>
		<script>
			window.location = "?page=browseHeadwaiterNote";
		</script>
		<?php
	}
	
}

function loadMyHeadWaiterEvents()
{
	$groups = DBQuery::sql("SELECT id, name, start_time, event_type_id FROM event 
							WHERE event_type_id != 5
							ORDER BY start_time DESC"); //fixa så att endast jobbpass där man varit Hovis kommer upp

	for($i = 0; $i < count($groups); ++$i)
	{
		?>
			<option value="<?php echo $groups[$i]['id']; ?>"><?php echo($groups[$i]['name'].' '.$groups[$i]['start_time']); ?></option>
		<?php
	}
}

?>