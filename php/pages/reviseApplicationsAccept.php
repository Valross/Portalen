<?php
include_once('php/DBQuery.php');

if(isset($_GET['name']) && isset($_GET['lastName']) && isset($_GET['ssn']) && isset($_GET['mail']) && isset($_GET['id'])){
	$name = $_GET['name'];
	$lastName = $_GET['lastName'];
	$ssn= $_GET['ssn'];
	$mail= $_GET['mail'];
	$appId=$_GET['id'];

	// echo "DEBUG name = " . $name . ", lastName = " . $lastName . ", ssn = " . $ssn . ", mail = " . $mail;
	echo "ID = " . $appId;

	//add applicant to user
	$tempPassword = "trappan";
	DBQuery::sql("INSERT INTO user (user_name, mail, ssn, password, name, last_name)
						VALUES ('$mail', '$mail', '$ssn', '$tempPassword', '$name', '$lastName')");

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