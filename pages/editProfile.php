	<div class="col-sm-12">
		<div class="page-header">
			<h1>Redigera profil</h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
	
<div class="col-sm-5">
	<form action="" method="post">
	    <p>Fyll i de fält du vill uppdatera</p>
	    <p>Mobilnummer: <input type="text" placeholder="<?php echo $profileNumber; ?>" name="phone_number" maxlength="15" /></p>
	    <p>Personnummer: <input type="text" placeholder="<?php echo $profileSsn; ?>" name="ssn" maxlength="10" /></p>
		<p>Mail: <input type="text" placeholder="<?php echo $profileMail; ?>" name="mail" /></p>
		<p>Förnamn: <input type="text" placeholder="<?php echo $profileName; ?>" name="name" /></p>
		<p>Efternamn: <input type="text" placeholder="<?php echo $profileLastName; ?>" name="last_name" /></p>
		<p>Beskrivning: <textarea rows="4" cols="50" placeholder="<?php echo $profileDescription; ?>" name="description" maxlength="150"></textarea></p>
		<p><input type="submit" name="submit" value="Spara" /></p>
	</form>
</div>
