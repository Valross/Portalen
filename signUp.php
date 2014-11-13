<?php
//include_once('php/DBQuery.php');
  	
	//set up mySQLi connection here
	
	//open								//"poralen","portalen"
	$mysql = mysqli_connect("localhost","root","bajs","portalen") or die("Unable to connect to MySQL");
	mysqli_set_charset($mysql,'utf8');

	$sql;
	$result = mysqli_query($mysql,$sql);
	$lastId = mysqli_insert_id($mysql);

	//close connection here?	

	$rows = array();
		if(strtolower(substr($sql,0,6)) == 'select'){
			while($row = mysqli_fetch_array($result)){
				array_push($rows,$row);
			}
			return $rows;
		}



	//get team id's and names from database
	//put in checkbox
	//...


  	if(isset($_POST['submit'])){
	  	$firstName = mysqli_real_escape_string($_POST['firstName']);
		$lastName = mysqli_real_escape_string($_POST['lastName']);
		$liuId = mysqli_real_escape_string($_POST['liuId']);
		$mail = mysqli_real_escape_string($_POST['mail']);
		$ssn = mysqli_real_escape_string($_POST['ssn']);

		//test accessing checkbox
		$aTeam = $_POST['team'];
		if(empty($aTeam)){
			echo("Inga lag valda");
		}
		else{
			$n = count($aTeam);
			echo("$n lag valda: ");
			
			for($i=0; $i < $n; $i++){
				echo htmlspecialchars($aTeam[$i]). " ";
			}
		}
	}

	mysqli_close($mysql);
?>


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
		<form action="action="" method="post"> <!--action="php/pages/reviseApplications.php" ??-->
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
