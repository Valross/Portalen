<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
			<h1><span class="fa fa-trophy fa-fw fa-lg"></span> Achievements
			</h1>
		</div>
	</div>
	<?php
		if(checkAdminAccess() <= 1)
		{
	echo'<div class="col-sm-4 page-header-right text-right">
		<a href="?page=createAchievement" class="btn btn-page-header"><i class="fa fa-wrench fa-fw"></i> Hantera achievements</a>
	</div>';
	}
?>
</div> <!-- .row -->

<div class="row">
	<div class="col-sm-6">
		<div class="white-box">
			<h3>Topp 10</h3>
			<table class="table table-hover">
		      	<thead>
			        <tr>
			          	<th>#</th>
			          	<th>Namn</th>
					  	<th>Poäng</th>
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
			<h3>Lista över alla achievements</h3>
			<div class="list-group">

				<?php loadAchievements() ?>

			</div>
		</div>
	</div>
</div>