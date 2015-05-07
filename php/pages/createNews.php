<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('Skapa nyhet');

if(isset($_POST['submit']) && checkAdminAccess() <= 1)
{
	$title = strip_tags($_POST['title']);
	$message = strip_tags($_POST['message'], allowed_tags());
	
	if($title != '' && $message != '')
	{
		DBQuery::sql("INSERT INTO news (title, message, date, user_id)
						VALUES ('$title', '$message', '$date', '$_SESSION[user_id]')");
		?>
		<script>
			window.location = "?page=news";
		</script>
		<?php
	}

	else
	{
		?>
		<script>
			window.location = "?page=start";
			alert("Fel: Du måste fylla i båda fält.")
		</script>
		<?php
	}
	
}
?>