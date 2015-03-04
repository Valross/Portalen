<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
			<h1><span class="fa fa-trophy fa-fw fa-lg"></span> <a href="?page=achievements">Achievements</a></h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
		<img src="<?php echo loadAvatarFromId(); ?>" width="100" height="100" class="img-circle">
			<h1 class="header-img"><?php loadName(); ?></h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
	<div class="col-sm-6">
		<div class="white-box">
			<table class="table table-hover">
				<tbody>

				  	<?php loadAchievementsUnlocked() ?>

			  	</tbody>
				</table>
		</div>
	</div>
</div>