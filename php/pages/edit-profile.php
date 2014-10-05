<?php
include_once('php/DBQuery.php');

if(isset($_POST['submit'])) {

	$userName = $_POST['user_name']; //TO DO: some way to access user's user_name without user input
	$ssn = $_POST['ssn'];
	$mail = $_POST['mail'];
	$name = $_POST['name'];
	$lastName = $_POST['last_name'];
	


	// if fields not empty, update values
	if($userName != '' && $ssn != '' && $mail != '' && $name != '' && $lastName != ''){
	DBQuery::sql("UPDATE user
				  SET ssn='$ssn', mail='$mail', name='$name', last_name='$lastName'
				  WHERE user_name='$userName'");

		//relocate
		?>
		<script>
			window.location = "?page=edit-profile";
			alert("")
		</script>
		<?php
	}
	
	else{
		?>
		<script>
		//TO DO: Real validation message as user feedback
		alert("error: empty fields","");
		</script>
		<?php
	}
	
}
?>