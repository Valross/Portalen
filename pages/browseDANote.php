<?php
	if(checkAdminAccess() <= 2)
	{
?>
<div class="row">
	<div class="col-sm-6">
		<div class="page-header">
			<h1><span class="fa fa-key fa-fw fa-lg"></span> DA-lappar</h1>
		</div>
	</div>
	<div class="col-sm-6 page-header-right">
		<div class="pull-right form-inline">
			<a href="?page=createDANote" class="btn btn-page-header"><i class="fa fa-pencil fa-fw"></i> Skriv DA-lapp</a>
				<div class="btn-group">
					<a href="?page=browseDANote" class="btn btn-page-header active"><i class="fa fa-key fa-fw"></i> DA-lappar</a>
  					<a href="?page=browseHeadwaiterNote" class="btn btn-page-header"><i class="fa fa-female fa-fw"></i> Hovis-lappar</a>
				</div>
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