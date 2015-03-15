<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
			<h1><span class="fa fa-trophy fa-fw fa-lg"></span> Achievements
			<?php
				if(checkAdminAccess())
				{
					echo ' - <a href="?page=createAchievement">Hantera</a>';
				}
			?>
			</h1>
		</div>
	</div>
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