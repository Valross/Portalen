<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1><span class="fa fa-home fa-fw fa-lg"></span> Hem</h1>
		</div>
	</div>
</div>

<div class="row">
<div class="col-sm-6">
		<h3>Dina bokade pass</h3>	
		
			<div class="list-group">
				 <?php loadBookedEvents(); ?>
			</div>
			<h3>Idag på Trappan</h3>
			<div class="list-group">	
				<?php loadTodaysEvents(); ?>
			</div>
			<h3>Lediga pass</h3>
			<div class="list-group">
				<?php loadAvailableEvents(); ?>
			</div>
			<h3>Möten</h3>
			<div class="list-group">
				<?php loadAvailableMeetings(); ?>
			</div>
</div>
		
<div class="col-sm-6">
	<div class="white-box">
	<h1><?php loadTitle(); ?></h1>
	<div>
		<?php loadUserAvatar(); ?>
	</div>
	<div>
		<?php loadUserName(); ?>
	</div>
	<div>
		<?php loadDate(); ?>
	</div>
	<div class="list-group">
		<?php loadMessage(); ?>
	</div>
	
	</div>
</div>
</div>

