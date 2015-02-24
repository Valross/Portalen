<?php
//den här filen lägger till en användare i databasen

include_once('php/DBQuery.php');

if(isset($_GET['name']) && isset($_GET['lastName']) && isset($_GET['ssn']) && isset($_GET['mail'])){
	$name = $_GET['name'];
	$lastName = $_GET['lastName'];
	$ssn= $_GET['ssn'];
	$mail= $_GET['mail'];

	echo "DEBUG name = " . $name . ", lastName = " . $lastName . ", ssn = " . $ssn . ", mail = " . $mail;

	$tempPassword = "trappan";
	DBQuery::sql("INSERT INTO user (user_name, mail, ssn, password, name, last_name)
						VALUES ('$mail', '$mail', '$ssn', '$tempPassword', '$name', '$lastName')");

	?>
		<script>
			// window.location = "?page=reviseApplications";
			alert("Inlagd!")
		</script>
	<?php
}
else{
	?>
		<script>
			window.location = "?page=reviseApplications";
			alert("Något gick fel!")
		</script>
	<?php
}

?>