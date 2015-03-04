<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1><span class="fa fa-home fa-fw fa-lg"></span> Hem</h1>
		</div>
	</div>
</div>

<div class="row">
<div class="col-sm-5">
	<div class="white-box">
		
			<h3>Bokade pass</h3>	
			<div class="list-group">
				 <?php loadBookedEvents(); ?>
			</div>
			
			<h3>Idag på Trappan</h3>
			<div class="list-group">	
				<?php loadTodaysEvents(); ?>
			</div>
			
			<h3>Bokningsbara pass</h3>
			<div class="list-group">
				<?php loadAvailableEvents(); ?>
			</div>
			
			<h3>Möten</h3>
			<div class="list-group">
				<?php loadAvailableMeetings(); ?>
			</div>
	</div> <!-- .white-box -->
</div> <!-- col-sm-5 -->
		
<div class="col-sm-7">
	<div class="white-box">
	<h2><?php loadTitle(); ?></h2>
		
		<div class="news-info">
		<span><?php loadUserAvatar(); ?>
		<?php loadUserName(); ?></span> <span class="time">- <?php loadDate(); ?></span>
		</div>
		
		<p><?php loadMessage(); ?></p>
	
	</div>
</div>
</div>

