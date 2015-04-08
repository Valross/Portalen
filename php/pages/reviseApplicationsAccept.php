<?php
include_once('php/DBQuery.php');

if(isset($_GET['name']) && isset($_GET['lastName']) && isset($_GET['ssn']) && isset($_GET['mail']) && isset($_GET['id']) && checkAdminAccess() == 1){
	$name = $_GET['name'];
	$lastName = $_GET['lastName'];
	$ssn= $_GET['ssn'];
	$mail= $_GET['mail'];
	$appId=$_GET['id'];

	$dates = new DateTime;
	$dates->setTimezone(new DateTimeZone('Europe/Stockholm'));
	$date = $dates->format('Y-m-d');

	// send confirmation mail
	$msg = "Hej, $name \n Grattis osv boka upp dig och kbk #yolo";
	mail($mail, "Jobba på trappaaan", $msg);

	//add applicant to user
	$tempPassword = "trappan";
	DBQuery::sql("INSERT INTO user (user_name, mail, ssn, password, name, last_name)
						VALUES ('$mail', '$mail', '$ssn', '$tempPassword', '$name', '$lastName')");

	$user = DBQuery::sql("SELECT id FROM user
							ORDER BY id DESC");

	$user_id = $user[0]['id'];

	DBQuery::sql("INSERT INTO group_member (group_id, user_id, member_since)
						VALUES ('13', '$user_id', '$date')"); //Lägg till i Alla

	DBQuery::sql("INSERT INTO group_member (group_id, user_id, member_since)
						VALUES ('15', '$user_id', '$date')"); //Lägg till i Bar - Nybyggare

	DBQuery::sql("INSERT INTO group_member (group_id, user_id, member_since)
						VALUES ('16', '$user_id', '$date')"); //Lägg till i Kock - Nybyggare

	DBQuery::sql("INSERT INTO group_member (group_id, user_id, member_since)
						VALUES ('17', '$user_id', '$date')"); //Lägg till i Servering - Nybyggare

	DBQuery::sql("INSERT INTO group_member (group_id, user_id, member_since)
						VALUES ('25', '$user_id', '$date')"); //Lägg till i Värd - Nybyggare

	//remove applicant from applications
	DBQuery::sql("DELETE FROM application WHERE id='$appId'");
	DBQuery::sql("DELETE FROM application_group WHERE application_id='$appId'");

	?>
		<script>
			window.location = "?page=reviseApplications";
			alert("Inlagd!")
		</script>
	<?php
}
else{
	?>
		<script>
			window.location = "?page=reviseApplications";
			alert("Något gick fel!");
		</script>
	<?php
}

?>