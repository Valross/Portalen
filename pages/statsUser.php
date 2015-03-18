<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
		<img src="<?php echo loadAvatar(); ?>" width="100" height="100" class="page-header-img img-circle">
			<h1 class="header-img"><?php loadUserName(); ?></h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
	<div class="col-sm-6">
		<div class="white-box">

		  	<?php loadStats(); ?>
			  	
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-6">
		<div class="white-box">
			<h3>
				Antal gemensamma pass
			</h3>

		  	<table class="table table-hover">
		      	<thead>
			        <tr>
			          	<th>Namn</th>
			          	<th>Antal pass</th>
			        </tr>
			    </thead>
				<tbody>

				  	<?php loadColleagueStats(); ?>

			  	</tbody>
			</table>
			  	
		</div>
	</div>
</div>
