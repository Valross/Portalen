<?php
	if(checkAdminAccess() <= 3)
	{
?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1><span class="fa fa-female fa-fw fa-lg"></span> Hovis-lappar - 
			<a href="?page=browseDANote"><span class="fa fa-key fa-fw fa-lg"></span>DA-lappar</a></h1>
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
			          	<th>Sittning</th>
			          	<th>Datum</th>
			          	<th>Antal sittande</th>
			          	<th>Hovis</th>
			        </tr>
			    </thead>
				<tbody>

				  	<?php loadAllHeadwaiterNotes(); ?>

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