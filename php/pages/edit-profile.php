<?php
include_once('php/DBQuery.php');

if(isset($_POST['submit'])) {


	$userName = $_POST['user_name']; //TO DO: some way to access user's user_name without user input
	$ssn = $_POST['ssn'];
	$mail = $_POST['mail'];
	$name = $_POST['name'];
	$lastName = $_POST['last_name'];


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

	//control
	//echo ('queryString2: ' . $queryString);

	DBQuery::sql("UPDATE user
				  SET $queryString
				  WHERE user_name='$userName'");

		//relocate
		?>
		<script>
			window.location = "?page=edit-profile";
			alert("Ditt nya liv är sparat!") //TO DO: Proper user feedback
		</script>
		<?php
}
	
?>