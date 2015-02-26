<?php
	if(checkAdminAccess())
	{
?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1>Hovis-lappar - <a href="?page=browseDANote">DA-lappar</a></h1>
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