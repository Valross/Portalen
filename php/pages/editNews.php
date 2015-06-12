<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('Redigera nyhet');

if(isset($_POST['submit']) && checkAdminAccess() <= 1)
{
	$news_id = $_GET['news_id'];
	$title = strip_tags($_POST['title']);
	$message = strip_tags($_POST['message'], allowed_tags());
	
	if($title != '' && $message != '')
	{
		DBQuery::sql("UPDATE news
			  SET title = '$title', message = '$message',
			  		last_edit = '$date'
			  WHERE id = '$news_id'");
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

function loadFormContent()
{
	$news_id = $_GET['news_id'];
	$news = DBQuery::sql("SELECT id, title, message, user_id FROM news 
						WHERE id = '$news_id'");

	if($news[0]['user_id'] == $_SESSION['user_id'] || checkAdminAccess() < 1)
	{
		echo '<label for="title">Titel</label>
			<input type="text" placeholder="Nyhetsbrev Maj" name="title" id="title" value="'.$news[0]['title'].'">
			<label for="message">Meddelande</label>
			<textarea rows="7" cols="50" value="" name="message" id="message" maxlength="1500"
				class="bottom-border">'.$news[0]['message'].'</textarea>
			<input type="submit" name="submit" value="Uppdatera nyhet">';
	}
	else
	{
		?>
		<script>
			window.location = "?page=start";
			alert("Sluta försöka hacka sidan!")
		</script>
		<?php
	}	
}

?>