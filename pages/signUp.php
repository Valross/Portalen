<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Ansökning</title>
 	</head>
 	<body>

	<h1>Ansök!</h1>
	<p>Fyll i formuläret så kontaktar vi dig när det finns plats bland arbetslagen!</p>


	<div class="col-sm-5">
		<form action="" method="post">
		 	<!--<h2></h2>-->
		 	<label for="firstName">Förnamn</label>
				<input type="text" name="firstName" maxlength="20" /><br>
		 	<label for="lastName">Efternamn</label>
				<input type="text" name="lastName" maxlength="20" /><br>
			<label for="liuId">Liu-id</label>
				<input type="text" name="liuId" maxlength="20" /><br>
			<label for="mail">Mailadress</label>
				<input type="text" name="mail" maxlength="20" /><br>
			<label for="ssn">Personnr</label>
				<input type="text" name="ssn" maxlength="20" /><br>
			<h2>Vilka lag vill du söka?</h2>
			<input type="checkbox" name="team" value="webb">Webblaget!<br>
			<input type="checkbox" name="team" value="bar">Barlaget<br>
			<input type="checkbox" name="team" value="kock">Kocklaget<br>
			<input type="checkbox" name="team" value="vard">Värdlaget<br>
			<input type="checkbox" name="team" value="servering">Serveringslaget & Hovmästarlaget<br>
			<input type="checkbox" name="team" value="lagx">DJ-laget<br>
			<input type="checkbox" name="team" value="ljud">Ljud- och ljusgruppen<br>
			<input type="checkbox" name="team" value="mf">Marknadsföringslaget<br>
			<input type="checkbox" name="team" value="event">Eventlaget<br>
			<p><input type="submit" name="submit" value="Skicka" /></p>
		</form>
	</div>
	</body>
</html>
