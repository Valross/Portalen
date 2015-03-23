<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('Perioder');

if(isset($_POST['submit']))
{
	$periodName = $_POST['name'];
	$periodStart = $_POST['start_date'];
	$periodEnd = $_POST['end_date'];
	
	// check if all fields are filled
	if ($periodName != '' && $periodStart != '' && $periodEnd != ''){

		// check date form
		if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$periodStart)
			&& preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$periodStart)
			&& $periodStart < $periodEnd){

			// all ok, add to db and reload
			DBQuery::sql("INSERT INTO period (name, start_date, end_date)
								VALUES ('$periodName', '$periodStart', '$periodEnd')");
			?>
			<script>
				window.location = "?page=period";
			</script>
			<?php
		}
	    
	    // date form wrong
	    else{
	        ?>
			<script>
				window.location = "?page=period";
				alert("Fel: Var vänlig och skriv datumet som åååå-mm-dd och se till att inte gå bakåt i tiden")
			</script>
			<?php
	    }

	}

	// fields left empty
	else{
		?>
		<script>
			window.location = "?page=period";
			alert("Fel: Du måste fylla i alla fält")
		</script>
		<?php
	}
}
?>