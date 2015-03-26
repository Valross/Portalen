<?php
include_once('php/DBQuery.php');

if(isset($_GET['protocol_id']) && checkAdminAccess() == 1)
{
	$group_id = $_GET['group_id'];
	$protocol_id = $_GET['protocol_id'];

	DBQuery::sql("DELETE FROM protocol
        					WHERE '$protocol_id' = id");

	?>
		<script>
			window.location = "?page=browseProtocol&group_id=<?php echo $group_id; ?>";
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