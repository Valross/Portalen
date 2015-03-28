<?php
include_once('php/DBQuery.php');
loadTitleForBrowser('Sökresultat');

	function loadAllResults($searchString){
		
		// Get results
		$users = DBQuery::sql("SELECT id, name, last_name, mail FROM user 
	   			 WHERE name LIKE '%" . $searchString . "%' OR last_name LIKE '%" . $searchString  ."%'");
		$events = DBQuery::sql("SELECT id, name, start_time FROM event WHERE name LIKE '%" . $searchString . "%'");
		$teams = DBQuery::sql("SELECT id, name FROM work_group WHERE name LIKE '%" . $searchString . "%'");

		// if(isset($_GET['pageNumber']))
		// 	$currentPage = $_GET['pageNumber'];
		// else
		// 	$currentPage = 0;

		// $itemsPerPage = 4;
		// $totalItems = count($users) + count($events) + count($teams);
		// $lastPage = ceil(($totalItems / $itemsPerPage))-1;
		// $startItem = $currentPage * $itemsPerPage;

				echo '<p>Användare: </p>';
				displayUsers($searchString, $users);

				echo '<p>Evenemang: </p>';
				displayEvents($searchString, $events);

				echo '<p>Lag: </p>';
				displayTeams($searchString, $teams);


		// if($currentPage <= $lastPage) {
		// 	for($i = $startItem; $i < $startItem + $itemsPerPage && $i < $count($...); ++$i) { //i varje funktion?

		// 		funktioner
		
		// 		loadPageNumbers($currentPage, $lastPage, 'searchPage', '');
		// 	}
		// }

	}

	function displayUsers($searchString, $users){
		for($i=0; $i < count($users); ++$i){ 
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

  	function displayEvents($searchString, $events){
	   	for($i=0; $i < count($events); ++$i){ 
        	$eventName = $events[$i]['name'];
        	$eventId = $events[$i]['id'];
        	$date = $events[$i]['start_time'];

  			echo "<ul>\n"; 
  			echo "<li>" . "<a href=\"?page=event&id=$eventId\">" . $eventName . ", " . $date . "</a></li>\n"; 
  			echo "</ul>"; 
  		}
  	}

  	function displayTeams($searchString, $teams){
	   	for($i=0; $i < count($teams); ++$i){ 
        	$teamName = $teams[$i]['name'];
        	$teamId =  $teams[$i]['id'];

  			echo "<ul>\n"; 
  			echo "<li>" . "<a href=\"?page=group&id=$teamId\">" . $teamName . "</a></li>\n"; 
  			echo "</ul>"; 
  		} 
	}

?>