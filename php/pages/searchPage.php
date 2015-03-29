<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('Sökresultat');

	function loadAllResults($searchString){
		
		// TO DO: limit query to specific page to save performance
		$results = DBQuery::sql("SELECT id, name, last_name, 'user' as source_table FROM user WHERE name LIKE '%" . $searchString . "%' OR last_name LIKE '%" . $searchString  ."%'
			UNION
			SELECT id, name, start_time, 'event' as source_table FROM event WHERE name LIKE '%" . $searchString . "%' 
			UNION
			SELECT id, name, Null as col3, 'team' as source_table FROM work_group WHERE name LIKE '%" . $searchString . "%' ");

		$currentpage = 0;

		if(isset($_GET['pageNumber']))
			$currentPage = $_GET['pageNumber'];

		$itemsPerPage = 3;
		$totalItems = count($results);
		$lastPage = ceil(($totalItems / $itemsPerPage))-1;
		$startItem = $currentPage * $itemsPerPage;

		if($currentPage <= $lastPage) {
			for($i = $startItem; $i < $startItem + $itemsPerPage && $i < count($results); ++$i) {
	  			$sourceTable = $results[$i]['source_table'];
	  			// echo "source = " . $sourceTable;

	  			if($sourceTable == 'user'){
		  			$firstName = $results[$i]['name']; 
		        	$lastName = $results[$i]['last_name']; 
		        	$userId = $results[$i]['id'];

					echo "<ul>\n"; 
		  			echo "<li><a href=\"?page=userProfile&id=$userId\">" . $firstName . " " . $lastName . "</a></li>\n"; 
		  			echo "</ul>"; 	
	  			}

	  			else if ($sourceTable == 'event'){
	  				$eventName = $results[$i]['name'];
		        	$eventId = $results[$i]['id'];
		        	$date = $results[$i]['start_time'];

		        	echo "<ul>\n";
		  			echo "<li><a href=\"?page=event&id=$eventId\">" . $eventName . ", " . $date . "</a></li>\n"; 
		  			echo "</ul>";
	  			}

	  			else {  //team
	  				$teamName = $results[$i]['name'];
		        	$teamId =  $results[$i]['id'];

		        	echo "<ul>\n";
		  			echo "<li><a href=\"?page=group&id=$teamId\">" . $teamName . "</a></li>\n"; 
		  			echo "</ul>";
	  			}
	  			
  			}

				loadPageNumbers($currentPage, $lastPage, 'searchPage', '&query='.$searchString);
		
		}
			

	}

	function displayUsers($searchString, $users, $startItem, $itemsPerPage){
		for($i = $startItem; $i < $startItem + $itemsPerPage && $i < count($users); ++$i) {
	        	$firstName = $users[$i]['name']; 
	        	$lastName = $users[$i]['last_name']; 
	        	$userId = $users[$i]['id']; 
	        	$userMail = $users[$i]['mail']; 

	  			echo "<ul>\n"; 
	  			echo "<li>" . "<a href=\"?page=userProfile&id=$userId\">" . $firstName . " " . $lastName . "</a></li>\n"; 
	  			echo "<li>" . "<a href=mailto:" . $userMail . ">" . $userMail . "</a></li>\n"; 
	  			echo "</ul>"; 
  		}
  	}

  	function displayEvents($searchString, $events, $startItem, $itemsPerPage){
	   	for($i = $startItem; $i < $startItem + $itemsPerPage && $i < count($events); ++$i) {
        	$eventName = $events[$i]['name'];
        	$eventId = $events[$i]['id'];
        	$date = $events[$i]['start_time'];

  			echo "<ul>\n"; 
  			echo "<li>" . "<a href=\"?page=event&id=$eventId\">" . $eventName . ", " . $date . "</a></li>\n"; 
  			echo "</ul>"; 
  		}
  	}

  	function displayTeams($searchString, $teams, $startItem, $itemsPerPage){
	   	for($i=0; $i < count($teams); ++$i){ 
        	$teamName = $teams[$i]['name'];
        	$teamId =  $teams[$i]['id'];

  			echo "<ul>\n"; 
  			echo "<li>" . "<a href=\"?page=group&id=$teamId\">" . $teamName . "</a></li>\n"; 
  			echo "</ul>"; 
  		} 
	}

?>