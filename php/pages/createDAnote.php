<?php
include_once('php/DBQuery.php');

$dates = new DateTime;
$dates->setTimezone(new DateTimeZone('Europe/Stockholm'));
$date = $dates->format('Y-m-d H:i:s');

if(isset($_POST['submit']))
{
	$event = $_POST['event'];
	$salesEntry = $_POST['salesEntry'];
	$salesBar = $_POST['salesBar'];
	$cash = $_POST['cash'];
	$nOfPeople = $_POST['nOfPeople'];
	$salesSpenta = $_POST['salesSpenta'];
	$message = $_POST['message'];

	if(isset($_POST['partyries']))
	{
        $partyries = $_POST['partyries'];
        $partyriesCounter = count($partyries);
    }
	
	if($event != 'typeno' && $salesEntry != '' && $salesBar != '' && $cash != '' && $nOfPeople != '' && $salesSpenta != '' && $message != '')
	{
		DBQuery::sql("INSERT INTO da_note (user_id, event_id, sales_entry, sales_bar, cash, n_of_people, sales_spenta, message, date_written)
						VALUES ('$_SESSION[user_id]', '$event', '$salesEntry', '$salesBar', '$cash', '$nOfPeople', '$salesSpenta', '$message', '$date')");
		?>
		<script>
			window.location = "?page=browseDANote";
		</script>
		<?php
	}
	
}

function loadMyDAEvents()
{
	$groups = DBQuery::sql("SELECT id, name, start_time, event_type_id FROM event 
							WHERE event_type_id != 5
							ORDER BY start_time DESC"); //fixa så att endast jobbpass där man varit DA kommer upp

	for($i = 0; $i < count($groups); ++$i)
	{
		?>
			<option value="<?php echo $groups[$i]['id']; ?>"><?php echo($groups[$i]['name'].' '.$groups[$i]['start_time']); ?></option>
		<?php
	}
}

function loadPartyries()
{
	$partyries = DBQuery::sql("SELECT id, name FROM partyries");
	for($i = 0; $i < count($partyries); ++$i)
	{
		?>
			<div class="fifty-percent-width">
				<input type="checkbox" name="partyries[]" id="<?php echo $partyries[$i]['id']; ?>" value="<?php echo $partyries[$i]['id']; ?>">
				<label for="<?php echo $partyries[$i]['id']; ?>"><?php echo $partyries[$i]['name']; ?></label>
			</div>
		<?php
	}
}

?>