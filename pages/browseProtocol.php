<?php
	if(checkAdminAccess() == 1)
	{
?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1>
				<span class="fa fa-list-alt fa-fw fa-lg"></span>
				 Protokoll
				  - <?php loadGroupName(); ?>
				  -<?php loadDotsLink(); ?>
			 </h1>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-6">
		<div class="white-box">
			<h3>
				<?php loadProtocolLink(); ?>
			</h3>
			<table class="table table-hover">
		      	<thead>
			        <tr>
			          	<th>#</th>
			          	<th>Titel</th>
			          	<th>Datum</th>
					  	<th>Sekreterare</th>
			        </tr>
			    </thead>
				<tbody>

				  	<?php loadAllProtocols(); ?>

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