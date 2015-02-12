<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
		<img src="<?php echo loadDAAvatar(); ?>" width="100" height="100" class="page-header-img">
			<h1 class="header-img"><?php loadDAName(); ?></h1>
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
			          	<th>Entré (kr)</th>
			          	<th>Bar (kr)</th>
					  	<th>Cash (kr)</th>
					  	<th>Inklick</th>
					  	<th># Spenta</th>
			        </tr>
			    </thead>
				<tbody>

				  	<?php loadDAStats(); ?>

			  	</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-sm-12">
		<div class="white-box">
			<p>

			<?php loadDAMessage(); ?>
			
			</p>
		</div>
	</div>
</div>