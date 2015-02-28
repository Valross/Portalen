<?php
	if(checkAdminAccess())
	{
?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1><span class="fa fa-user-secret fa-fw fa-lg"></span> DA-lappar - <a href="?page=browseHeadwaiterNote">Hovis-lappar</a></h1>
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
			          	<th>Entré (kr)</th>
			          	<th>Bar (kr)</th>
					  	<th>Cash (kr)</th>
					  	<th>Inklick</th>
					  	<th># Spenta</th>
					  	<th>DA</th>
			        </tr>
			    </thead>
				<tbody>

				  	<?php loadAllDANotes(); ?>

			  	</tbody>
				</table>
			</div>
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