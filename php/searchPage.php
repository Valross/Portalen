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
		   			 WHERE name LIKE '%" . $searchTerm . "%' OR last_name LIKE '%" . $searchTerm  ."%'"); 
		   echo "<p>Användare: </p>";
		   
		   for($i=0; $i < count($result); ++$i){ 
	        	$firstName = $result[$i]['name']; 
	        	$lastName = $result[$i]['last_name']; 
	        	$userId = $result[$i]['id']; 
	        	$userMail = $result[$i]['mail']; 

	  			// display results
	  			echo "<ul>\n"; 
	  			echo "<li>" . "<a href=\"../?page=profile&id=$userId\">" . $firstName . " " . $lastName . "</a></li>\n"; 
	  			echo "<li>" . "<a href=mailto:" . $userMail . ">" . $userMail . "</a></li>\n"; 
	  			echo "</ul>"; 
	  		} 

	  		// EVENTS
			$result = DBQuery::sql("SELECT id, name, start_time FROM event WHERE name LIKE '%" . $searchTerm . "%'"); 
			echo "<p>Evenemang: </p>";

		   	for($i=0; $i < count($result); ++$i){ 
	        	$eventName = $result[$i]['name'];
	        	$eventId = $result[$i]['id'];
	        	$date = $result[$i]['start_time'];

	  			// display results
	  			echo "<ul>\n"; 
	  			echo "<li>" . "<a href=\"../?page=event&id=$eventId\">" . $eventName . ", " . $date . "</a></li>\n"; 
	  			echo "</ul>"; 
	  		} 

	  		// TEAMS
	  		$result = DBQuery::sql("SELECT id, name FROM work_group WHERE name LIKE '%" . $searchTerm . "%'"); 
			echo "<p>Lag: </p>";

		   	for($i=0; $i < count($result); ++$i){ 
	        	$teamName = $result[$i]['name'];
	        	$teamId =  $result[$i]['id'];

	  			// display results
	  			echo "<ul>\n"; 
	  			echo "<li>" . "<a href=\"../?page=group&id=$teamId\">" . $teamName . "</a></li>\n"; 
	  			echo "</ul>"; 
	  		} 

	  		// NEWS
	  		$result = DBQuery::sql("SELECT title, message FROM news WHERE title LIKE '%" . $searchTerm . "%'"); 
			echo "<p>Nyheter: </p>";

		   	for($i=0; $i < count($result); ++$i){ 
	        	$newsTitle = $result[$i]['title'];
	        	$newsMessage =  $result[$i]['message'];

	  			// display results
	  			echo "<ul>\n"; 
	  			echo "<li>" . $newsTitle . "</li>\n"; 
	  			echo "<li>" . $newsMessage . "</li>\n";
	  			echo "</ul>"; 
	  		}

	  		// UH...ACHIEVEMENTS?
		}   
	}
}

else{ 
	echo  "<p>Please enter a search query</p>"; 
} 

?>