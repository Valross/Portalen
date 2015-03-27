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
		<h4>Idag</h4>
		<div class="list-group">	
			<?php loadTodaysEvents(); ?>
		</div>
	</div> <!-- .white-box -->
	<div class="white-box">
		<h4>Bokat</h4>	
		<div class="list-group">
			 <?php loadBookedEvents(); ?>
		</div>
	</div> <!-- .white-box -->
	<div class="white-box">
		<h4>Bokningsbart</h4>
		<div class="list-group">
			<?php loadAvailableEvents(); ?>
		</div>
	</div> <!-- .white-box -->
	<div class="white-box">
		<h4>Möten</h4>
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

