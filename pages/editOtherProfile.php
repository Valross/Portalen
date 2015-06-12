<?php
	if(checkAdminAccess() <= 1)
	{
?>
<div class="row">
	<div class="col-sm-8">
		<div class="page-header">
		<h1>
		<span class="fa fa-cog fa-fw fa-lg"></span>
		 Inställningar för 
		 <a href="?page=userProfile&id=<?php echo $user_id; ?>"><?php echo loadNameFromUser($user_id); ?></a>
		</h1>
		</div>
	</div>
<?php
	if(checkAdminAccess() < 1)
	{
?>
	<div class="col-sm-4 page-header-right text-right">
		<a href="?page=removeUser&user_id=<?php echo $user_id; ?>" class="btn btn-page-header" 
			onclick="return confirm('Är du säker? Det går inte att ångra sig.')">
		<i class="fa fa-user-times fa-lg fa-margin-right"></i> Avsluta medlemskap
		</a>
	</div>
<?php
	}
?>
</div> <!-- .row -->

<div class="row">

<div class="col-sm-6">
	<div class="white-box">
		<h3>Redigera profil</h3>
	<form action="" method="post">
		<label for="name">Förnamn</label>
		<input type="text" value="<?php echo $profileName; ?>" name="name" id="name" pattern="[A-Za-z]{1,15}">
		<label for="last_name">Efternamn</label>
		<input type="text" value="<?php echo $profileLastName; ?>" name="last_name" id="last_name" pattern="[A-Za-z]{1,25}">
	  	<label for="ssn">Personnummer</label>
	  	<input type="text" value="<?php echo $profileSsn; ?>" placeholder="ååååmmddxxxx" name="ssn" id="ssn" pattern="[0-9]{12,12}$"
	  		maxlength="12" required title="12 siffror">
	  	<label for="phone_number">Mobilnummer</label>
	  	<input type="text" value="<?php echo $profileNumber; ?>" name="phone_number" id="phone_number" maxlength="10" pattern=".{10,10}" required title="10 siffror">
		<label for="bank_account">Kontonummer</label>
		<input type="text" value="<?php echo $profileBankAccount; ?>" name="bank_account" id="bank_account">
		<label for="mail">Mailadress</label>
		<input type="text" value="<?php echo $profileMail; ?>" placeholder="jambo007@student.liu.se" name="mail" id="mail" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$">
		<label for="mail">Adress</label>
		<input type="text" value="<?php echo $profileAddress; ?>" name="address" id="address">
		<label for="mail">Utbildning</label>
		<input type="text" value="<?php echo $profileMajor; ?>" placeholder="MT" name="major" id="major">
		<label for="mail">Specialkost</label>
		<input type="text" value="<?php echo $profileSpecialFood; ?>" placeholder="Tomat, katt" name="special_food" id="special_food">
		
		<label for="description">Presentation</label>
		<textarea rows="5" cols="50" value="" name="description" id="description" maxlength="150" class="bottom-border"><?php echo $profileDescription; ?></textarea>
			
		<input type="submit" name="changeInfo" value="Uppdatera profil">
	</form>
	</div> <!-- .white-box -->
</div>
<div class="col-sm-6">
	<div class="white-box">
		<h3>Ändra visningsbild</h3>
			<?php echo loadAvatarFromUser($user_id, 100); ?>

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
<?php
	}
	else
	{
		?>
			<script>
				window.location = "?page=start";
				alert("Sluta försöka hacka sidan!")
			</script>
		<?php
	}
?>