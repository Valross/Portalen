<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
			<h1>
				<span class="fa fa-globe fa-fw fa-lg"></span>
				Händelser
			</h1>
		</div>
	</div>
</div> <!-- .row -->

<!-- <div class="row">
	<div class="col-sm-6">
		<div class="white-box">
			<h4>
				<img src="<?php echo loadAvatarFromId(); ?>" width="32" height="32" class="img-circle">
				<?php loadName(); ?>
			</h4>
			<table class="table table-hover">
				<tbody>
					<thead>
			        <tr>
			        	<th>id</th>
			        	<th>user_id</th>
			          	<th>notification_type</th>
			          	<th>info</th>
			          	<th>seen</th>
			          	<th>date</th>
			        </tr>
			    	</thead>

				  	<?php loadNotificationsDebug() ?>

			  	</tbody>
				</table>
		</div>
	</div>
</div> -->

<?php loadNotifications() ?>