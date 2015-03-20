<?php
include_once('php/DBQuery.php');

if(isset($_GET['dot_id']) && checkAdminAccess())
{
	$group_id = $_GET['group_id'];
	$dot_id = $_GET['dot_id'];

	DBQuery::sql("DELETE FROM dot
        					WHERE '$dot_id' = id");

	?>
		<script>
			window.location = "?page=browseDots&group_id=<?php echo $group_id; ?>";
			//alert("Uppbokad!")
		</script>
	<?php
}
else
{
	?>
		<script>
			window.location = "?page=start";
			alert("Något gick fel!")
		</script>
	<?php
}

?>