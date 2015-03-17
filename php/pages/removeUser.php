<?php
include_once('php/DBQuery.php');

if(isset($_GET['user_id']) && checkAdminAccess())
{
	$user_id = $_GET['user_id'];

	?>
		<script>
			var r = confirm("Är du säker på att du vill ta bort användaren?");
			if (r == true) {
			    <?php
					DBQuery::sql("DELETE FROM user
			        					WHERE '$user_id' = id");
				?>
				window.location = "?page=start";
				alert("Användaren borttagen!")
			} else {
			    window.location = "?page=userProfile&id=<?php echo $user_id; ?>";
			}
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