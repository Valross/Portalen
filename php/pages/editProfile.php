<?php
include_once('php/DBQuery.php');

//Current variables
//Separate file? Combine with part of php/pages/profile.php?
$result = DBQuery::sql("SELECT mail FROM user WHERE id = '$_SESSION[user_id]' AND mail IS NOT NULL");
if(count($result) == 1)
	$profileMail = $result[0]["mail"];
else
	$profileMail = "";

$result = DBQuery::sql("SELECT address FROM user WHERE id = '$_SESSION[user_id]' AND address IS NOT NULL");
if(count($result) == 1)
	$profileAddress = $result[0]["address"];
else
	$profileAddress = "";

$result = DBQuery::sql("SELECT mail FROM user WHERE id = '$_SESSION[user_id]' AND mail IS NOT NULL");
if(count($result) == 1)
	$profileHomepage = $result[0]["mail"];
else
	$profileHomepage = "";

$result = DBQuery::sql("SELECT mail FROM user WHERE id = '$_SESSION[user_id]' AND mail IS NOT NULL");
if(count($result) == 1)
	$profileMajor = $result[0]["mail"];
else
	$profileMajor = "";

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

//When first submit button is pressed
if(isset($_POST['changeInfo'])) {
	$phoneNumber = DBQuery::safeString($_POST['phone_number']);
	$ssn = DBQuery::safeString($_POST['ssn']);
	$mail = DBQuery::safeString($_POST['mail']);
	$address = DBQuery::safeString($_POST['address']);
	$homepage = DBQuery::safeString($_POST['homepage']);
	$major = DBQuery::safeString($_POST['major']);
	$name = DBQuery::safeString($_POST['name']);
	$lastName = DBQuery::safeString($_POST['last_name']);
	$description = DBQuery::safeString($_POST['description']);

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

	if ($address != '') {
		if ($queryString != '')
			$queryString = $queryString . ", address='$address'";
		else
			$queryString = $queryString . "address='$address'";
	}

	if ($homepage != '') {
		// if ($queryString != '')
		// 	$queryString = $queryString . ", mail='$mail'";
		// else
		// 	$queryString = $queryString . "mail='$mail'";
	}

	if ($major != '') {
		// if ($queryString != '')
		// 	$queryString = $queryString . ", mail='$mail'";
		// else
		// 	$queryString = $queryString . "mail='$mail'";
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
			alert("Ditt nya liv är sparat!") 	 //TO DO: Proper user feedback
		</script>
		<?php

}

//When second submit button is pressed
if(isset($_POST['changePass'])) {

	$oldPassword = DBQuery::safeString($_POST['old_password']);
	$password = DBQuery::safeString($_POST['password']);
	$confPassword = DBQuery::safeString($_POST['confirmed_password']);

	//hash old password here
	$oldPasswordMD5 = md5('d98b05a7c7add6fa22b8de62444da5a5'.$oldPassword.'d99947dd2b0329f55babeaa6597fb7c8');
	$oldPasswordMD5 = md5($oldPasswordMD5);
	
	//validate old (hashed) password
	$result = DBQuery::sql("SELECT user_name FROM user WHERE id = '$_SESSION[user_id]' AND BINARY password = '$oldPasswordMD5'");
	if(count($result) == 1){

		//validate confirmed password
		if($password == $confPassword){

			//hash and apply new password
			$passwordMD5 = md5('d98b05a7c7add6fa22b8de62444da5a5'.$password.'d99947dd2b0329f55babeaa6597fb7c8');
			$passwordMD5 = md5($passwordMD5);

			DBQuery::sql("UPDATE user
				    	  SET password='$passwordMD5'
				  		  WHERE id='$_SESSION[user_id]'");

			?>
			<script>
				window.location = "?page=editProfile";		//TO DO: hard code url
				alert("Ditt lösenord är ändrat.") 	    //TO DO: Proper user feedback
			</script>
			<?php
		}
		else{
			?>
			<script>
				window.location = "?page=editProfile";		//TO DO: hard code url
				alert("Bekräftning av nytt lösenord stämmer inte, försök igen") //TO DO: Proper user feedback
			</script>
			<?php
			}
	}
	else{
		?>
		<script>
			window.location = "?page=editProfile";		//TO DO: hard code url
			alert("Det angivna nuvarande lösenordet är inkorrekt, försök igen") //TO DO: Proper user feedback
		</script>
		<?php
	}
}
?>
