<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
			<h1>Achievements <span class="fa fa-trophy fa-fw fa-lg"></span></h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
	<div class="col-sm-6">
		<div class="white-box">
			<h1>Top 10</h1>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-6">
		<div class="white-box">
			<table class="table table-hover">
		      	<thead>
			        <tr>
			          	<th>#</th>
			          	<th>Namn</th>
					  	<th>Achievement-poäng</th>
			        </tr>
			    </thead>
				<tbody>

				  	<?php loadTop10() ?>

			  	</tbody>
				</table>
			</div>
		</div>
	<div class="col-sm-6">
		<div class="white-box">
			<table class="table table-hover">
				<tbody>

				  	<?php loadAchievements() ?>

			  	</tbody>
				</table>
		</div>
	</div>
</div>