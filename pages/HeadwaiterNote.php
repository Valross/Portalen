<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
		<img src="<?php echo loadHeadwaiterAvatar(); ?>" width="100" height="100" class="page-header-img">
			<h1 class="header-img"><?php loadHeadwaiterName(); ?></h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1>

				<?php loadEventName(); ?>

			</h1>
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
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="white-box">
		<h3>Maten</h3>
			<p>

			<?php loadFood(); ?>
			
			</p>
		<h3>Drinkfakturering</h3>
			<p>

			<?php loadInvoiceDrinks(); ?>
			
			</p>
		<h3>Toast</h3>
			<p>

			<?php loadToast(); ?>
			
			</p>
		<h3>Arrangörerna</h3>
			<p>

			<?php loadOrganizers(); ?>
			
			</p>
		<h3>Trappans Personal</h3>
			<p>

			<?php loadStairStaff(); ?>
			
			</p>
		<h3>Arrangörernas Personal</h3>
			<p>

			<?php loadOrganizersStaff(); ?>
			
			</p>
		<h3>Svinn</h3>
			<p>

			<?php loadSwine(); ?>
			
			</p>
		<h3>Meddelande</h3>
			<p>

			<?php loadMessage(); ?>
			
			</p>
		</div>
	</div>
</div>