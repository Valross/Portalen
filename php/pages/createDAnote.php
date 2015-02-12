<?php
include_once('php/DBQuery.php');

if(isset($_POST['submit']))
{
	$event = $_POST['event'];
	$salesEntry = $_POST['salesEntry'];
	$salesBar = $_POST['salesBar'];
	$cash = $_POST['cash'];
	$nOfPeople = $_POST['nOfPeople'];
	$salesSpenta = $_POST['salesSpenta'];
	$message = $_POST['message'];
	
	if($event != 'typeno' && $salesEntry != '' && $salesBar != '' && $cash != '' && $nOfPeople != '' && $salesSpenta != '' && $message != '')
	{
		DBQuery::sql("INSERT INTO da_note (user_id, event_id, sales_entry, sales_bar, cash, n_of_people, sales_spenta, message)
						VALUES ('$_SESSION[user_id]', '$event', '$salesEntry', '$salesBar', '$cash', '$nOfPeople', '$salesSpenta', '$message')");
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
?>