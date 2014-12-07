<?php
  	session_start();
  	include_once('php/DBConnect.php');
  	include_once('php/DBQuery.php');

	//open mysqli connection			"portalen", "portalen"
  	$mysql = mysqli_connect("localhost","portalen","portalen","portalen") or die("Unable to connect to MySQL");
	mysqli_set_charset($mysql,'utf8');

	//get team id's and names from database
  //TO DO   else statements accounting for if count($result) != 1
  $result = DBQuery::sql("SELECT name FROM work_group WHERE id = '2'");
    $webbName = $result[0]["name"];
    $webbId = 2;

  $result = DBQuery::sql("SELECT name FROM work_group WHERE id = '3'");
    $kockName = $result[0]["name"];
    $kockId = 3;

  $result = DBQuery::sql("SELECT name FROM work_group WHERE id = '4'");
    $barName = $result[0]["name"];
    $barId = 4;

  $result = DBQuery::sql("SELECT name FROM work_group WHERE id = '5'");
    $djName = $result[0]["name"];
    $djId = 5;

  $result = DBQuery::sql("SELECT name FROM work_group WHERE id = '6'");
    $vardName = $result[0]["name"];
    $vardId = 6;

  $result = DBQuery::sql("SELECT name FROM work_group WHERE id = '8'");
    $eventName = $result[0]["name"];
    $eventId = 8;

  $result = DBQuery::sql("SELECT name FROM work_group WHERE id = '9'");
    $mfName = $result[0]["name"];
    $mfId = 9;

  $result = DBQuery::sql("SELECT name FROM work_group WHERE id = '10'");
    $ljudName = $result[0]["name"];
    $ljudId = 10;

  $result = DBQuery::sql("SELECT name FROM work_group WHERE id = '11'");
    $servName = $result[0]["name"];
    $servId = 11;

  	if(isset($_POST['submit'])){
	  	$firstName = DBQuery::safeString($_POST['firstName']);
		$lastName = DBQuery::safeString($_POST['lastName']);
		//$liuId = DBQuery::safeString($_POST['liuId']);
		$ssn = DBQuery::safeString($_POST['ssn']);
		$mail = DBQuery::safeString($_POST['mail']);

		//check
		//echo($firstName . " " . $lastName . " " . $liuId);


		if(isset($_POST['team'])){		//teams selected

			// test accessing checkbox
			$aTeam = $_POST['team'];
			if(empty($aTeam)){
				echo("test -- Inga lag valda");
			}
			else{
				$n = count($aTeam);
				echo("test -- $n lag valda: ");

				for($i=0; $i < $n; $i++){
					echo htmlspecialchars($aTeam[$i]). " ";
				}
			}


			//INSERT INTO DB
			if($firstName != '' && $lastName != '' && $mail != '' && $ssn != ''){
				DBQuery::sql("INSERT INTO application (name, last_name,  ssn, mail, group_id)
								VALUES ('$firstName', '$lastName', '$mail', '$ssn', 2)");
			}
			else
				echo("-Fel: Alla fält måste fyllas i!");
		} //team

		else 	//no teams selected
			echo("Du måste fylla i några lag");
	} //submit


	//close connection
	mysqli_close($mysql);

?>


<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Ansökning</title>
 	</head>
 	<body>

	<h1>Jobba på trappan!</h1>
	<p>Fyll i formuläret så kontaktar vi dig när det finns plats bland arbetslagen!</p>



	<div class="col-sm-5">
		<form action="" method="post">
		 	<!--<h2></h2>-->
		 	<label for="firstName">Förnamn</label>
				<input type="text" name="firstName" maxlength="15" /><br>
		 	<label for="lastName">Efternamn</label>
				<input type="text" name="lastName" maxlength="15" /><br>
			<!-- <label for="liuId">Liu-id</label>
				<input type="text" name="liuId" maxlength="8" /><br> -->
			<label for="mail">Mailadress</label>
				<input type="text" name="mail" maxlength="30" /><br>
			<label for="ssn">Personnr</label>
				<input type="text" name="ssn" maxlength="13" /><br>
			<h2>Vilka lag vill du söka?</h2>
			<input type="checkbox" name="team[]" value="<?php echo $webbId;  ?>" >Webblaget<br>
			<input type="checkbox" name="team[]" value="<?php echo $barId;   ?>" >Barlaget<br>
			<input type="checkbox" name="team[]" value="<?php echo $kockId;  ?>" >Kocklaget<br>
			<input type="checkbox" name="team[]" value="<?php echo $vardId;  ?>" >Värdlaget<br>
			<input type="checkbox" name="team[]" value="<?php echo $servId;  ?>" >Serveringslaget & Hovmästarlaget<br>
			<input type="checkbox" name="team[]" value="<?php echo $djId;    ?>" >DJ-laget<br>
			<input type="checkbox" name="team[]" value="<?php echo $ljudId;  ?>" >Ljud- och ljusgruppen<br>
			<input type="checkbox" name="team[]" value="<?php echo $mfId;    ?>" >Marknadsföringslaget<br>
			<input type="checkbox" name="team[]" value="<?php echo $eventId; ?>" >Eventlaget<br>
			<p><input type="submit" name="submit" value="Skicka" /></p>
		</form>
	</div>
	</body>
</html>
