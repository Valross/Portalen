<?php
	if(checkAdminAccess())
	{
?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1><span class="fa fa-user-plus fa-fw fa-lg"></span> Granska ansökningar</h1>
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
			          <th>Namn</th>
			          <th>Personnummer</th>
			          <th>Mail</th>
					  <th>Lag</th>
					  <th>Verktyg</th>
			        </tr>
		     	</thead>
			  	<tbody>

				  	<?php loadApplications(); ?>

			  	</tbody>
				</table>
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