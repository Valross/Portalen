<div class="row">
	<div class="col-sm-12">
		<div class="page-header">
			<h1>Sökresultat</h1>
		</div>
	</div>
</div> <!-- .row -->

<div class="row">
<?php
if(isset($_POST['submitSearch'])){ 
	if(preg_match("/[A-Za-z]+/", $_POST['search_term'])){ 
		$searchString = DBQuery::safeString($_POST['search_term']); 
		echo '<div class="col-sm-6">
					<div class="white-box">';
		loadAllResults($searchString);
		echo '</div>
				</div>';
	}

	else{ 
		echo  "<p>Please enter a search query</p>"; 
	} 
}

else if(isset($_GET['query'])){ 
	if(preg_match("/[A-Za-z]+/", $_GET['query'])){ 
		$searchString = DBQuery::safeString($_GET['query']); 
		echo '<div class="col-sm-7">
					<div class="white-box">';
		loadAllResults($searchString);
		echo '</div>
				</div>';
	}

	else{ 
		echo  "<p>Please enter a search query</p>"; 
	} 
}

else
	echo "form inte satt";

?>
</div>