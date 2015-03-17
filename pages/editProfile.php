<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
		<h1>
		<span class="fa fa-cog fa-fw fa-lg"></span>
		 Inställningar 
		</h1>
		</div>
	</div>
	<div class="col-sm-4 page-header-right text-right">
		<button type="button" class="btn btn-page-header"><i class="fa fa-trash fa-lg fa-margin-right"></i> Avsluta medlemskap</button>
	</div>
</div> <!-- .row -->

<div class="row">

<div class="col-sm-6">
	<div class="white-box">
		<h3>Redigera profil</h3>
	<form action="" method="post">
		<label for="name">Förnamn (Går inte att ändra)</label>
		<input type="text" value="<?php echo $profileName; ?>" name="name" id="name" readonly>
		<label for="last_name">Efternamn (Går inte att ändra)</label>
		<input type="text" value="<?php echo $profileLastName; ?>" name="last_name" id="last_name" readonly>
	  	<label for="ssn">Personnummer (Går inte att ändra)</label>
	  	<input type="text" value="<?php echo $profileSsn; ?>" placeholder="ååmmddxxxx" name="ssn" id="ssn" maxlength="10" readonly>
	  	<label for="phone_number">Mobilnummer</label>
	  	<input type="text" value="<?php echo $profileNumber; ?>" name="phone_number" id="phone_number" maxlength="15">
		<label for="mail">Mailadress</label>
		<input type="text" value="<?php echo $profileMail; ?>" name="mail" id="mail">
		<label for="mail">Adress</label>
		<input type="text" value="<?php echo $profileAddress; ?>" name="address" id="address">
		<label for="mail">Utbildning</label>
		<input type="text" value="<?php echo $profileMajor; ?>" name="major" id="major">
		
		<label for="description">Presentation</label>
		<textarea rows="5" cols="50" value="" name="description" id="description" maxlength="150" class="bottom-border"><?php echo $profileDescription; ?></textarea>
			
		<input type="submit" name="changeInfo" value="Uppdatera profil">
	</form>
	</div> <!-- .white-box -->
</div>
<div class="col-sm-6">
	<div class="white-box">
		<h3>Ändra visningsbild</h3>
			<img src="<?php echo loadAvatar(); ?>" class="img-circle" style="float: left; margin: 0 20px;" width="100" height="100">

<div style="float: left; margin-left: 20px;">
	<form action="" method="post" enctype="multipart/form-data">
		<h4>Välj ny visningsbild</h4>
    	<input type="file" name="fileToUpload" id="fileToUpload" style="margin-left: 20px;">
    	<input type="submit" value="Ladda upp" name="UploadAvatar">
	</form>
</div>
	

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