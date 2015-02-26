<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1> <?php loadEventName() ?> </h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
<div class="col-sm-6">
	<div class="white-box">
		<h3>Evenemangsinformation</h3>
		<table class="basic-table">
		<?php loadEventDescription() ?>
		</table>
		
		</div> <!-- .white-box -->
	</div> <!-- .col-sm-6 -->
<div class="col-sm-6">
	<div class="white-box">
		<h3>Pass</h3>

		<div class="list-group">
		<?php loadWorkSlots() ?>
		</div>
		
		</div> <!-- .white-box -->
	</div> <!-- .col-sm-6 -->
</div> <!-- .row -->