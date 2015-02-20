<div class="col-sm-5">
	<div class="row">
		
		<div class="col-sm-12"><h3>Dina bokade pass</h3>	
		
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
	</div>
</div>
<div class="col-sm-7">
	<h1>Nyhet</h1>
	<?php loadTitle(); ?>
	<?php loadMessage(); //fixa frontend?>
	<?php loadUser(); ?>
	<?php loadDate(); ?>
</div>

