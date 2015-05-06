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
</div>

<?php loadLayout(); ?>

</div>