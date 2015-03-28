<?php

if(isset($_POST['submitSearch'])){ 
	if(preg_match("/[A-Za-z]+/", $_POST['search_term'])){ 
	   $searchTerm = DBQuery::safeString($_POST['search_term']); 

?>
	
	<p>Användare: </p>
	<?php searchUsers($searchTerm); ?>

	<p>Evenemang: </p>
	<?php searchEvents($searchTerm); ?>

	<p>Lag: </p>
	<?php searchTeams($searchTerm); ?>

<?php

	}else{ 
		echo  "<p>Please enter a search query</p>"; 
	} 
}

?>
