<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1>
				<?php loadProtocolTitle(); ?>
				- <?php loadProtocolLink(); ?>
			</h1>
			<h4>
			<img src="<?php echo loadProtocolAvatar(); ?>" width="32" height="32" class="img-circle"> <?php loadSecretaryName(); ?></h4>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-6">
		<div class="white-box">
			<h3>	
				Meddelande
				<?php loadRemove(); ?>
			</h3>
			<p>
			<?php loadProtocolMessage(); ?>
			</p>
		</div>
	</div>
</div> <!-- .row -->