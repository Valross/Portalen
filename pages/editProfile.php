	<div class="row">
		<div class="col-sm-12">
			<div class="page-header">
			<h1>Inställningar</h1>
			<button type="button" class="btn btn-default">Avsluta medlemskap (ska fixa denna)</button>
			</div>
		</div>
	</div> <!-- .row -->

<div class="row">

<div class="col-sm-6">
	<div class="white-box">
		<h3>Redigera profil</h3>
	<form action="" method="post">
		<label for="name">Förnamn</label>
		<input type="text" value="<?php echo $profileName; ?>" name="name" id="name">
		<label for="last_name">Efternamn</label>
		<input type="text" value="<?php echo $profileLastName; ?>" name="last_name" id="last_name">
	  	<label for="ssn">Personnummer</label>
	  	<input type="text" value="<?php echo $profileSsn; ?>" placeholder="ååååmmdd-xxxx" name="ssn" id="ssn" maxlength="10">
	  	<label for="phone_number">Mobilnummer</label>
	  	<input type="text" value="<?php echo $profileNumber; ?>" name="phone_number" id="phone_number" maxlength="15">
		<label for="mail">Mailadress</label>
		<input type="text" value="<?php echo $profileMail; ?>" name="mail" id="mail">
		
		<label for="description">Presentation</label>
		<textarea rows="5" cols="50" value="<?php echo $profileDescription; ?>" name="description" id="description" maxlength="150" class="bottom-border"></textarea>
			
		<input type="submit" name="changeInfo" value="Uppdatera profil">
	</form>
	</div> <!-- .white-box -->
</div>
<div class="col-sm-6">
	<div class="white-box">
		<h3>Ändra visningsbild</h3>
	<form action="" method="post">
		<label for="old_password">Nuvarande lösenord</label>
		<input type="password" name="old_password" id="old_password">
		<input type="submit" name="changePass" value="Ladda upp">
	</form>
	</div> <!-- .white-box -->
	<div class="white-box">
		<h3>Ändra lösenord</h3>
	<form action="" method="post">
		<label for="old_password">Nuvarande lösenord</label>
		<input type="password" name="old_password" id="old_password">
		<label for="password">Nytt lösenord</label>
		<input type="password" name="password" id="password">
		<label for="confirmed_password">Bekräfta nytt lösenord</label>
		<input type="password" name="confirmed_password" id="confirmed_password" class="bottom-border">
		<input type="submit" name="changePass" value="Uppdatera lösenord">
	</form>
	</div> <!-- .white-box -->
</div>
</div> <!-- .row -->