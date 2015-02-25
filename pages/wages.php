
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
			          	<th>Person</th>
			          	<th>Banknummer</th>
			          	<th>Timmar</th>
			          	<th>Timlön</th>
					  	<th>Totallön</th>
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
