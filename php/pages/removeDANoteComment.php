<?php
include_once('php/DBQuery.php');

if(isset($_GET['da_note_id']) && isset($_GET['comment_id']) && checkAdminAccess() == 1)
{
	$da_note_id = $_GET['da_note_id'];
	$comment_id = $_GET['comment_id'];

	DBQuery::sql("DELETE FROM da_note_comments
        					WHERE '$comment_id' = id");

	?>
		<script>
			window.location = "?page=DANote&id=<?php echo $da_note_id; ?>";
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