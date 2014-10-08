<?php
include_once('php/DBQuery.php');

if(isset($_POST['submit'])) {
	$phoneNumber = $_POST['phone_number'];
	$ssn = $_POST['ssn'];
	$mail = $_POST['mail'];
	$name = $_POST['name'];
	$lastName = $_POST['last_name'];
	$description = $_POST['description'];

	//Initiate string for SET statement in SQL query
	$queryString = "";

	if($phoneNumber != '') {
		$queryString = $queryString . "phone_number='$phoneNumber'";
	}

	if ($ssn != '') {
		if ($queryString != '')
			$queryString = $queryString . ", ssn='$ssn'";
		else
			$queryString = $queryString . "ssn='$ssn'";
	}

	if ($mail != '') {
		if ($queryString != '')
			$queryString = $queryString . ", mail='$mail'";
		else
			$queryString = $queryString . "mail='$mail'";
	}

	if ($name != '') {
		if ($queryString != '')
			$queryString = $queryString . ", name='$name'";
		else
			$queryString = $queryString . "name='$name'";
	}

	if ($lastName != '') {
		if ($queryString != '')
			$queryString = $queryString . ", last_name='$lastName'";
		else
			$queryString = $queryString . "last_name='$lastName'";
	}

	if ($description != '') {
		if ($queryString != '')
			$queryString = $queryString . ", description='$description'";
		else
			$queryString = $queryString . "description='$description'";
	}

	//check string
	//echo ('queryString2: ' . $queryString);

	DBQuery::sql("UPDATE user
				  SET $queryString
				  WHERE id='$_SESSION[user_id]'");
		
		//relocate
		?>
		<script>
			window.location = "?page=editProfile";		//TO DO: hard code url
			alert("Ditt nya liv är sparat!") 	//TO DO: Proper user feedback
		</script>
		<?php
		
}
	
?>
