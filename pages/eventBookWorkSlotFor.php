<div class="row">
	<div class="col-sm-7">
		<div class="page-header">
			<h1>Personallista</h1>
		</div>
	</div>
	<div class="col-sm-5 page-header-right text-right">
			<input type="search" class="form-control" placeholder="Sök efter för- och efternamn">
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
			          	<th>Medlem sedan</th>
			          	<th>Jobbade senast</th>
			        </tr>
			    </thead>
				<tbody>

				  	<?php loadPeople(); ?>

			  	</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
