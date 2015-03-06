<!-- <form  method="post" action="search.php?go"  id="searchform"> 
	<input type="text" name="name"> 
	<input type="submit" name="submitSearch" value="Search"> 
</form> -->

<?php
include_once('DBQuery.php');

if(isset($_POST['submitSearch'])){ 
	if(isset($_GET['go'])){
		if(preg_match("/[A-Za-z]+/", $_POST['search_term'])){ 
		   
		   $searchTerm=DBQuery::safeString($_POST['search_term']); 

		   // USERS
		   $result = DBQuery::sql("SELECT id, name, last_name, mail FROM user 
		   			 WHERE name LIKE '%" . $search_term . "%' OR last_name LIKE '%" . $search_term  ."%'"); 
		   for($i=0; $i < count($result); ++$i){ 
	        	$firstName = $result[$i]['name']; 
	        	$lastName = $result[$i]['last_name']; 
	        	$id = $result[$i]['id']; 
	        	$mail = $result[$i]['mail']; 

	  			// display result of array
	  			echo "<ul>\n"; 
	  			echo "<li>" . "<a href=\"search.php?id=$id\">" . $firstName . " " . $lastName . "</a></li>\n"; 
	  			echo "<li>" . "<a href=mailto:" . $mail . ">" . $mail . "</a></li>\n"; 
	  			echo "</ul>"; 
	  		} 

	  		// TEAMS

	  		// EVENTS

	  		// UH...ACHIEVEMENTS?
		}   
	}
}

else{ 
	echo  "<p>Please enter a search query</p>"; 
} 

?>