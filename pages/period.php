<?php
	if(checkAdminAccess() <= 1)
	{
?>
<div class="row">	
	<div class="col-sm-12">
		<div class="page-header">
			<h1><span class="fa fa-calendar-o fa-fw fa-lg"></span> Skapa period - 
			<a href="?page=managePeriod">Hantera perioder</a>
			</h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
	
<div class="col-sm-6">
	<div class="white-box">
		<h3>Skapa ny period</h3>
	<form action="" method="post">
		
		<label for="name">Period</label>
		<input type="text" id="name" placeholder="månad år" name="name">
		<label for="start_date">Startdatum</label>
		<input type="text" id="start_date" placeholder="åååå-mm-dd" name="start_date">
		<label for="end_date">Slutdatum</label>
		<input type="text" id="end_date" placeholder="åååå-mm-dd" name="end_date" class="bottom-border">
		
		<input type="submit" name="submit" value="Skapa period">
	</form>
	</div>
</div>
</div>
<?php
	}
	else
	{
		?>
			<script>
				window.location = "?page=start";
				alert("Sluta försöka hacka sidan!")
			</script>
		<?php
	}
?>