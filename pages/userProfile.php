<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
		<img src="<?php echo loadUserAvatar(); ?>" width="100" height="100" class="page-header-img img-circle">
			<h1 class="header-img"><?php loadUserName(); ?></h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
<div class="col-sm-6">
	<div class="white-box">
		<h3>Om</h3>
	<p><?php echo $profileDescription; ?></p>
	<table class="basic-table">
		<tr>
			<td><strong>Ålder</strong></td>
			<td><?php loadAge() ?></td>
		</tr>
		<tr>
			<td><strong>Utbildning</strong></td>
			<td><?php echo $major; ?></td>
		</tr>
		<tr>
			<td><strong>Personal sedan</strong></td>
			<td><?php echo $profileCreation; ?></td>
		</tr>
		<tr>
			<td><strong>Senast inloggad</strong></td>
			<td><?php echo $latest_session; ?></td>
		</tr>
		<tr>
			<td><strong>Jobbade senast</strong></td>
			<td><?php loadLastWorked() ?></td>
		</tr>
	</table>

		<h3>Kontaktinformation</h3>
		<table class="basic-table">
			<tr>
				<td><strong>Mailadress</strong></td>
				<td><?php echo $profileMail; ?></td>
			</tr>
			<tr>
				<td><strong>Mobilnummer</strong></td>
				<td><?php echo $profileNumber; ?></td>
			</tr>
			<tr>
				<td><strong>Adress</strong></td>
				<td><?php echo $address; ?></td>
			</tr>
		</table>
	</div> <!-- .white-box -->
</div> <!-- col-sm-6 -->
	<div class="col-sm-6">
		<div class="white-box">
			<h3>Är med i följande lag</h3>
			<div class="list-group">
			<?php loadGroups(); ?>
			</div>
		</div>
	</div>
</div> <!-- .row -->
<div class="row">
	<?php addToGroup(); ?>
	<?php removeFromGroup(); ?>
</div> <!-- .row -->