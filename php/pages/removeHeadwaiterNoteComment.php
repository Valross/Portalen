<?php
include_once('php/DBQuery.php');

if(isset($_GET['headwaiter_note_id']) && isset($_GET['comment_id']) && checkAdminAccess())
{
	$headwaiter_note_id = $_GET['headwaiter_note_id'];
	$comment_id = $_GET['comment_id'];

	DBQuery::sql("DELETE FROM headwaiter_note_comments
        					WHERE '$comment_id' = id");

	?>
		<script>
			window.location = "?page=headwaiterNote&id=<?php echo $headwaiter_note_id; ?>";
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