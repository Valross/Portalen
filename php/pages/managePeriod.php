<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('Hantera lag');

if(checkAdminAccess() == 1)
	loadAll();
else
{
	?>
	<script>
		window.location = "?page=start";
		alert("Sluta försöka hacka sidan!")
	</script>
	<?php
}

if(isset($_POST['submit']))
{
	$periodName = strip_tags($_POST['periodName']);
	$id = strip_tags($_POST['id']);
	$start_date = strip_tags($_POST['start_date']);
	$end_date = strip_tags($_POST['end_date']);

	if($periodName != '')
	{
		DBQuery::sql("UPDATE period
				  SET name = '$periodName', start_date = '$start_date', end_date = '$end_date'
				  WHERE id = '$id'");
	}
}

function loadAll()
{
	echo '<div class="row">
			<div class="col-sm-12">
				<div class="page-header">
					<h1>
					<span class="fa fa-calendar-o fa-fw fa-lg"></span> Hantera perioder - 
					<a href="?page=period">Skapa period</a>
					</h1>
				</div>
			</div>
		</div> <!-- .row -->';
	echo '<div class="row">
			<div class="col-sm-6">
				<form action="" method="post">
					<div class="white-box">';

	echo '<label for="period">Period</label>
			<select name="period" id="period" class="bottom-border">
				<option id="typeno" value="typeno">Välj period</option>';
	loadAllPeriodsAsOption();
	echo '</select>';

	echo '<input type="submit" name="chooseGroup" value="Välj">';
	
	echo 			'</div>
				</form>
			</div>
		</div>';
	if(isset($_POST['chooseGroup']))
	{
		$period = $_POST['period'];
		if($period != '')
			loadPeriodManageTools($period);
	}
}

function loadAllPeriodsAsOption()
{
	$periods = DBQuery::sql("SELECT id, name FROM period 
							ORDER BY start_date DESC");
	for($i = 0; $i < count($periods); ++$i)
	{
		echo '<option value="'.$periods[$i]['id'].'">'.$periods[$i]['name'].'</option>';
	}
}

function loadPeriodManageTools($period)
{
	$period_name = DBQuery::sql("SELECT id, name, start_date, end_date FROM period 
						WHERE id = '$period'
						ORDER BY start_date DESC");

	echo '<div class="row">
			<div class="col-sm-6">
				<form action="" method="post">
					<div class="white-box">';

	echo '<label for="periodName">Periodnamn</label>
			<input type="text" name="periodName" id="periodName" value="'.$period_name[0]['name'].'">
			<label for="start_date">Startdatum <span class="fa fa-cloud fa-fw fa-lg"></span></label>
			<input type="text" name="start_date" id="start_date" placeholder="2015-04-20" value="'.$period_name[0]['start_date'].'" class="bottom-border">
			<label for="end_date">Startdatum <span class="fa fa-cloud fa-fw fa-lg"></span></label>
			<input type="text" name="end_date" id="end_date" placeholder="2015-05-04" value="'.$period_name[0]['end_date'].'" class="bottom-border">';

	echo '<input type="hidden" name="id" id="id" value="'.$period_name[0]['id'].'">';

	echo '<input type="submit" name="submit" value="Spara">';

	echo '<a href="?page=removePeriod&period_id='.$period_name[0]['id'].'"><span class="fa fa-remove fa-fw fa-lg"></span>Ta bort perioden</a>';
	
	echo 			'</div>
				</form>
			</div>
		</div>';
}

?>