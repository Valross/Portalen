<?php
	if(checkAdminAccess() <= 2)
	{
?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1><span class="fa fa-key fa-fw fa-lg"></span> DA-lappar - 
			<a href="?page=browseHeadwaiterNote"><span class="fa fa-female fa-fw fa-lg"></span>Hovis-lappar</a></h1>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="white-box">
			<table class="table table-hover">
		      	<thead>
			        <tr>
			          	<th>#</th>
			          	<th>Event</th>
			          	<th><a href="?page=browseDANote&sort=start_date">Datum</a></th>
			          	<th><a href="?page=browseDANote&sort=total">Totalt (kr)</a></th>
			          	<th><a href="?page=browseDANote&sort=sales_entry">Entré (kr)</a></th>
			          	<th><a href="?page=browseDANote&sort=sales_bar">Bar (kr)</a></th>
					  	<th><a href="?page=browseDANote&sort=cash">Cash (kr)</a></th>
					  	<th><a href="?page=browseDANote&sort=nOfPeople">Inklick</a></th>
					  	<th><a href="?page=browseDANote&sort=sales_spenta">Gränga</a></th>
					  	<th>DA</th>
			        </tr>
			    </thead>
				<tbody>

			  	<?php loadAllDANotes(); ?>

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