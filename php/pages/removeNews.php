<?php
include_once('php/DBQuery.php');

if(isset($_GET['news_id']) && checkAdminAccess() <= 1)
{
	$news_id = $_GET['news_id'];

	DBQuery::sql("DELETE FROM news
        					WHERE '$news_id' = id");

	?>
		<script>
			window.location = "?page=news";
			//alert("Uppbokad!")
		</script>
	<?php
}
else
{
	?>
		<script>
			window.location = "?page=book";
			alert("Något gick fel!")
		</script>
	<?php
}

?>