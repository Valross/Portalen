<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
		<img src="<?php echo loadAvatar(); ?>" width="100" height="100" class="page-header-img">
			<h1 class="header-img"><?php echo $_SESSION['name'].' '.$_SESSION['last_name']; ?></h1>
		</div>
	</div>
	<div class="col-sm-4 page-header-right text-right">
		<button type="button" class="btn btn-page-header header-img"><i class="fa fa-envelope-o fa-margin-right"></i> Skicka meddelande</button>
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
			<td>gammal</td>
		</tr>
		<tr>
			<td><strong>Utbildning</strong></td>
			<td>Grafisk design och kommunikation lol</td>
		</tr>
		<tr>
			<td><strong>Personal sedan</strong></td>
			<td><?php echo $profileCreation; ?></td>
		</tr>
		<tr>
			<td><strong>Senast inloggad</strong></td>
			<td>ganska nyligen</td>
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
				<td></td>
			</tr>
			<tr>
				<td><strong>Hemsida</strong></td>
				<td></td>
			</tr>
		</table>
	</div> <!-- .white-box -->
</div> <!-- col-sm-6 -->
	<div class="col-sm-6">
		<div class="white-box">
			<h3>Är med i följande lag</h3>
		Cool lista
		</div>
	</div>
</div> <!-- .row -->