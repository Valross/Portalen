<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
		<img src="<?php echo loadAvatar(); ?>" width="100" height="100" class="page-header-img img-circle">
			<h1 class="header-img"><?php echo $_SESSION['name'].' '.$_SESSION['last_name']; ?></h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
	<div class="col-sm-6">
		<div class="white-box">

		  	<?php loadStats(); ?>
			  	
		</div>
	</div>
</div>
