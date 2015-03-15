<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
			<h1>
				<span class="fa fa-trophy fa-fw fa-lg"></span>
				<a href="?page=achievements">Achievements</a>
			</h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
	<div class="col-sm-6">
		<div class="white-box">
			<h4>
				<img src="<?php echo loadAvatarFromId(); ?>" width="32" height="32" class="img-circle">
				<?php loadName(); ?>
			</h4>
			<table class="table table-hover">
				<tbody>

				  	<?php loadAchievementsUnlocked() ?>

			  	</tbody>
				</table>
		</div>
	</div>
</div>