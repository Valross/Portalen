<?php
include_once('php/DBQuery.php');

//Current variables
//Separate file? Combined with php/pages/profile.php?
$result = DBQuery::sql("SELECT mail FROM user WHERE id = '$_SESSION[user_id]' AND mail  IS NOT NULL");
if(count($result) == 1)
	$profileMail = $result[0]["mail"];
else
	$profileMail = "";

$result = DBQuery::sql("SELECT phone_number FROM user WHERE id = '$_SESSION[user_id]' AND phone_number IS NOT NULL");
if(count($result) == 1)
	$profileNumber = $result[0]["phone_number"];
else
	$profileNumber = "";

$result = DBQuery::sql("SELECT ssn FROM user WHERE id = '$_SESSION[user_id]' AND ssn IS NOT NULL");
if(count($result) == 1)
	$profileSsn = $result[0]["ssn"];
else
	$profileSsn = "";

$result = DBQuery::sql("SELECT name FROM user WHERE id = '$_SESSION[user_id]' AND name IS NOT NULL");
if(count($result) == 1)
	$profileName = $result[0]["name"];
else
	$profileName = "";

$result = DBQuery::sql("SELECT last_name FROM user WHERE id = '$_SESSION[user_id]' AND last_name IS NOT NULL");
if(count($result) == 1)
	$profileLastName = $result[0]["last_name"];
else
	$profileLastName = "";

$result = DBQuery::sql("SELECT description FROM user WHERE id = '$_SESSION[user_id]' AND description IS NOT NULL");
if(count($result) == 1)
	$profileDescription = $result[0]["description"];
else
	$profileDescription = "";

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
