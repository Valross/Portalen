<?php
    session_start();
    include_once('php/DBConnect.php');
    include_once('php/DBQuery.php');

    //open mysqli connection			"portalen", "portalen"
    $mysql = mysqli_connect("localhost","portalen","portalen","portalen") or die("Unable to connect to MySQL");
    mysqli_set_charset($mysql,'utf8');

    //get team id's and names from database
    //TO DO?   else statements accounting for if count($result) != 1
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

    /**** submit button ****/
    if(isset($_POST['submit'])){
        $firstName = DBQuery::safeString($_POST['firstName']);
        $lastName = DBQuery::safeString($_POST['lastName']);
        $mail = DBQuery::safeString($_POST['mail']);
        $ssn = DBQuery::safeString($_POST['ssn']);

        //validate fields
        if($firstName != '' && $lastName != '' && $mail != '' && $ssn != ''){

            //validate checkbox
            if(isset($_POST['team'])){
                $teams = $_POST['team'];
                $teamCounter = count($teams);

                //INSERT INFO INTO DB
                DBQuery::sql("INSERT INTO application (name, last_name, mail, ssn)
                			  VALUES ('$firstName', '$lastName', '$mail', '$ssn')"); //group id?

                //INSERT TEAMS INTO DB
                $appId = DBQuery::$lastId;
                // echo "lag: ";
                for($i=0; $i < $teamCounter; $i++){
                    // echo $teams[$i] . " ";
                    DBQuery::sql("INSERT INTO application_group (group_id, application_id)
                                  VALUES ('$teams[$i]', '$appId')");
                }

            }
            else 	//no teams selected
                echo("Du måste fylla i några lag");
        }
        else
          echo("Alla fält måste fyllas i!");
    }
    
    mysqli_close($mysql);

?>

<!DOCTYPE html>
<html lang="sv-SE">
<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Kårhuset Trappan: Ansökan för jobb</title>
		<link href='http://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="css/signup.css">
</head>
<body>


	<div class="signup-container">
		<div class="top-border">
			<div class="color first"></div>
			<div class="color third"></div>
		</div>
		<div class="logotype">
			<h1>Ansökan för jobb på Trappan</h1>
			<p style="font-size: 14px; font-size: 1.4rem;">Fyll i formuläret så kontaktar vi dig när det finns plats bland arbetslagen!</p>
		</div>
		
		
		
		<form action="" method="post">
			<div class="two-column">
		 	<label for="firstName">Förnamn</label>
				<input type="text" name="firstName" id="firstName" maxlength="15" />
		 	<label for="lastName">Efternamn</label>
				<input type="text" name="lastName" id="lastName" maxlength="15" />
			<label for="mail">Mailadress</label>
				<input type="text" name="mail" id="mail" maxlength="30" />
			<label for="ssn">Personnummer</label>
				<input type="text" name="ssn" id="ssn" placeholder="ååååmmdd-xxxx" maxlength="13" />
			</div>
			<div class="two-column-padding">
			<h2>Vilka lag vill du söka?</h2>
			
			
			<div class="fifty-percent-width">
			<input type="checkbox" name="team[]" id="bar" value="<?php echo $barId;   ?>" > 			
			<label for="bar">Bar</label>
			</div>
			<div class="fifty-percent-width">
			<input type="checkbox" name="team[]" id="marknadsforing" value="<?php echo $mfId;    ?>" >
			<label for="marknadsforing">Marknadsföring</label>
			</div>
			<div class="fifty-percent-width">
			<input type="checkbox" name="team[]" id="event" value="<?php echo $eventId; ?>" >
			<label for="event">Event</label>
			</div>
			<div class="fifty-percent-width">
			<input type="checkbox" name="team[]" id="servering" value="<?php echo $servId;  ?>" > 
			<label for="servering">Servering</label>
			</div>
			<div class="fifty-percent-width">
			<input type="checkbox" name="team[]" id="dj" value="<?php echo $djId;    ?>" >
			<label for="dj">DJ</label>
			</div>
			<div class="fifty-percent-width">
			<input type="checkbox" name="team[]" id="vard" value="<?php echo $vardId;  ?>" > 
			<label for="vard">Värd</label>
			</div>
			<div class="fifty-percent-width">
			<input type="checkbox" name="team[]" id="kock" value="<?php echo $kockId;  ?>" > 			
			<label for="kock">Kock</label>
			</div>
			<div class="fifty-percent-width">
			<input type="checkbox" name="team[]" id="webb" value="<?php echo $webbId;  ?>" >
			<label for="webb">Webb</label>
			</div>
			<div class="fifty-percent-width">
			<input type="checkbox" name="team[]" id="ljud" value="<?php echo $ljudId;  ?>" >
			<label for="ljud">Ljud och ljus</label>
			</div>
		
			
			</div>
			<input class="send-btn primary" type="submit" name="submit" value="SKICKA" />
			
		</form>
		
	</div>
	
</body>
</html>
