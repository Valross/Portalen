<?php loadTitleForBrowser('Boka pass'); ?>
<div class="row">	
	<div class="col-sm-12">
		<div class="page-header">
			<h1><span class="fa fa-list fa-fw fa-lg"></span> Boka pass - The old fashioned way</h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">

<div class="col-sm-4">
	<?php loadBookedEvents(); ?>

	<?php loadAvailableEvents(); ?>
</div> <!-- .col-sm-4 -->
<!-- <div class="col-sm-8">
	<div class="white-box">
		<div class="calendar-top">
			<h3>Bokning</h3>
			<div class="pull-right form-inline">
			<div class="btn-group">
				<?php loadPageNavigators(); ?>
			</div>
			</div>
		</div>

	</div>
</div> -->

<?php loadLayout(); ?>

</div>