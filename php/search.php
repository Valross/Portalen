<form  method="post" action="search.php?go"  id="searchform"> 
	<input  type="text" name="name"> 
	<input  type="submit" name="submitSearch" value="Search"> 
</form>

<?php
include_once('DBQuery.php');

if(isset($_POST['submitSearch'])){ 
	if(isset($_GET['go'])){
		if(preg_match("/[A-Za-z]+/", $_POST['name'])){ 
		   $name=$_POST['name']; 

		   $result = DBQuery::sql("SELECT id, name, last_name, mail FROM user WHERE name LIKE '%" . $name . "%' OR last_name LIKE '%" . $name  ."%'"); 

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
		}   
	}
}
		else{ 
			echo  "<p>Please enter a search query</p>"; 
		} 
?>