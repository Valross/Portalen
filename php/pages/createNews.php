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

		if(isset($_POST['group']))
		{
			$group = $_POST['group'];
			if($group != '')
				mailToGroup($group, $title, $message);
		}

		// ?
		// <script>
		// 	window.location = "?page=news";
		// </script>
		// ?php
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

function loadGroupSelectable()
{

	echo '<label for="group">Skicka med mail till lag</label>
			<select name="group" id="group" class="bottom-border">
				<option id="typeno" value="typeno">Inget lag</option>';
	
	loadAllGroupsAsMailable();
	
	echo '</select>';	
	
}

function loadAllGroupsAsMailable()
{
	$groups = DBQuery::sql("SELECT id, name FROM work_group ORDER BY name");
	for($i = 0; $i < count($groups); ++$i)
	{
		echo '<option value="'.$groups[$i]['id'].'">'.$groups[$i]['name'].'</option>';
	}
}
?>