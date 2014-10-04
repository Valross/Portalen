<?php
include_once('php/DBQuery.php');

if(isset($_POST['submit'])) {
	$user_name = $_POST['user_name']; //user name variable needed for WHERE clause?
	$ssn = $_POST['ssn'];
	
	//necessary?
	$ssn = mysql_real_escape_string($ssn);
	$user_name = mysql_real_escape_string($user_name);

	//control
	echo "ssn = " . $ssn;

	//add later:
	//if($userName != '' && $password != '' && $ssn != '' && $mail != '' && $name != '' && $lastName != '')
	//{
		DBQuery::sql("UPDATE user
					SET ssn = '$ssn'
					WHERE user_name = '$user_name'");

		?>
		<script>
			window.location = "?page=edit-profile";
		</script>
		<?php
	//}
	
}
?>