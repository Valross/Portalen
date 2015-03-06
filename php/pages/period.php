<?php
include_once('php/DBQuery.php');

if(isset($_POST['submit']))
{
	$PeriodName = $_POST['name'];
	$PeriodStart = $_POST['start_date'];
	$PeriodEnd = $_POST['end_date'];
	
	if($PeriodName != '' && $PeriodStart != '' && $PeriodEnd != ''){
		DBQuery::sql("INSERT INTO period (name, start_date, end_date)
							VALUES ('$PeriodName', '$PeriodStart', '$PeriodEnd')");
		?>
		<script>
			window.location = "?page=start";
		</script>
		<?php
	}

	else{
		?>
		<script>
			window.location = "?page=start";
			alert("Fel: Du måste fylla i alla fält")
		</script>
		<?php
	}
}
?>