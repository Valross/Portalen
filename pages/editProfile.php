<div class="row">
	<div class="col-sm-7">
		<div class="page-header">
		<h1>
		<span class="fa fa-cog fa-fw fa-lg"></span>
		 Inställningar 
		</h1>
		</div>
	</div>
	<div class="col-sm-5 page-header-right text-right">
		<a href="?page=removeUser&user_id=<?php echo $user_id; ?>" class="btn btn-page-header" 
				onclick="return confirm('Är du säker? Det går inte att ångra sig.')">
		<i class="fa fa-user-times fa-lg fa-margin-right"></i> Avsluta medlemskap
		</a>
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
	  	<input type="text" value="<?php echo $profileSsn; ?>" placeholder="ååååmmddxxxx" name="ssn" id="ssn" maxlength="12" pattern="[0-9]{12,12}$" required title="12 siffror" readonly>
	  	<label for="phone_number">Mobilnummer</label>
	  	<input type="text" value="<?php echo $profileNumber; ?>" name="phone_number" id="phone_number" maxlength="10" pattern=".{10,10}" required title="10 siffror">
		<label for="bank_account">Kontonummer</label>
		<input type="text" value="<?php echo $profileBankAccount; ?>" name="bank_account" id="bank_account" required>
		<label for="mail">Mailadress</label>
		<input type="text" value="<?php echo $profileMail; ?>" name="mail" id="mail" required>
		<label for="adress">Adress</label>
		<input type="text" value="<?php echo $profileAddress; ?>" name="address" id="address" required>
		<label for="zip">Postkod</label>
		<input type="text" value="<?php echo $profileZip; ?>" name="zip" id="zip" required>
		<label for="major">Utbildning</label>
		<input type="text" value="<?php echo $profileMajor; ?>" name="major" id="major" required>
		<label for="special_food">Specialkost</label>
		<input type="text" value="<?php echo $profileSpecialFood; ?>" name="special_food" id="special_food">
		
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

<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Tryck på mig
</button>
</div> <!-- .row -->


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Hejhå</h4>
      </div>
      <div class="modal-body">
       <p>Bootstrap har en inbyggd "Modal". All kod för den här modalen ligger längst ner i editProfile.php.<br><br> Det är även möjligt att få upp en modal direkt när man laddar sidan. Står i dokumentationen hur det fungerar. Scrolla upp till Overview -> Events: 
		   <a href="http://getbootstrap.com/javascript/#modals" target="_blank">http://getbootstrap.com/javascript/#modals</a>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>