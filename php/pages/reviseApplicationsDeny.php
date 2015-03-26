<?php
include_once('php/DBQuery.php');

if(isset($_GET['id']) && checkAdminAccess() == 1){
	$appId=$_GET['id'];

	// echo "ID = " . $appId;


	//remove applicant from applications
	DBQuery::sql("DELETE FROM application WHERE id='$appId'");
	DBQuery::sql("DELETE FROM application_group WHERE application_id='$appId'");

	//send confirmation email
	//...
	
	?>
		<script>
			window.location = "?page=reviseApplications";
			alert("Nekad!")
		</script>
	<?php
}
else{
	?>
		<script>
			window.location = "?page=reviseApplications";
			alert("Något gick fel!");
		</script>
	<?php
}

?>