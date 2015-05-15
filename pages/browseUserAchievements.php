<div class="row">
	<div class="col-sm-7">
		<div class="page-header">
			<h1>
				<span class="fa fa-trophy fa-fw fa-lg"></span>
				Achievements
			</h1>
		</div>
	</div>
	<div class="col-sm-5 page-header-right text-right">
		  <a href="?page=achievements" class="btn btn-page-header"><i class="fa fa-arrow-circle-left fa-fw"></i> Tillbaka till alla achievements</a>
	</div> <!-- .col-sm-5 -->
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