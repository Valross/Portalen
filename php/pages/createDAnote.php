<?php
include_once('php/DBQuery.php');

$dates = new DateTime;
$dates->setTimezone(new DateTimeZone('Europe/Stockholm'));
$date = $dates->format('Y-m-d H:i:s');

if(isset($_POST['submit']) && checkAdminAccess())
{
	$event = strip_tags($_POST['event']);
	$salesTotal = strip_tags($_POST['salesTotal']);
	$salesEntry = strip_tags($_POST['salesEntry']);
	$salesBar = strip_tags($_POST['salesBar']);
	$cash = strip_tags($_POST['cash']);
	$nOfPeople = strip_tags($_POST['nOfPeople']);
	$salesSpenta = strip_tags($_POST['salesSpenta']);
	$message = strip_tags($_POST['message'];, allowed_tags());

	if($event != 'typeno' && $salesTotal != '' && $salesEntry != '' && $salesBar != '' && $cash != '' && $nOfPeople != '' && $salesSpenta != '' && $message != '')
	{
		DBQuery::sql("INSERT INTO da_note (user_id, event_id, sales_total, sales_entry, sales_bar, cash, n_of_people, sales_spenta, message, date_written)
						VALUES ('$_SESSION[user_id]', '$event', '$salesTotal', '$salesEntry', '$salesBar', '$cash', '$nOfPeople', '$salesSpenta', '$message', '$date')");
	}	
	if(count($_POST['partyriesArranging']) > 0)
	{
        $partyriesArranging = $_POST['partyriesArranging'];
        $partyriesArrangingCounter = count($partyriesArranging);

        for($i = 0; $i < $partyriesArrangingCounter; ++$i)
        {
        	$partyriesArranging_id = $partyriesArranging[$i];
			DBQuery::sql("INSERT INTO partyries_arrange (event_id, partyries_id)
							VALUES ('$event', '$partyriesArranging_id')");
        }
	}
	if(count($_POST['partyriesWorking']) > 0)
	{
        $partyriesWorking = $_POST['partyriesWorking'];
        $partyriesWorkingCounter = count($partyriesWorking);

        for($i = 0; $i < $partyriesWorkingCounter; ++$i)
        {
        	$partyriesWorking_id = $partyriesWorking[$i];
			DBQuery::sql("INSERT INTO partyries_work (event_id, partyries_id)
							VALUES ('$event', '$partyriesWorking_id')");
        }
	}
	if($event != 'typeno' && $salesEntry != '' && $salesBar != '' && $cash != '' && $nOfPeople != '' && $salesSpenta != '' && $message != '')
	{
		?>
		<script>
			window.location = "?page=DANote&id=<?php echo $event; ?>";
		</script>
		<?php
	}	
}

function loadMyDAEvents()
{
	// $groups = DBQuery::sql("SELECT id, name, start_time, event_type_id FROM event 
	// 						WHERE event_type_id != 5
	// 						ORDER BY start_time DESC"); //fixa så att endast jobbpass där man varit DA kommer upp
	$user_id = $_SESSION['user_id'];

	$groups = DBQuery::sql("SELECT id, name, start_time, event_type_id FROM event 
							WHERE event_type_id != 5 AND id IN
								(SELECT event_id FROM work_slot
								WHERE group_id = 7 AND id IN
									(SELECT work_slot_id FROM user_work
									WHERE user_id = '$user_id'))
							ORDER BY start_time DESC"); 

	for($i = 0; $i < count($groups); ++$i)
	{
		?>
			<option value="<?php echo $groups[$i]['id']; ?>"><?php echo($groups[$i]['name'].' '.$groups[$i]['start_time']); ?></option>
		<?php
	}
	if(count($groups) == 0)
		echo 'fuck';
}

function loadArrangingPartyries()
{
	$partyries = DBQuery::sql("SELECT id, name FROM partyries");
	?>
		<div class="two-column-checkboxes">
	<?php
	for($i = 0; $i < count($partyries)-5; ++$i)
	{
		?>

			<label for="A<?php echo $partyries[$i]['name']; ?>" class="label-wo-styling"><input type="checkbox" name="partyriesArranging[]" id="A<?php echo $partyries[$i]['name']; ?>" value="<?php echo $partyries[$i]['id']; ?>">
			<?php echo $partyries[$i]['name']; ?></label>
		<?php
	}
	?>
		</div>
		<div class="two-column-checkboxes">
	<?php
	for($i = count($partyries)-5; $i < count($partyries); ++$i)
	{
		?>
			<label for="A<?php echo $partyries[$i]['name']; ?>" class="label-wo-styling"><input type="checkbox" name="partyriesArranging[]" id="A<?php echo $partyries[$i]['name']; ?>" value="<?php echo $partyries[$i]['id']; ?>">
			 <?php echo $partyries[$i]['name']; ?></label>
		<?php
	}
	?>
		</div>
	<?php
}

function loadWorkingPartyries()
{
	$partyries = DBQuery::sql("SELECT id, name FROM partyries");
	?>
		<div class="two-column-checkboxes">
	<?php
	for($i = 0; $i < count($partyries)-5; ++$i)
	{
		?>
			<label for="<?php echo $partyries[$i]['name']; ?>" class="label-wo-styling"><input type="checkbox" name="partyriesWorking[]" id="<?php echo $partyries[$i]['name']; ?>" value="<?php echo $partyries[$i]['id']; ?>">
			<?php echo $partyries[$i]['name']; ?></label>
		<?php
	}
	?>
		</div>
		<div class="two-column-checkboxes">
	<?php
	for($i = count($partyries)-5; $i < count($partyries); ++$i)
	{
		?>
			
			<label for="<?php echo $partyries[$i]['name']; ?>" class="label-wo-styling"><input type="checkbox" name="partyriesWorking[]" id="<?php echo $partyries[$i]['name']; ?>" value="<?php echo $partyries[$i]['id']; ?>"> <?php echo $partyries[$i]['name']; ?></label>
		<?php
	}
	?>
		</div>
	<?php
}

?>