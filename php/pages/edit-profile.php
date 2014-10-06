<?php
include_once('php/DBQuery.php');

if(isset($_POST['submit'])) {


	$userId = $_SESSION['user_id'];
	$ssn = $_POST['ssn'];
	$mail = $_POST['mail'];
	$name = $_POST['name'];
	$lastName = $_POST['last_name'];

	//Initiate string for SET statement in SQL query
	$queryString = "";

	if ($ssn != '') {
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

	//check string
	//echo ('queryString2: ' . $queryString);

	DBQuery::sql("UPDATE user
				  SET $queryString
				  WHERE id='$userId'");
		
		//relocate
		?>
		<script>
			window.location = "?page=edit-profile";		//TO DO: hard code url
			alert("Ditt nya liv är sparat!") 	//TO DO: Proper user feedback
		</script>
		<?php
		
}
	
?>