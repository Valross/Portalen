<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('Skriv DA-lapp');

if(isset($_POST['submit']) && checkAdminAccess() <= 2)
{
	$event = strip_tags($_POST['event']);
	$salesTotal = strip_tags($_POST['salesTotal']);
	$salesEntry = strip_tags($_POST['salesEntry']);
	$salesBar = strip_tags($_POST['salesBar']);
	$cash = strip_tags($_POST['cash']);
	$nOfPeople = strip_tags($_POST['nOfPeople']);
	$salesSpenta = strip_tags($_POST['salesSpenta']);
	$message = strip_tags($_POST['message'], allowed_tags());

	if($event != 'typeno' && $salesTotal != '' && $salesEntry != '' && $salesBar != '' && $cash != '' && $nOfPeople != '' && $salesSpenta != '' && $message != '')
	{
		DBQuery::sql("INSERT INTO da_note (user_id, event_id, sales_total, sales_entry, sales_bar, cash, n_of_people, sales_spenta, message)
						VALUES ('$_SESSION[user_id]', '$event', '$salesTotal', '$salesEntry', '$salesBar', '$cash', '$nOfPeople', '$salesSpenta', '$message')");

		$DA_note = DBQuery::sql("SELECT id FROM da_note 
						ORDER BY date_written DESC");

		$DA_note_id = $DA_note[0]['id'];

		$users = DBQuery::sql("SELECT id FROM user
							WHERE id IN
								(SELECT user_id FROM group_member
								WHERE group_id = 7 OR group_id = 1 OR group_id = 12)");

		for($i = 0; $i < count($users); ++$i)
		{
			if($users[$i]['id'] != $_SESSION['user_id'])
				notify($users[$i]['id'], 3, $DA_note_id);
		}
	}	
	if(isset($_POST['partyriesArranging']))
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
	if(isset($_POST['partyriesWorking']))
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
	$user_id = $_SESSION['user_id'];
	$events = DBQuery::sql("SELECT id, name, start_time, event_type_id FROM event 
							WHERE event_type_id != 5 AND id IN
								(SELECT event_id FROM work_slot
								WHERE group_id = 7 AND id IN
									(SELECT work_slot_id FROM user_work
									WHERE user_id = '$user_id'))
							AND id NOT IN
								(SELECT event_id FROM da_note)
							ORDER BY start_time DESC"); 

	for($i = 0; $i < count($events); ++$i)
	{
		echo '<option value="'.$events[$i]['id'].'">'.$events[$i]['name'].' - '.$events[$i]['start_time'].'</option>';
	}
}

function loadArrangingPartyries()
{
	$partyries = DBQuery::sql("SELECT id, name FROM partyries");

	echo '<div class="two-column-checkboxes">';

	for($i = 0; $i < count($partyries)-5; ++$i)
	{
		echo '<label for="A'.$partyries[$i]['name'].'" class="label-wo-styling"><input type="checkbox" name="partyriesArranging[]" id="A'.$partyries[$i]['name'].'" value="'.$partyries[$i]['id'].'">';
		echo $partyries[$i]['name'];
		echo '</label>';
	}

	echo '</div>';
	echo '<div class="two-column-checkboxes">';

	for($i = count($partyries)-5; $i < count($partyries); ++$i)
	{
		echo '<label for="A'.$partyries[$i]['name'].'" class="label-wo-styling"><input type="checkbox" name="partyriesArranging[]" id="A'.$partyries[$i]['name'].'" value="'.$partyries[$i]['id'].'">';
		echo $partyries[$i]['name'];
		echo '</label>';
	}
	echo '</div>';
}

function loadWorkingPartyries()
{
	$partyries = DBQuery::sql("SELECT id, name FROM partyries");

	echo '<div class="two-column-checkboxes">';

	for($i = 0; $i < count($partyries)-5; ++$i)
	{
		echo '<label for="'.$partyries[$i]['name'].'" class="label-wo-styling"><input type="checkbox" name="partyriesWorking[]" id="'.$partyries[$i]['name'].'" value="'.$partyries[$i]['id'].'">';
		echo $partyries[$i]['name'];
		echo '</label>';
	}

	echo '</div>';
	echo '<div class="two-column-checkboxes">';

	for($i = count($partyries)-5; $i < count($partyries); ++$i)
	{
		echo '<label for="'.$partyries[$i]['name'].'" class="label-wo-styling"><input type="checkbox" name="partyriesWorking[]" id="'.$partyries[$i]['name'].'" value="'.$partyries[$i]['id'].'">';
		echo $partyries[$i]['name'];
		echo '</label>';
	}
	echo '</div>';
}

?>