<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
			<h1 class="header-img"><?php loadUserName(); ?></h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
	<div class="col-sm-6">
		<div class="white-box">
			<h3>
				Gemensamma pass
			</h3>

		  	<table class="table table-hover">
		      	<thead>
			        <tr>
			          	<th>Event</th>
			          	<th>Datum</th>
			        </tr>
			    </thead>
				<tbody>

				  	<?php loadColleagueStats(); ?>

			  	</tbody>
			</table>
			  	
		</div>
	</div>
</div>
