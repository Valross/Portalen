<?php
include_once('php/DBQuery.php');

if(isset($_POST['submit']))
{
	$title = $_POST['title'];
	$message = $_POST['message'];
	
	if($title != '' && $message != '')
	{
		DBQuery::sql("INSERT INTO news (title, message, date, user_id)
						VALUES ('$title', '$message', '$date', '$_SESSION[user_id]')");
		?>
		<script>
			window.location = "?page=start";
		</script>
		<?php
	}
	
}
?>