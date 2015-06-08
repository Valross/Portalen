<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('Skriv DA-lapp');

if(isset($_POST['submit']) && checkAdminAccess() <= 2)
{
	$event_id = $_GET['id'];
	if(isset($_POST['partyriesArrangingComment']))
	{
        $partyriesArranging = $_POST['partyriesArrangingComment'];
        $partyries = DBQuery::sql("SELECT event_id, partyries_id FROM partyries_arrange
							WHERE event_id = '$event_id'");	

        $partyriesArrangingCounter = count($partyries);
        for($i = 0; $i < $partyriesArrangingCounter; ++$i)
        {
        	$comment = $partyriesArranging[$i];
        	$partyrie_id = $partyries[$i]['partyries_id'];
			DBQuery::sql("UPDATE partyries_arrange
			  SET comment = '$comment'
			  WHERE event_id = '$event_id'
			  AND partyries_id = '$partyrie_id'");
        }
	}
	if(isset($_POST['partyriesWorkingComment']))
	{
        $partyriesWorking = $_POST['partyriesWorkingComment'];
        $partyries = DBQuery::sql("SELECT event_id, partyries_id FROM partyries_work
							WHERE event_id = '$event_id'");	

        $partyriesWorkingCounter = count($partyries);
        for($i = 0; $i < $partyriesWorkingCounter; ++$i)
        {
        	$comment = $partyriesWorking[$i];
        	$partyrie_id = $partyries[$i]['partyries_id'];
			DBQuery::sql("UPDATE partyries_work
			  SET comment = '$comment'
			  WHERE event_id = '$event_id'
			  AND partyries_id = '$partyrie_id'");
        }
	}
	?>
	<script>
		window.location = "?page=DANote&id=<?php echo $event_id; ?>";
	</script>
	<?php
}

function loadArrangingPartyries()
{
	$event_id = $_GET['id'];
	$partyries = DBQuery::sql("SELECT event_id, partyries_id FROM partyries_arrange
							WHERE event_id = '$event_id'");	

	for($i = 0; $i < count($partyries); ++$i)
	{
		$partyrie_id = $partyries[$i]['partyries_id'];
		$partyrie = DBQuery::sql("SELECT id, name FROM partyries
								WHERE id = '$partyrie_id'");
		echo '<div class="white-box">';
		echo '<label for="A'.$partyrie[0]['name'].'">Arrangerande - '.$partyrie[0]['name'].'</label>
			<textarea rows="6" cols="50" placeholder="lol" name="partyriesArrangingComment[]" maxlength="4000"
			id="A'.$partyrie[0]['name'].'"></textarea>';
		echo '</div>';
	}	
}

function loadWorkingPartyries()
{
	$event_id = $_GET['id'];
	$partyries = DBQuery::sql("SELECT event_id, partyries_id FROM partyries_work
							WHERE event_id = '$event_id'");	

	for($i = 0; $i < count($partyries); ++$i)
	{
		$partyrie_id = $partyries[$i]['partyries_id'];
		$partyrie = DBQuery::sql("SELECT id, name FROM partyries
								WHERE id = '$partyrie_id'");
		echo '<div class="white-box">';
		echo '<label for="'.$partyrie[0]['name'].'">Arbetande - '.$partyrie[0]['name'].'</label>
			<textarea rows="6" cols="50" placeholder="lol" name="partyriesWorkingComment[]" maxlength="4000"
			id="'.$partyrie[0]['name'].'"></textarea>';
		echo '</div>';
	}
}

?>