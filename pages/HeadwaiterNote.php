<?php
	if(checkAdminAccess() <= 3)
	{
?>

<div class="row">
	<div class="col-sm-6">
		<div class="page-header">
			<h1><?php loadEventName(); ?></h1>
			<h4><img src="<?php echo loadHeadwaiterAvatar(); ?>" width="32" height="32" class="img-circle"> <?php loadHeadwaiterName(); ?></h4>
		</div>
	</div>
	<div class="col-sm-6 page-header-right text-right">
		<?php loadButtons() ?> 
	  	<a href="?page=browseHeadwaiterNote" class="btn btn-page-header"><i class="fa fa-arrow-circle-left fa-fw"></i> Tillbaka till alla hovis-lappar</a>
	</div> <!-- .col-sm-6 -->
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="white-box">
			<table class="table table-hover">
		      	<thead>
			        <tr>
			          	<th>Antal sittande</th>
			          	<th>Antal servering från arrangör</th>
			          	<th>Antal servering från Trappan</th>
			        </tr>
			    </thead>
				<tbody>

				  	<?php loadHeadwaiterStats(); ?>

			  	</tbody>
				</table>
			</div>
		</div> <!-- col-sm-12 -->
	</div> <!-- .row -->

<form action="" method="post" id="headwaiter_note_form">
<div class="row">
	<div class="col-sm-6">
		<div class="white-box">
			<h3>Meddelande</h3>
		<h5>Maten</h5>
			<p><?php loadFood(); ?></p>
			
		<h5>Drinkfakturering</h5>
			<p><?php loadInvoiceDrinks(); ?></p>
			
		<h5>Toast</h5>
			<p><?php loadToast(); ?></p>
			
		<h5>Arrangörerna</h5>
			<p><?php loadOrganizers(); ?></p>
			
		<h5>Trappans Personal</h5>
			<p><?php loadStairStaff(); ?></p>
			
		<h5>Arrangörernas Personal</h5>
			<p><?php loadOrganizersStaff(); ?></p>
			
		<h5>Svinn</h5>
			<p><?php loadSwine(); ?></p>
			
		<h5>Övrigt</h5>
			<p><?php loadMessage(); ?></p>
		</div>
	</div>
	<div class="col-sm-6">
		<div class="white-box">
			<h3>Fixlista</h3>
				<p>
				<?php loadFixlist(); ?>
				</p>
		</div>
	</div>
</div>
</form>

<div class="row">
	<?php loadWorkSlots(); ?>
</div> <!-- .row -->

<?php loadComments(); ?>

<?php
	}
	else
	{
		?>
			<script>
				window.location = "?page=start";
				alert("Sluta försöka hacka sidan!")
			</script>
		<?php
	}
?>