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
			<label for="mail">Mailadress</label>
				<input type="text" name="mail" maxlength="30" /><br>
			<label for="ssn">Personnr</label>
				<input type="text" name="ssn" maxlength="13" /><br>
			<h2>Vilka lag vill du söka?</h2>
			<input type="checkbox" name="team[]" value="<?php echo $webbId;  ?>" > Webblaget <br>
			<input type="checkbox" name="team[]" value="<?php echo $barId;   ?>" > Barlaget <br>
			<input type="checkbox" name="team[]" value="<?php echo $kockId;  ?>" > Kocklaget <br>
			<input type="checkbox" name="team[]" value="<?php echo $vardId;  ?>" > Värdlaget <br>
			<input type="checkbox" name="team[]" value="<?php echo $servId;  ?>" > Serveringslaget & Hovmästarlaget <br>
			<input type="checkbox" name="team[]" value="<?php echo $djId;    ?>" > DJ-laget <br>
			<input type="checkbox" name="team[]" value="<?php echo $ljudId;  ?>" > Ljud- och ljusgruppen <br>
			<input type="checkbox" name="team[]" value="<?php echo $mfId;    ?>" > Marknadsföringslaget <br>
			<input type="checkbox" name="team[]" value="<?php echo $eventId; ?>" > Eventlaget <br>
			<p><input type="submit" name="submit" value="Skicka" /></p>
		</form>
	</div>
	</body>
</html>
