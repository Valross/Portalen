<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
		<img src="<?php echo loadUserAvatar(); ?>" width="100" height="100" class="page-header-img img-circle">
			<h1 class="header-img"><?php loadUserName(); ?></h1>
		</div>
	</div>
</div> <!-- .row -->

<form action="" method="post">
<div class="row">
<div class="col-sm-6">
	<div class="white-box">
		<h3>Datum</h3>

		<div class="input-group date datetimepicker">
			<label for="start">Starttid</label>
			<input id="start" type="text" name="start" value="<?php echo $dateNoTime; ?>">
	        <span class="input-group-addon"><span class="fa fa-calendar"></span></span>
		</div>
			
		<div class="input-group date datetimepicker">
			<label for="end">Sluttid</label>
			<input id="end" type="text" name="end" value="<?php echo $dateNoTime; ?>">
			<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
		</div>
		
		<input type="submit" name="submit" value="Sök">
	</div>
</div> <!-- .white-box -->
</div> <!-- .col-sm-6 -->			

<div class="row">
	<div class="col-sm-12">
		<div class="white-box">
			<table class="table table-hover">
		      	<thead>
			        <tr>
			          	<th>#</th>
			          	<th>Event</th>
			          	<th>Datum</th>
			          	<th>Poäng</th>
					  	<th>Lön</th>
			        </tr>
			    </thead>
				<tbody>

				  	<?php loadStats(); ?>

			  	</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
