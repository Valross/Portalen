<?php
include_once('php/DBQuery.php');

if(isset($_GET['event_id']) && isset($_GET['comment_id']) && checkAdminAccess() <= 1)
{
	$event_id = $_GET['event_id'];
	$comment_id = $_GET['comment_id'];

	DBQuery::sql("DELETE FROM event_comments
        					WHERE '$comment_id' = id");

	?>
		<script>
			window.location = "?page=event&id=<?php echo $event_id; ?>";
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