<?php
	if(checkAdminAccess())
	{
?>

<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1><?php loadEventName(); ?></h1>
			<h4><img src="<?php echo loadHeadwaiterAvatar(); ?>" width="32" height="32" class="img-circle"> <?php loadHeadwaiterName(); ?></h4>
		</div>
	</div>
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

<div class="row">
	<div class="col-sm-6">
		<div class="white-box">
		<h4>Maten</h4>
			<p>

			<?php loadFood(); ?>
			
			</p>
		<h4>Drinkfakturering</h4>
			<p>

			<?php loadInvoiceDrinks(); ?>
			
			</p>
		<h4>Toast</h4>
			<p>

			<?php loadToast(); ?>
			
			</p>
		<h4>Arrangörerna</h4>
			<p>

			<?php loadOrganizers(); ?>
			
			</p>
		<h4>Trappans Personal</h4>
			<p>

			<?php loadStairStaff(); ?>
			
			</p>
		<h4>Arrangörernas Personal</h4>
			<p>

			<?php loadOrganizersStaff(); ?>
			
			</p>
		<h4>Svinn</h4>
			<p>

			<?php loadSwine(); ?>
			
			</p>
		<h4>Meddelande</h4>
			<p>

			<?php loadMessage(); ?>
			
			</p>
		</div>
	</div>
</div>
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