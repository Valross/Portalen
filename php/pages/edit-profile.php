<?php
include_once('php/DBQuery.php');

if(isset($_POST['submit'])) {
	$user_name = $_POST['user_name'];	//gets empty string wtf
/*	$ssn = $_POST['ssn'];
	$mail = $_POST['mail'];
	$name = $_POST['name'];
	$lastName = $_POST['last_name'];
*/	
	//control
	if(empty($_POST['userName']))
		echo "empty";
	else
		echo "userName = " + $user_name;
	/*   "ssn = " . $ssn + \n +
		 "mail = " . $mail + \n +
		 "name = " . $name + \n +
		 "lastName = " . $lastName;
	*/


	/*	necessary?
	$userName = mysql_real_escape_string($userName);
	$ssn = mysql_real_escape_string($ssn);
	$mail = mysql_real_escape_string($mail);
	$name = mysql_real_escape_string($name);
	$lastName = mysql_real_escape_string($lastName);	*/
	

/*
	//if($userName != '' && $ssn != '' && $mail != '' && $name != '' && $lastName != ''){
	DBQuery::sql("UPDATE user
				  SET ssn='$ssn', mail='$mail', name='$name', lastName='$lastName'
				  WHERE user_name='$userName'");

		?>
		<script>
			window.location = "?page=edit-profile";
		</script>
		<?php
*/
	//}
	/*
	else{
		?>
		<script>
		alert("error: empty fields","");
		</script>
		<?php
	}*/
	
}
?>