<?php
include_once('php/DBQuery.php');

if(isset($_POST['submit']))
{
	$PeriodName = $_POST['name'];
	$PeriodStart = $_POST['start_date'];
	$PeriodEnd = $_POST['end_date'];
	
		{
		DBQuery::sql("INSERT INTO period (name, start_date, end_date)
							VALUES ('$PeriodName', '$PeriodStart', '$PeriodEnd')");
		?>
		<?php
	}
	
}
?>