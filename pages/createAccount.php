<?php
	if(checkAdminAccess() <= 1)
	{
?>
<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1><span class="fa fa-user-plus fa-fw fa-lg"></span> Skapa nytt konto</h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
<div class="col-sm-6">
	<div class="white-box">
	<form action="" method="post">
		<label for="user_name">Användarnamn</label>
		<input type="text" name="user_name" id="user_name">
		<label for="password">Lösenord</label>
		<input type="password" name="password" id="password">
		<label for="ssn">Personnummer</label>
		<input type="text" name="ssn" id="ssn" placeholder="ååååmmddxxxx" maxlength="12" pattern=".{12,12}" required title="12 siffror" />
		<label for="mail">Mailadress</label>
		<input type="text" name="mail" id="mail">
		<label for="name">Förnamn</label>
		<input type="text" name="name" id="name">
		<label for="last_name">Efternamn</label>
		<input type="text" name="last_name" id="last_name" class="border-bottom">
		<input type="submit" name="submit" value="Skapa konto">
	</form>
	</div> <!-- .white-box -->
</div>
</div>
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