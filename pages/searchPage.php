<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1>Sökresultat</h1>
		</div>
	</div>
</div> <!-- .row -->

<?php

if(isset($_POST['submitSearch'])){ 
	if(preg_match("/[A-Za-z]+/", $_POST['search_term'])){ 
		$searchTerm = DBQuery::safeString($_POST['search_term']); 
		loadAllResults($searchTerm);
	}

	else{ 
		echo  "<p>Please enter a search query</p>"; 
	} 
}

?>
