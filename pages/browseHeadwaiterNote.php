<?php
	if(checkAdminAccess() <= 3)
	{
?>
<div class="row">
	<div class="col-sm-6">
		<div class="page-header">
			<h1><span class="fa fa-female fa-fw fa-lg"></span> Hovis-lappar</h1>
		</div>
	</div>
	<div class="col-sm-6 page-header-right">
		<div class="pull-right form-inline">
			<a href="?page=createHeadwaiterNote" class="btn btn-page-header"><i class="fa fa-pencil fa-fw"></i> Skriv Hovis-lapp</a>
				<div class="btn-group">
					<a href="?page=browseDANote" class="btn btn-page-header"><i class="fa fa-key fa-fw"></i> DA-lappar</a>
  					<a href="?page=browseHeadwaiterNote" class="btn btn-page-header active"><i class="fa fa-female fa-fw"></i> Hovis-lappar</a>
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